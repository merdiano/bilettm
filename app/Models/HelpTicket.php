<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Str;

class HelpTicket extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'help_tickets';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['code','email','name','phone','text','subject', 'attachment','status','ticket_category_id'];
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

    public function category(){
        return $this->belongsTo(HelpTopic::class,'ticket_category_id');
    }

    public function comments(){
        return $this->hasMany(HelpTicketComment::class);
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setAttachmentAttribute($value){
        $attribute_name = "attachment";
        $disk = config('filesystems.default'); // or use your own disk, defined in config/filesystems.php
        $destination_path = "help"; // path relative to the disk above
        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

    }
    /**
     * Boot all of the bootable traits on the model.
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            $ticket->code = strtoupper(str_random(5)) . date('jn');
        });

        static::deleting(function($obj) {
            $disk = config('filesystems.default');
            \Storage::disk($disk)->delete($obj->seats_image);

            if (count((array)$obj->images)) {
                foreach ($obj->images as $file_path) {
                    \Storage::disk('uploads')->delete($file_path);
                }
            }
        });
    }
}
