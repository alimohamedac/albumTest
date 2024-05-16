<?php

namespace App\Http\Controllers;

use App\Album;
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
            'name' => 'required|string|max:255',
        ]);

        Album::create([
            'name'    => $request->name,
            'user_id' => Auth::id(),
        ]);

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
        //
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
    public function destroy(Request $request)
    {
        $id = $request->album_id;
        $album = Album::where('id', $id)->first();

        if ($album->pictures()->exists()) {
            return view('albums.confirm_delete', compact('album'));
        }

        $album->delete();
        return redirect()->route('albums.index')->with('success', 'Album deleted successfully.');
    }

    public function deleteOrMove(Request $request)
    {
        $id = $request->album_id;
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
