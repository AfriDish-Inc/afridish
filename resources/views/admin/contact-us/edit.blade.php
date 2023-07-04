@extends('layouts.admin')
@section('content')
<?php //echo "<pre>"; print_r($category); die; ?>

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} Category
    </div>

    <div class="card-body card-custom">
        @if(auth()->user()->user_type == "A")
          <form action="{{ route("admin.category.update", [$category->id]) }}" method="POST" enctype="multipart/form-data">
         @elseif(auth()->user()->user_type == "V")   
           <form action="{{ route("vendor.category.update", [$category->id]) }}" method="POST" enctype="multipart/form-data">
        @endif
            @csrf
        <div class="stor-frm-otr">
             <div class="form-group select-prdct">  
                <label for="category">Status*</label>
                <select name="category_id" required>
                        <option value=""> -- Select Status -- </option>

                    @foreach($category as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                    @endforeach
                </select>
                @if($errors->has('category_id'))
                    <em class="invalid-feedback">
                        {{ 'Category is required.' }}
                    </em>
                @endif   
            </div>
        </div>	
	
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection