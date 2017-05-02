<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produsen extends Model
{
    use SoftDeletes;

    protected $table = 'produsen';

    protected $guarded = [];
}
