<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Str;

class HelpTicketComment extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'help_ticket_comments';
    // protected $primaryKey = 'id';
     public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = ['text','attachment','parent_id','user_id','name','help_ticket_id'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function ticket(){
        return $this->belongsTo(HelpTicket::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
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

    public function getOwnerAttribute(){
        return $this->user->full_name ?? $this->name;
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    //todo use trait for image upload
    public function setAttachmentAttribute($file){
        $attribute_name = "attachment";
        $disk = config('filesystems.default'); // or use your own disk, defined in config/filesystems.php
        $destination_path = "help"; // path relative to the disk above

        if($file){
            $filename = md5($file.time()) . '.' . strtolower($file->getClientOriginalExtension());
            // 2. Move the new file to the correct path
            $file_path = $file->storeAs($destination_path, $filename, $disk);

            $this->attributes[$attribute_name] = $file_path;
        }
    }

    /**
     * Boot all of the bootable traits on the model.
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function($obj) {
            $disk = config('filesystems.default');
            \Storage::disk($disk)->delete($obj->seats_image);

        });
    }
}
