<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Puestos extends Model
{
    use SoftDeletes;
    protected $table = 'puestos';
}
