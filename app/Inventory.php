<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';

    public function jenis()
    {
        return $this->belongsTo('App\Jenis');
    }

    public function modal()
    {
        return $this->belongsTo('App\Modal');
    }

    public function transaksi()
    {
        return $this->hasMany('App\ItemTransaksi');
    }

    public function scopeAvailable($query)
    {
        return $query->where('jumlah_aktual', '>', 0);
    }
}
