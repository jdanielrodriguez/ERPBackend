<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuentasPagar extends Model
{
    use SoftDeletes;
    protected $table = 'cuentaspagar';

    public function compras(){
        return $this->hasOne('App\Compras','id','compra')->with('proveedores','tipos');
    }

    public function movimientos(){
        return $this->hasMany('App\MovimientosP','cuentapagar','id');
    }
}
