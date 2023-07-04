@extends('layouts.admin')
@section('content')
<?php //echo "<pre>"; print_r($category); die; ?>

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} Category
    </div>

    <div class="card-body card-custom"> 
          <form action="{{ route("admin.testimonial.update", [$testimonial->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
             @method('PUT')
        <div class="stor-frm-otr">
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="Name">Name*</label>
                <input type="text" id="Name" name="name" class="form-control" value="{{ old('name', isset($testimonial) ? $testimonial->name : '') }}" required>
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                <label for="title">Title*</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($testimonial) ? $testimonial->title : '') }}" required>
                @if($errors->has('title'))
                    <em class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </em>
                @endif
            </div>

            <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                <label for="message">Message*</label>
                <textarea name="message" rows="3" cols="5" required>{{ old('message', isset($testimonial) ? $testimonial->message : '') }}</textarea>
                @if($errors->has('message'))
                    <em class="invalid-feedback">
                        {{ $errors->first('message') }}
                    </em>
                @endif
            </div>
            
            <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                <label for="detail">Image*</label>
                <div class="uplad-img">
                <input type="file" id="image" name="image" class="form-control" accept="image/png,  image/jpeg" value="{{ old('image', isset($testimonial) ? $testimonial->image : '') }}">
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