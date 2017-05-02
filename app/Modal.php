<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modal extends Model
{
    protected $table = 'modal';

    public function inventory()
    {
        return $this->hasMany('App\Inventory');
    }

    public function produsen()
    {
        return $this->belongsTo('App\Produsen');
    }
}
