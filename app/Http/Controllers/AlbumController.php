<?php

namespace App\Http\Controllers;

use App\Album;
use App\Picture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $albums = Album::where('user_id', Auth::id())->get();
        return view('albums.index', compact('albums'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('albums.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'pic'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        Album::create([
            'name'    => $request->name,
            'user_id' => Auth::id(),
        ]);

        if ($request->hasFile('pic')) {

            $album = Album::latest()->first();
            $image = $request->file('pic');
            $name = $image->getClientOriginalName();

            Picture::create([
                'name'       => $name,
                'album_id'   => $album->id,
            ]);

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Pictures/' . $album->id), $imageName);
        }

        return redirect()->route('albums.index')->with('success', 'Album created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function show(Album $album)
    {
        return redirect()->route('albums.show', compact('album'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $album = Album::where('id', $id)->first();

        return view('albums.edit', compact('album'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $album = Album::findOrFail($request->album_id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $album->update($request->all());

        return redirect()->route('albums.index')->with('success', 'Album updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $album)
    {
        $all_albums = Album::all();

        if ($album->pictures) {
            return view('albums.confirm_delete', compact('album', 'all_albums'));
        }

        $album->delete();
        return redirect()->route('albums.index')->with('success', 'Album deleted successfully.');
    }

    public function deleteOrMove($id, Request $request)
    {
        $album = Album::where('id', $id)->first();

        $request->validate([
            'action'          => 'required|string|in:delete,move',
            'target_album_id' => 'required_if:action,move|exists:albums,id',
        ]);

        if ($request->action === 'delete') {
            $album->pictures()->delete();
        } elseif ($request->action === 'move') {
            $targetAlbum = Album::find($request->target_album_id);
            $album->pictures()->update(['album_id' => $targetAlbum->id]);
        }

        $album->delete();
        return redirect()->route('albums.index')->with('success', 'Album deleted successfully.');
    }
}
