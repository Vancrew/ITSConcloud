<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisOperasional extends Model
{
    use SoftDeletes;

    protected $table = 'jenis_operasional';

    protected $guarded = [];

    public function pengeluaran_lainnya()
    {
        return $this->hasMany('App\PengeluaranLainnya');
    }

    public function riwayat_operasional()
    {
        return $this->hasMany('App\RiwayatOperasional');
    }
}
