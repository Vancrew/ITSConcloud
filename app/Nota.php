<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $table = 'nota';

    public function konsumen()
    {
        return $this->belongsTo('App\Konsumen');
    }

    public function pembayaran()
    {
        return $this->hasMany('App\Pembayaran');
    }

    public function item_transaksi()
    {
        return $this->hasMany('App\ItemTransaksi');
    }

    public function operasional()
    {
        return $this->hasMany('App\RiwayatOperasional');
    }
}
