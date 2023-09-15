<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recommandation extends Model
{
    protected $fillable = ['title', 'date_recom', 'id_entreprise','id_entreprise_recom','comment','etat_recom'];


    // use HasFactory;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'recommandation';


    // cle etranger
    public function user()
    {
        return $this->hasOne('App\User','id','id_entreprise');
    }

    public function user_recom()
    {
        return $this->hasOne('App\User','id','id_entreprise_recom');
    }

}
