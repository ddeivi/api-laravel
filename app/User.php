<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identification_card','name', 'lastname','email', 'password','image','id_role','id_study','vote'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function study(){
        return $this->belongsTo('App\Studies', 'idStudy');
    }

    public function career(){
        return $this->belongsTo('App\Career', 'idCareer');
    }

    public function semester(){
        return $this->belongsTo('App\Semester', 'idSemester');
    }

    public function role(){
        return $this->belongsTo('App\Roles', 'idRole');
    }



}
