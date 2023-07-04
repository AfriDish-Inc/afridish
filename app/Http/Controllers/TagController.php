<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Redirect;
use DB;

class TagController extends Controller
{
    public function index()
    {
        $categories = Tag::latest()->paginate(10);

        return view('admin.tags.index')->with(['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tags.create');
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
        $request->validate([
            'title' => 'required|unique:tags',
            //'cover_image' => 'required|mimes:jpeg,png,jpg|max:2048'
        ]);

        // $file = $request->file('cover_image');
        // $filename = $file->getClientOriginalName();
        // $filename = time().'_'.$filename;
        // $path = 'upload/images';
        // $file->move($path, $filename);

        $tags = new Tag;
        $tags->title = $request->title;
        $tags->status = 1;
        // $tags->cover_image = $filename;
        $tags->save();

        return Redirect::to('admin/tag')->with('success', 'Great! Tag Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $Tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $Tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        $tags = Tag::where('id', $tag->id)->first();

        return view('admin.tags.edit', compact('tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $Tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'title' => 'required|unique:tags,title,' . $tag->id,
        ]);

        $tag->update($request->all());
        return Redirect::to('admin/tag')->with('success', 'Great! Tag Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $Tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return Redirect::to('admin/tag')
            ->with('success', 'Tag deleted successfully');
    }
}
