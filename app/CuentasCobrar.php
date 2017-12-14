<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuentasCobrar extends Model
{
    use SoftDeletes;
    protected $table = 'cuentascobrar';
    
        public function ventas(){
            return $this->hasOne('App\Ventas','id','venta')->with('clientes','tipos');
        }
    
        public function movimientos(){
            return $this->hasMany('App\MovimientosC','cuentacobrar','id');
        }
}
