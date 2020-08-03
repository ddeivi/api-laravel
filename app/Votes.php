<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Votes extends Model
{
    //
    protected $table = 'votes';

    public function votes(){
        return $this->hasMany('App\Votes');
    }

    public function list()
    {
        return $this->belongsTo('App\Lists','idList');
    }

}
