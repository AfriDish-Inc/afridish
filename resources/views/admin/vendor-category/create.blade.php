@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} Category
    </div>

    <div class="card-body card-custom"> 
        @if(auth()->user()->user_type == "A")
          <form action="{{ route("admin.vendor-category.store") }}" method="POST" enctype="multipart/form-data">
         @elseif(auth()->user()->user_type == "V")   
           <form action="{{ route("vendor.vendor-category.store") }}" method="POST" enctype="multipart/form-data">
        @endif
        
            @csrf
        <div class="stor-frm-otr">
            <div class="form-group {{ $errors->has('category_name') ? 'has-error' : '' }}">
                <label for="category_name">Category {{ trans('cruds.user.fields.name') }}*</label>
                <input type="text" id="category_name" name="category_name" class="form-control" value="{{ old('category_name', isset($category) ? $category->category_name : '') }}" required>
                @if($errors->has('category_name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('category_name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.name_helper') }}
                </p>
            </div>
			
            <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                <label for="detail">Image*</label>
                <div class="uplad-img">
                <input type="file" id="image" name="image" class="form-control" accept="image/png,  image/jpeg" value="{{ old('image', isset($category) ? $category->image : '') }}" required>
                @if($errors->has('image'))
                    <em class="invalid-feedback">
                        {{ $errors->first('image') }}
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