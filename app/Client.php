<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'gender',
        'age',
        'country',
        'fb',
        'phone',
        'email',
        'preflang',
        'addby',
        'respon_id',
        'statu',
        'tries',
        'notes',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
    protected $dates = ['deleted_at'];

    public function respon_idd() {
		return $this->hasOne('App\Client', 'id', 'respon_id');
    }
    
    public function respon()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function tries_name($id)
    {
        $try_user  = \App\User::find($id);
        if (!$try_user)
        $try_user = (object) ['name' => '<small><b>Deleted User...</b></small>'];
        return $try_user;
    }

}
