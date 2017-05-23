<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

use App\Http\Requests;
use App\File;
use App\Image;
use Auth;
use ZipArchive;
use Zipper;
// use UrlGenerator;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['files'] = File::where('user_id',Auth::id())->get();
        foreach ($data['files'] as $file) {
            
            $file->size = round(($file->size / 1024 / 1024),2);

        }
        // dd($data);

        return view('app.file_index',$data);
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
        //
        // phpinfo();
        // dd($request->web->getClientOriginalExtension());
        // dd($request->web->getClientOriginalName());
        $file = new File;
        $file->name = $request->web->getClientOriginalName();
        $file->user_id = $request->input('id');
        $file->size = $request->web->getClientsize();
        // dd($file);
        $file->path = $request->web->storeAs($request->input('id'),$file->name);
        
        // $file->name = $request->input('nama_image');
        // dd($file);

        $file->pathfrom = 'storage/app/'.$request->input('id').'/'.$request->web->getClientOriginalName();
        $file->pathto = 'storage/app/'.$request->input('id');
        // dd($file->pathfrom);

        $filename = $file->pathfrom;

        if (file_exists(base_path($filename))) {
            echo "The file $filename exists";
            // dd();
        } else {
            echo base_path($filename);
            echo "                kkkk";
            // dd();
        }

        Zipper::make(base_path($filename))->extractTo(base_path($file->pathto));

        // $file->save();

        

        // $zip = new ZipArchive;
        // if ($zip->open('storage/app/'.$request->input('id').'/'.$request->web->getClientOriginalName()) === TRUE) {
        //     $zip->extractTo('storage/app/'.$request->input('id').'/');
        //     $zip->close();
        //     echo 'ok';
        //     dd(3);
        // } else {
        //     echo 'failed';
        //     dd(2);
        // }

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
        //
        // $data['images'] = Image::find($id);
        // return view('app.image_edit', $data);
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
        //
        // $image = Image::find($id);
        // $image->id_image = $request->input('id_image');
        // $image->save();

        // return redirect('image')->with('edit_success', true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        // $image = Image::find(decrypt($id));
        // $image->delete();

        // echo 'success';
    }
}
