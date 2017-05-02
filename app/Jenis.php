<?php

namespace App;
use App\KursBarang as Kurs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jenis extends Model
{
    use SoftDeletes;

    protected $table = 'jenis';

    protected $guarded = [];

    public function kurs()
    {
        return $this->hasMany('App\KursBarang');
    }

    public function latest_kurs()
    {
        return $this->belongsTo('App\KursBarang', 'latest_kurs_id');
    }

    public function inventory()
    {
        return $this->hasMany('App\Inventory');
    }

    public function transaksi()
    {
        return $this->hasMany('App\ItemTransaksi', 'inventory_jenis');
    }

    public function konsumen()
    {
        return $this->belongsToMany('App\Konsumen', 'barang_konsumens')
            ->withPivot('harga');
    }
}
