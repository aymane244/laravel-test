<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Factories\HasFactory;


class message extends Model
{
    // use HasFactory;

    protected $fillable = [
        'from', 'to', 'message','file_message', 'is_read'
      ];

      // cle etranger
    public function user_from()
    {
        return $this->hasOne('App\User','id','from');
    }

    public function user_to()
    {
        return $this->hasOne('App\User','id','to');
    }
}
