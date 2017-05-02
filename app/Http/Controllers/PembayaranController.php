<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Konsumen;
use App\Nota;
use App\Pembayaran;
use App\User;
use Excel;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        if ($start == null && $end == null) {
            $pembayaran = Pembayaran::get();
            $start = $end = date('Y-m-d');
        } else {
            $pembayaran = Pembayaran::where('tanggal', '>=', $start)
                    ->where('tanggal', '<=', $end)
                    ->get();
        }

        $nota = Nota::with('konsumen')->get();
        $konsumen = Konsumen::get();
        $konsumen->transform(function ($item) {
            $total_harga = ($item->nota()->sum('total_harga'));
            $total_pembayaran = ($item->nota()->sum('total_pembayaran'));
            $item->total_hutang = $total_harga - $total_pembayaran;
            return $item;
        });
        $data = compact('pembayaran', 'nota', 'konsumen', 'start', 'end');
        // dd($data);
        return view('app.laporan.pembayaran.index', $data);
    }

    public function createKonsumen($konsumen_id)
    {
        $nota = Nota::with('konsumen')
            ->where('konsumen_id', $konsumen_id)
            ->whereRaw('total_harga > total_pembayaran')
            ->get();
        $dotnota = $nota->map(function ($item) {
            return array_dot($item->toArray());
        });
        $users = User::get();
        $data = compact('nota', 'dotnota', 'users');
        return view('app.laporan.pembayaran.create', $data);
    }

    public function createNota($nota_id)
    {
        $nota = Nota::with('konsumen')
            ->where('id', $nota_id)
            ->whereRaw('total_harga > total_pembayaran')
            ->get();
        $dotnota = $nota->map(function ($item) {
            return array_dot($item->toArray());
        });
        $users = User::get();
        $data = compact('nota', 'dotnota', 'users');
        return view('app.laporan.pembayaran.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pembayaran = new Pembayaran;
        $pembayaran->nota_id = $request->input('nota_id');
        $nota = $pembayaran->nota;
        $pembayaran->nota_konsumen_id = $nota->konsumen_id; // ini ndang dihapus
        $pembayaran->biaya = str_replace(',', '', $request->input('biaya'));
        $pembayaran->tanggal = $request->input('tanggal');
        $pembayaran->user_id = $request->input('user_id');

        /* update nota nya */
        $nota->total_pembayaran += $pembayaran->biaya;
        if ($nota->total_pembayaran > $nota->total_harga) {
            $nota->status = 1;
        }
        $nota->save();
        $pembayaran->save();

        return redirect('transaksi/pembayaran')->with('tambah_success', true);
    }

    /**
     * Nampilin nota pembayaran dalam excel
     *
     * @param $id_pembayaran
     * @return Excel
     */
    public function excelPembayaran($id)
    {
        $pembayaran = Pembayaran::find($id);
        Excel::create('nota_' . $id, function($excel) use($pembayaran) {
            $excel->sheet($pembayaran->konsumen->nama, function($sheet) use($pembayaran) {
                /* Set top, right, bottom, left */
                $sheet->setPageMargin([0.25, 0.30, 0.25, 0.30]);
                /* columns width */
                $sheet->setWidth(array(
                    'A' => 12,
                    'B' => 25,
                    'C' => 20,
                    'D' => 18,
                ));

                /* Nampilin header kuitansi */
                $sheet->mergeCells('C1:D1');
                $sheet->cell('C1', 'Padang, ' . date('d F Y', strtotime($pembayaran->tanggal)));
                $sheet->mergeCells('C3:D3');
                $sheet->cell('C3', 'Kepada Yth.');
                $sheet->mergeCells('C4:D4');
                $sheet->cell('C4', $pembayaran->konsumen->nama);

                /* Nampilin item item pembelian */
                $items = $pembayaran->nota->item_transaksi
                    ->map(function($item, $key) {
                        $ans = [
                            'Banyaknya' => $item->jumlah,
                            'Nama Barang' => $item->jenis->nama,
                            'Harga Satuan' => number_format($item->biaya),
                            'Total' => number_format($item->biaya * $item->jumlah),
                        ];
                        return $ans;
                    });
                $sheet->fromArray($items, null, 'A7', false);


                $sheet->cell('A7:D7', function($cells) {
                    $cells->setFontWeight('bold');
                });

                /* ngasih border di item pembelian */
                $total_count = max($items->count(), 11);
                $cells = 'A7:D'.($total_count + 7);
                $sheet->cell($cells, function($cells) {
                    $cells->setAlignment('left');
                });
                $sheet->setBorder($cells, 'thin');

                /* */
                $sheet->cell('C' . ($total_count + 8), 'Total harga');
                $sheet->cell('D' . ($total_count + 8), "'" . number_format($pembayaran->nota->total_harga));
                $sheet->cell('C' . ($total_count + 9), 'Total pembayaran');
                $sheet->cell('D' . ($total_count + 9), "'" . number_format($pembayaran->nota->total_pembayaran));
                $sheet->cell('C' . ($total_count + 10), 'Pembayaran sekarang');
                $sheet->cell('D' . ($total_count + 10), "'" . number_format($pembayaran->biaya));
                $sheet->cell('C' . ($total_count + 11), 'Sisa');
                $sheet->cell('D' . ($total_count + 11), "'" . number_format($pembayaran->nota->total_harga - $pembayaran->nota->total_pembayaran));
                $sheet->setBorder('D' . ($total_count + 8) . ':D' . ($total_count + 11), 'thin');
                $sheet->cell('C' . ($total_count + 11), 'Sisa');

                /* Terbilang dari biaya transaksinya */
                $sheet->mergeCells('A'.($total_count + 9).':B'.($total_count + 10));
                $sheet->cell('A'.($total_count + 9), strtoupper(terbilang($pembayaran->biaya)) . ' RUPIAH');
                $sheet->cell('A'.($total_count + 9), function($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setValignment('center');
                });

                /* Final touch */
                $sheet->mergeCells('A'.($total_count + 11).':B'.($total_count + 11));
                $sheet->cell('A'.($total_count + 11), 'Tanda Terima');

                $sheet->cell('D'.($total_count + 12), 'Hormat kami');
            });
        })->export('xls');
    }

    /**
     * Nampilin nota pembayaran dalam pdf
     *
     * @param $id_pembayaran
     * @return Pdf
     */
    public function pdfPembayaran($id)
    {
        # code...
    }
}
