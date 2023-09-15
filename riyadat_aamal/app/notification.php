<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    protected $fillable = ['from', 'to', 'message','is_read','etat','date'];


    // use HasFactory;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notifications';
}
