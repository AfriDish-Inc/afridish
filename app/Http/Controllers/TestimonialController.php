<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Redirect;
use DB;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(10);
        return view('admin.testimonial.index',compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.testimonial.create');
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
            'title' => 'required',
            'message' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg|max:2048'
        ]);

        $file = $request->file('image');
        $filename = $file->getClientOriginalName();
        $filename = time().'_'.$filename;
        $path = 'upload/images';
        $file->move($path, $filename);

        $testimonials = new Testimonial;
        $testimonials->name = $request->name;
        $testimonials->title = $request->title;
        $testimonials->message = $request->message;
        $testimonials->cover_image = $filename;
        $testimonials->save();
         return Redirect::to('admin/testimonial')->with('success','Great! Testimonial Created Successfully.');
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
        $testimonial = Testimonial::where('id', $id)->first();

        return view('admin.testimonial.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   /* public function update(Request $request, $id)
    {
        //
    }
*/
    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'message' => 'required',
            //'image' => 'required|mimes:jpeg,png,jpg|max:2048'
        ]);
        $testimonials = Testimonial::where('id',$id)->first();
        if($request->name){
            $testimonials->name = $request->name;
        }
        if($request->title){
            $testimonials->title = $request->title;
        }
        if($request->message){
            $testimonials->message = $request->message;
        }
        $testimonials->save();
        //$testimonials->update($request->all());
        $file = $request->file('image');
        if(isset($file))
        {
            $filename = $file->getClientOriginalName();
            $filename = time().'_'.$filename;
            $path = 'upload/images';
            $file->move($path, $filename);

            Testimonial::where('id', '=',$id)->update(
                           array(
                                 "cover_image" => $filename,

                                 )
                           );
        }
        return Redirect::to('admin/testimonial')->with('success','Great! Testimonial Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testimonials = Testimonial::where('id',$id)->delete();
        return Redirect::to('admin/testimonial')->with('success','Testimonial deleted successfully');
    }
}
