<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PengeluaranLainnya as Pengeluaran;
use App\User;
use App\JenisOperasional;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        if ($start == null && $end == null) {
            $pengeluaran = Pengeluaran::get();
            $start = $end = date('Y-m-d');
        } else {
            $pengeluaran = Pengeluaran::where('tanggal', '>=', $start)
                    ->where('tanggal', '<=', $end)
                    ->get();
        }
        $jenis = JenisOperasional::get();
        $user = User::get();

        $data = compact('pengeluaran','jenis','user', 'start', 'end');
        return view('app.pengeluaran_index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->input());
        $pengeluaran = new Pengeluaran;
        $pengeluaran->jenis_operasional_id = $request->input('jenis');
        $pengeluaran->uraian = $request->input('uraian');
        $pengeluaran->tanggal = $request->input('tanggal');
        $pengeluaran->biaya = str_replace(',', '', $request->input('biaya'));
        $pengeluaran->user_id= $request->input('user_id');
        $pengeluaran->save();

        return redirect()->back()->with('tambah_success', true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pengeluaran = Pengeluaran::find($id);
        $pengeluaran->tanggal = date('Y-m-d', strtotime($pengeluaran->tanggal));
        $jenis = JenisOperasional::get();
        $user = User::get();

        $data = compact('pengeluaran', 'jenis', 'user');
        return view('app.pengeluaran_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pengeluaran = Pengeluaran::find($id);
        $pengeluaran->jenis_operasional_id = $request->input('jenis');
        $pengeluaran->uraian = $request->input('uraian');
        $pengeluaran->tanggal = $request->input('tanggal');
        $pengeluaran->biaya = str_replace(',', '', $request->input('biaya'));
        $pengeluaran->user_id= $request->input('user_id');
        $pengeluaran->save();

        return redirect('pengeluaran')->with('edit_success', true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::find(decrypt($id));
        $pengeluaran->delete();

        echo 'success';
    }
}
