<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

use App\BarangKonsumen;
use App\Inventory;
use App\ItemTransaksi;
use App\Jenis;
use App\JenisOperasional;
use App\Konsumen;
use App\Modal;
use App\Nota;
use App\Pembayaran;
use App\Produsen;
use App\RiwayatOperasional;

class TransaksiController extends Controller
{
    public function getPembelian()
    {
        $data['jenis'] = Jenis::get();
        $data['produsen'] = Produsen::get();

        return view('app.transaksi_pembelian', $data);
    }

    public function postPembelian(Request $request)
    {
        $modal = new Modal;
        $modal->tanggal = $request->input('tanggal');
        $modal->produsen_id = $request->input('produsen');
        $modal->biaya = $request->input('total');
        $modal->save();

        foreach ($request->input('pembelian') as $pembelian) {
            $inventory = new Inventory;
            $inventory->jenis_id = $pembelian['jenis_id'];
            $inventory->merek = $pembelian['merek'];
            $inventory->tanggal_masuk = date('Y-m-d');
            $inventory->tanggal_kadaluarsa = $pembelian['tanggal_kadaluarsa'];
            $inventory->harga_beli = $pembelian['harga'] / $pembelian['jumlah'];
            $inventory->jumlah = $pembelian['jumlah'];
            $inventory->jumlah_aktual = $pembelian['jumlah'];
            $inventory->jumlah_karung = $pembelian['jumlah_karung'];
            $inventory->modal_id = $modal->id;
            $inventory->save();
        }
        return redirect()->back()->with('tambah_success', true);
    }

    public function getPenjualan($konsumen_id = false)
    {
        if (!$konsumen_id) {
            $data['konsumen'] = Konsumen::get();
            return view('app.transaksi_penjualan', $data);
        } else {
            $inventory = Inventory::available()->with('jenis')->get();
            $data['konsumen'] = Konsumen::find($konsumen_id);
            $data['operasional'] = JenisOperasional::get();
            $data['dotinvent'] = $inventory->map(function ($item) use($konsumen_id) {
                $brg_kon = BarangKonsumen::cari($item->jenis_id, $konsumen_id);
                $item->harga = $brg_kon->harga;
                $item->nama = $item->jenis->nama;
                return $item;
            });

            return view('app.transaksi_penjualan_konsumen', $data);
        }
    }

    public function postPenjualan(Request $request)
    {
        if ($request->input('pilih_konsumen')) {
            $konsumen = $request->input('konsumen');
            return redirect('transaksi/penjualan/' . $konsumen);
        }

        $inventory = $request->input('inventory');
        $operasional = $request->input('operasional');
        $total = $request->input('total');
        $total_operasional = $request->input('total_operasional');

        if ($inventory == null) {
            return $redirect->back();
        }

        $nota = new Nota;
        $nota->tanggal = $request->input('tanggal');
        $nota->total_modal = 0; // diisi di bawah
        $nota->total_harga = $total;
        $nota->total_pembayaran = 0;
        $nota->keuntungan_bersih = 0; // diisi di bawah
        $nota->konsumen_id = $request->input('konsumen');
        $nota->status = 0;
        $nota->user_id = Auth::user()->id;
        $nota->save();

        foreach ($inventory as $value) {
            $realitem = Inventory::find($value['inventory_id']);
            if ($realitem->jumlah_aktual < $value['jumlah']) {
                $nota->delete();
                dd('jumlah kurang');
            }
            $realitem->jumlah_aktual -= $value['jumlah'];
            $realitem->save();

            $item = new ItemTransaksi;
            $item->jumlah = $value['jumlah'];
            $item->nota_id = $nota->id;
            $item->biaya = $value['biaya'];
            $item->inventory_id = $value['inventory_id'];
            $item->inventory_jenis = $value['inventory_jenis'];
            $item->save();

            $nota->total_modal += $item->jumlah * $realitem->harga_beli;
        }
        $nota->keuntungan_bersih = $total - $nota->total_modal - $total_operasional;
        $nota->save();

        foreach ((array) $operasional as $value) {
            $item = new RiwayatOperasional;
            $item->biaya = $value['biaya'];
            $item->jenis_operasional_id = $value['jenis_operasional_id'];
            $item->nota_id = $nota->id;
            $item->save();
        }
        return redirect('transaksi/pembayaran/create/nota/' . $nota->id)
            ->with('nota_id', $nota->id)
            ->with('transaksi_success', true);
    }
}
