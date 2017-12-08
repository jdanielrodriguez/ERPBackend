<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleados extends Model
{
    use SoftDeletes;
    protected $table = 'empleados';

    public function puestos(){
        return $this->hasOne('App\Puestos','id','puesto');
    }
}
