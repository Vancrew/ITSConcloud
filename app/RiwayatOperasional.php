<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiwayatOperasional extends Model
{
    protected $table = 'riwayat_operasional';

    public function jenis_operasional()
    {
        return $this->belongsTo('App\JenisOperasional');
    }
}
