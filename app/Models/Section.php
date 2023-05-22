<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class Section extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'sections';
    // protected $primaryKey = 'id';
    public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'section_no',
        'section_no_ru',
        'section_no_tk',
        'description',
        'description_ru',
        'description_tk',
        'venue_id',
        'seats',
        'section_image',
        'sector_id'
    ];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = ['seats' => 'array'];
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            $disk = config('filesystems.default');
            \Storage::disk($disk)->delete($obj->section_image);
        });
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function venue(){
        return $this->belongsTo(Venue::class);
    }

    public function sector(){
        return $this->belongsTo(Sector::class);
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function getSectionNoAttribute(){
        return $this->{'section_no_'.Config::get('app.locale')};
    }

    public function getDescriptionAttribute(){
        return $this->{'description_'.Config::get('app.locale')};
    }

    public function setSectionImageAttribute($value){
        $attribute_name = "section_image";
        $disk = config('filesystems.default'); // or use your own disk, defined in config/filesystems.php
        $destination_path = "venues"; // path relative to the disk above

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image'))
        {
            // 0. Make the image
            $image = \Image::make($value)->encode('jpg', 90);
            // 1. Generate a filename.
            $filename = md5($value.time()).'.jpg';
            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            // 3. Save the public path to the database
            // but first, remove "public/" from the path, since we're pointing to it from the root folder
            // that way, what gets saved in the database is the user-accesible URL
            $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
            $this->attributes[$attribute_name] = $public_destination_path.'/'.$filename;
        }
    }
}
