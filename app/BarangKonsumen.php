<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangKonsumen extends Model
{
    public static function cari($jenis_id, $konsumen_id)
    {
        return static::where('jenis_id', $jenis_id)
            ->where('konsumen_id', $konsumen_id)
            ->first();
    }
}
