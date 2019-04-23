<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ventas extends Model
{
    use SoftDeletes;
    protected $table = 'ventas';

    public function detalle(){
        return $this->hasMany('App\VentasDetalle','venta','id')->with('productos');
    }

    public function clientes(){
        return $this->hasOne('App\Clientes','id','cliente');
    }

    public function tipos(){
        return $this->hasOne('App\TiposVenta','id','tipo');
    }

    public function vehiculos(){
        return $this->hasMany('App\Vehiculos','vehiculo','id');
    }
}
