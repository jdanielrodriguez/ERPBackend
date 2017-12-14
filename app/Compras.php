<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compras extends Model
{
    use SoftDeletes;
    protected $table = 'compras';
    
    public function detalle(){
        return $this->hasMany('App\ComprasDetalle','compra','id')->with('productos');
    }

    public function proveedores(){
        return $this->hasOne('App\Proveedores','id','proveedor');
    }

    public function tipos(){
        return $this->hasOne('App\TiposCompra','id','tipo');
    }
}
