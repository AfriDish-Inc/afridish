<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Redirect;
use DB;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);

        return view('admin.category.index')->with(['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.  
     *
     * @return \Illuminate\Http\Response
     */ 
    public function create()
    {
        return view('admin.category.create');
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
        $messages = [
           'image.uploaded' => 'Failed to upload an image. The image maximum size is 2MB.',
        ];
        $request->validate([
            'category_name' => 'required|unique:categories',
            'image' => 'required|mimes:jpeg,png,jpg|max:2048'
        ],$messages);

        $file = $request->file('image');
        $filename = $file->getClientOriginalName();
        $filename = time() . '_' . $filename;
        $path = 'upload/images';
        $file->move($path, $filename);

        $category = new Category;
        $category->category_name = $request->category_name;
        $category->image = $filename;
        $category->save();

        if (auth()->user()->user_type == "V") {
            return Redirect::to('vendor/category')->with('success', 'Great! Category Created Successfully.');
        } else {
            return Redirect::to('admin/category')->with('success', 'Great! Category Created Successfully.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $where = array('id' => $category->id);
        $category = Category::select('id', 'category_name')->where($where)->first();
        $data['category'] = $category;
        return view('admin.category.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $messages = [
            'image.uploaded' => 'Failed to upload an image. The image maximum size is 2MB.',
        ];
        $request->validate([
            'category_name' => 'required|unique:categories,category_name,' . $category->id,
            'image' => 'mimes:jpeg,png,jpg|max:2048'
        ],$messages);

        $category->update($request->all());
        $file = $request->file('image');
        if (isset($file)) {
            $filename = $file->getClientOriginalName();
            $filename = time() . '_' . $filename;
            $path = 'upload/images';
            $file->move($path, $filename);

            Category::where('id', '=', $category->id)->update(
                array(
                    "image" => $filename,

                )
            );
        }
        if (auth()->user()->user_type == "V") {
            return Redirect::to('vendor/category')->with('success', 'Great! Category Updated Successfully.');
        } else {
            return Redirect::to('admin/category')->with('success', 'Great! Category Updated Successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $products = Product::where('category_id', $category->id)->get();
        foreach ($products as $key => $value) {
            Wishlist::where('product_id', $value->id)->delete();
        }
        $products = Product::where('category_id', $category->id)->delete();
        $category->delete();
        if (auth()->user()->user_type == "V") {
            return Redirect::to('vendor/category')->with('success', 'Category deleted successfully.');
        } else {
            return Redirect::to('admin/category')->with('success', 'Category deleted successfully.');
        }
    }
}
