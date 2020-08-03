<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    //
    protected $table = 'career';

    
    public function career(){
        return $this->hasMany('App\Career');
    }

}
