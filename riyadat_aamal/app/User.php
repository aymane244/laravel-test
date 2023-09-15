<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    // use HasFactory;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'entreprise';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','tele','adress', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // clé etranger
    public function event()
    {
        return $this->belongsTo('App\Event', 'id');
    }
    public function recommandation()
    {
        return $this->belongsTo('App\Recommandation', 'id');
    }
    // one to one
    public function chat_message()
    {
        return $this->belongsTo('App\message', 'id');
    }


    // join Group model with User models
	public function group()
    {
        return $this->belongsToMany('App\Group', 'admin_id');
    }
    // join 3 models User , Group, group_participant according user_id and group_id
    public function group_member()
    {
        return $this->belongsToMany('App\Group', 'group_participants', 'user_id', 'group_id')->orderBy('updated_at', 'desc');
    }
    // join User model with message model         groupe message
    public function message()
    {
        return $this->hasMany('App\message_group', 'user_id');
    }
    public function message_from()
    {
        return $this->belongsTo('App\message_group', 'id');
    }


}
