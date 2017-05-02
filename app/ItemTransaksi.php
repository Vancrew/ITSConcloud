<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemTransaksi extends Model
{
    protected $table = 'item_transaksi';

    public function inventory()
    {
        return $this->belongsTo('App\Inventory', 'inventory_id');
    }

    public function jenis()
    {
        return $this->belongsTo('App\Jenis', 'inventory_jenis');
    }

    public function nota()
    {
        return $this->belongsTo('App\Nota');
    }
}
