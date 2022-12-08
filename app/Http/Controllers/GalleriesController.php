<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Requests\CreateGalleryRequest;
use App\Models\Image;

class GalleriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries = Gallery::all();
        return $galleries;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGalleryRequest $request)
    {
        $gallery = new Gallery();
        $gallery->title = $request->title;
        $gallery->description = $request->description;
        $gallery->user_id = auth()->user()->id;
        $gallery->save();

        $imgs = [];
        foreach ($request->images as $img) {
            $imgs[] = new Image($img);
        }
        $gallery->images()->saveMany($imgs);

        return $this->show($gallery->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gallery = Gallery::with(['images', 'user', 'comments', 'comments.user'])->find($id);
        return $gallery;
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateGalleryRequest $request, $id)
    {
        $gallery = Gallery::find($id);
        $gallery->title = $request->title;
        $gallery->description = $request->description;
        $gallery->user_id = auth()->user()->id;
        $gallery->save();

        $gallery->images()->delete();
        $imgs = [];
        foreach (request('images') as $img) {
            $imgs[] = new Image($img);
        }
        $gallery->images()->saveMany($imgs);

        return $this->show($gallery->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gallery = Gallery::find($id);
        $gallery->delete();

        return response()->json([
            'message' => 'Gallery deleted'
        ]);
    }
}