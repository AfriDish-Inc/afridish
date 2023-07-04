@extends('layouts.admin')
@section('content')


<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} Brand
    </div>

    <div class="card-body card-custom">
        <form action="{{ route("admin.brand.update", [$brand->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        <div class="stor-frm-otr">
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">Brand Name*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($brand) ? ucfirst($brand->name) : '') }}" required>
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
               
            </div>
			 <div class="form-group">
                <label for="detail">Image</label>
                <input type="file" id="image" name="image" accept="image/png, image/jpeg" class="form-control">
            </div>
		</div>	
	
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection