<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    //
    protected $table = 'lists';

    public function lists(){
        return $this->hasMany('App\Lists');
    }

    
 
    public function candidates()
    {
        return $this->belongsTo('App\Candidates', 'idCandidate');
    }

}
