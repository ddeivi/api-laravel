<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Studies extends Model
{
    //

    protected $table = 'studies';

    public function studies(){
        return $this->hasMany('App\Studies');
    }

    public function career(){
        return $this->belongsTo('App\Career', 'idCareer');
    }

    public function semester(){
        return $this->belongsTo('App\Semester', 'idSemester');
    }

  

}
