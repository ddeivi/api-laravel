<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    //
    protected $table = 'SEMESTER';

    
    public function semester(){
        return $this->hasMany('App\Semester');
    }


}
