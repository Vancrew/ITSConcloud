<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    public function nota()
    {
        return $this->belongsTo('App\Nota');
    }

    public function konsumen()
    {
        return $this->belongsTo('App\Konsumen', 'nota_konsumen_id');
    }
}
