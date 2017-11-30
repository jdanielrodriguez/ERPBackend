<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuentasCobrar extends Model
{
    use SoftDeletes;
    protected $table = 'cuentascobrar';
}
