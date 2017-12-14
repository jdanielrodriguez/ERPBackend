<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventario extends Model
{
    use SoftDeletes;
    protected $table = 'inventario';

    public function productos(){
        return $this->hasOne('App\Productos','id','producto');
    }
}
