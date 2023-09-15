<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['nom_complet', 'email', 'objet','message'];
    // use HasFactory;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contact';
}
