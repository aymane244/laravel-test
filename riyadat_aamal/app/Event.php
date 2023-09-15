<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'title', 'start', 'end','id_entreprise','id_entreprise_rendez_vous','etat_rendez_vous'];

    // cle etranger
    public function user()
    {
        return $this->hasOne('App\User','id','id_entreprise');
    }

    public function user_rendez_vous()
    {
        return $this->hasOne('App\User','id','id_entreprise_rendez_vous');
    }

}
