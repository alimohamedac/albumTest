<?php

namespace App\Http\Controllers;

use App\Album;
use App\Picture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Album $album)
    {
        return view('pictures.create', compact('album'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Album $album)
    {
        $this->validate($request, [
            'name' => 'mimes:pdf,jpeg,png,jpg',
        ], [
            'name.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
        ]);

        $image = $request->file('name');
        $name = $image->getClientOriginalName();

        Picture::create([
            'name'       => $name,
            'album_id'   => $request->album_id,
        ]);

        // move pic
        $imageName = $request->name->getClientOriginalName();
        $request->name->move(public_path('Pictures/'. $request->album_id), $imageName);

        session()->flash('Add', 'تم اضافة المرفق بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function show(Picture $picture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function edit(Picture $picture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Picture $picture)
    {
        $picture->delete();

        Storage::disk('public_uploads')->delete($picture->album_id.'/'.$picture->name);

        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

    public function openFile($album_id, $name): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($album_id.'/'.$name);
        return response()->file($files);
    }
}
