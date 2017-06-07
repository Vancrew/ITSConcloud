<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;

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

        // $file->path = $request->web->storeAs($request->input('id'),$file->name).'/'.strstr($request->web->getClientOriginalName(), '.', true);
        $file->jenis_file = $request->input('jenis_file');
        // dd($file->path);
        // $file->name = $request->input('nama_image');
        // dd($file);

        // $pathfrom = 'storage/app/'.$request->input('id').'/'.$request->web->getClientOriginalName();
        $pathfrom = base_path('storage/app/'.$request->input('id').'/'.$request->web->getClientOriginalName());
        // $pathto = 'storage/app/'.$request->input('id').'/'.strstr($request->web->getClientOriginalName(), '.', true);
        // dd($file->path);

        $filename = $pathfrom;

        // if (file_exists(base_path($filename))) {
        //     echo "The file $filename exists";
        //     // dd();
        // } else {
        //     echo base_path($filename);
        //     echo "                kkkk";
        //     // dd();
        // }

        // fix
        if ($request->input('jenis_file')=="web")
        {
            // Zipper::make(base_path($filename))->extractTo(base_path($pathto));
            $command = "docker images apache";

            // dd($pathfrom);
            $output = shell_exec($command);
            $output1 = strstr($output, "apache");
            $output2 = strstr($output1, ' ', true);
            $output3 = strstr($output2, ' ');
            dd($output2);

        }

        if ($request->input('jenis_file')=="dockerfile")
        {
            // dd("hehe");
            // dd(date('Y-m-d H:i:s'));
            $file->path = $request->web->storeAs($request->input('id'),$file->name);

            // $myfile = fopen(base_path('storage/app/log/a'), "r");
            // // dd($myfile);
            // $angka = fread($myfile,filesize(base_path('storage/app/log/a')));
            // fclose($myfile);
            // $angka2 = strstr($angka,PHP_EOL,true);
            // $angka3 = $angka2+2;
            // $angka4 = $angka3."\n";
            // // dd($angka4);
            
            // $myfile = fopen(base_path('storage/app/log/a'), "w");
            // fwrite($myfile, $angka3."\n");
            // fclose($myfile);

            // $log=2;

            $filename=base_path('storage/app/log/a');
            if(!file_exists($filename)){
                $counter = 0 ;
            }
            else
                $counter = file_get_contents ($filename);
            $counter++;
            file_put_contents($filename, $counter);


            $command = "curl -v -X POST -H \"Content-Type:application/tar\" --data-binary '@".$pathfrom."' http://localhost:4243/build?t=".$request->input('namerepo')." >".base_path('storage/app/log/'.$counter)." 2>&1 &";

            // dd($pathfrom);
            $output = shell_exec($command);
            // dd($output);
            // dd($counter);
            // dd($command);

        }
        // fix
        // Storage::deleteDirectory($request->input('id').'/'.strstr($request->web->getClientOriginalName(), '.', true));
        // dd('llop');

        // $success = File::deleteDirectory(base_path($file->pathto));

        $file->mime = base_path('storage/app/log/'.$counter);
        $file->save();

        // dd($counter);

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
