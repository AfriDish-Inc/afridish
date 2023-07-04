@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} Brand
    </div>

    <div class="card-body card-custom">
        <form action="{{ route("admin.brand.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
        <div class="stor-frm-otr">
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">Brand {{ trans('cruds.user.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($brand) ? $brand->name : '') }}" required>
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.name_helper') }}
                </p>
            </div>
			
            <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                <label for="detail">Image*</label>
                <div class="uplad-img">
                <input type="file" id="image" name="image" accept="image/png, image/jpeg" class="form-control" value="{{ old('image', isset($brand) ? $brand->cover_image : '') }}" required>
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