<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use DB;
use Auth;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['images'] = Image::where('id_user', Auth::id())
            ->orderBy('created_at', 'desc')->get();
        // $data['images'] = apiGET('10.151.36.109:4243/images/json');
        // dd($data);
        foreach ($data['images'] as $image) {
            // dd($image);
            $json = apitestGET('10.151.36.109:4243/images/'.$image->id_image.'/json');
            // sleep(0);
            // $image->id_image = substr($image->Id, 8, 12);
            // 
            
            // ;
            // if($json->RepoTags[0]
            // if(is_null ($json->RepoTags[0])
            // {
            //     // dd("null");
            // }
            // isset($$votes)
            // $error = NULL;
            if (isset($json->RepoTags[0])) {
                $image->Repo_tags = $json->RepoTags[0];
                $image->Size = round(($json->Size / 1024 / 1024),2);
                $image->Created = substr($json->Created, 0, 10) . " " . substr($json->Created, 11, 8);
                $image->Status = "Success";
            }
            else
            {
                $image->Repo_tags = "-";
                $image->Size = "- ";
                $image->Created = "-";
                $image->Status = "Undefinied";
            }
        }

        // dd("LL");

        //$data2['images'] = apiGET('10.151.36.109:4243/images/json');
        //dd($data);

        return view('app.image_index', $data);
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
        $image = new Image;
        $image->id_image = $request->input('nama_image');
        $image->save();

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
        $data['images'] = Image::find($id);
        return view('app.image_edit', $data);
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
        $image = Image::find($id);
        $image->id_image = $request->input('id_image');
        $image->save();

        return redirect('image')->with('edit_success', true);
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
        $image = Image::find(decrypt($id));
        $image->delete();

        echo 'success';
    }
}
