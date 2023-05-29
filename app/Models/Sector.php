<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Clue\StreamFilter\fun;

class Sector extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'sectors';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'title', 'title_ru', 'title_tk', 'venue_id','order'
    ];
    // protected $hidden = [];
    // protected $dates = [];
    protected $appends = ['has_tickets'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function hasTickets($tickets):bool{

        return $tickets->contains(function($value,$key){
            return $value->section->sector_id == $this->id;
        });
    }

    public function filterTickets($tickets){
        return $tickets->filter(function($value,$key){
            return $value->section->sector_id == $this->id;
        })->sortBy('section.order');
    }

    public function getHasTicketsAttribute(){
        if (count($this->sections->tickets) > 0){
            return true;
        }
        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function venue(){
        return $this->belongsTo(Venue::class);
    }

    public function sections(){
        return $this->hasMany(Section::class);
    }
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
}
