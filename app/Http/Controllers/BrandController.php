<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Redirect;
use DB;

class BrandController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::paginate(10);
        return view('admin.brand.index',compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brand.create');
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
            'name' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg|max:2048'
        ]);

        $file = $request->file('image');
        $filename = $file->getClientOriginalName();
        $filename = time().'_'.$filename;
        $path = 'upload/images';
        $file->move($path, $filename);
        $brand = new Brand;
        $brand->name = $request->name;
        $brand->cover_image = $filename;
        $brand->save();
        return Redirect::to('admin/brand')->with('success','Great! Brand Created Successfully.');
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
        $brand = Brand::where('id' ,$id)->first();
        $data['brand'] = $brand;
        return view('admin.brand.edit', $data);
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
        $request->validate([
            'name' => 'required',
            'image' => 'mimes:jpeg,png,jpg|max:2048'
        ]);
        $brand = Brand::where('id',$id)->first();
        $brand->name = $request->name;
        $brand->save();
        $file = $request->file('image');
        if(isset($file))
        {
            $filename = $file->getClientOriginalName();
            $filename = time().'_'.$filename;
            $path = 'upload/images';
            $file->move($path, $filename);
            Brand::where('id', '=', $id)->update(["cover_image" => $filename]);
        }

        return Redirect::to('admin/brand')->with('success','Great! Brand Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Brand::where('id',$id)->delete();
        return Redirect::to('admin/brand')->with('success','Brand deleted successfully');
    }
}
