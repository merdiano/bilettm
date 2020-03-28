<?php
/**
 * Created by PhpStorm.
 * User: merdan
 * Date: 12/9/2018
 * Time: 9:52 PM
 */

namespace App\Models;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Category extends \Illuminate\Database\Eloquent\Model{
    use \Backpack\CRUD\CrudTrait;
    /**
     * Indicates whether the model should be timestamped.
     *
     * @var bool $timestamps
     */
    public $timestamps = false;
    /**
     * The database table used by the model.
     *
     * @var string $table
     */
    protected $table = 'categories';
    /**
     * Indicates whether the model should use soft deletes.
     *
     * @var bool $softDelete
     */
    protected $softDelete = false;
    protected $fillable = ['title_tk','title_ru','view_type','lft','rgt','parent_id','depth','events_limit'];

    /**
     * Get the url of the event.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
//        switch ($this->view_type){
//            case 'concert' : $rout_name = "showSubCategoryEventsPage";
//                break;
//            default : $rout_name = "showCategoryEventsPage";
//                break;
//        }
        if($this->parent_id > 0)
            $rout_name = 'showSubCategoryEventsPage';
        else
            $rout_name = "showCategoryEventsPage";

        return route($rout_name, ["cat_id"=>$this->id, "cat_slug"=>Str::slug($this->title)]);
        //return URL::to('/') . '/e/' . $this->id . '/' . Str::slug($this->title);
    }

    public function customUrl($qs = array()){
        $url = $this->url;
        foreach($qs as $key => $value){
            $qs[$key] = sprintf('%s=%s',$key, urlencode($value));
        }
        return sprintf('%s?%s', $url, implode('&', $qs));
    }

    public function getTitleAttribute(){

        return $this->{'title_'.Config::get('app.locale')};
    }
    /**
     * The events associated with the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events(){
        return $this->hasMany(\App\Models\Event::class);
    }

    public function cat_events(){
        $locale = Config::get('app.locale');
        return $this->hasMany(\App\Models\Event::class,'sub_category_id')
            ->select('id','sub_category_id',"title_{$locale}","description_{$locale}",'start_date')
            ->withCount(['stats as views' => function($q){
                $q->select(DB::raw("SUM(views) as v"));
            }]);
    }

    public function scopeCategoryLiveEvents($query,$limit,$view){
//        dd($this->view_type);
        return $query->select('id','title_tk','title_ru','view_type')
            ->where('view_type',$view)
            ->orderBy('lft')
            ->with(['events' => function($q) use($limit){
            $q->select('id','title_'.Config::get('app.locale'),'description_'.Config::get('app.locale'),'category_id','sub_category_id','start_date')
                ->limit($limit)
                ->with('starting_ticket')
                ->withCount(['stats as views' => function($q){
                    $q->select(DB::raw("SUM(views) as v"));
                }])
                ->onLive();
        }]);
    }

    public function parent(){
        return $this->belongsTo(Category::class,'parent_id');
    }

    public function children(){
        return $this->hasMany(Category::class,'parent_id')
            ->select('id','title_'.Config::get('app.locale'),'parent_id','lft')
            ->orderBy('lft');
    }
    public function scopeMain($query){
        return $query->where('depth',1)->orderBy('lft','asc');
    }

    public function scopeSub($query){
        return $query->where('depth',2)->orderBy('lft','asc');
    }

    public function scopeChildren($query,$parent_id){
        return $query->where('parent_id',$parent_id)->orderBy('lft','asc');
    }

    public function scopeWithLiveEvents($query, $orderBy, $start_date = null,$end_date = null, $limit = 8 ){
        return $query->with(['cat_events' => function($query) use ($start_date, $end_date, $limit, $orderBy) {
            $query->select('id','title_'.Config::get('app.locale'),'description_'.Config::get('app.locale'),'category_id','sub_category_id','start_date')
               ->take($limit)
               ->with('starting_ticket')
               ->withCount(['stats as views' => function($q){
                   $q->select(DB::raw("SUM(views) as v"));}])
               ->onLive($start_date, $end_date)//event scope onLive get only live events
               ->orderBy($orderBy['field'],$orderBy['order']);
        }]);

    }

}
