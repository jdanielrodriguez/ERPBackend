<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comisiones extends Model
{
    use SoftDeletes;
    protected $table = 'comisiones';
}
