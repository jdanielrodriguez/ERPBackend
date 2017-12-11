<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accesos extends Model
{
    use SoftDeletes;
    protected $table = 'accesos';

    public function modulos(){
        return $this->hasOne('App\Modulos','id','modulo');
    }
}
