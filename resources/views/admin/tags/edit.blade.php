@extends('layouts.admin')
@section('content')


<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} Tag
    </div>

    <div class="card-body card-custom">
        <form action="{{ route("admin.tag.update", [$tags->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        <div class="stor-frm-otr">
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                <label for="name">Title*</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('name', isset($tags) ? ucfirst($tags->title) : '') }}" required>
                @if($errors->has('title'))
                    <em class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </em>
                @endif
               
            </div>
			 <!-- <div class="form-group">
                <label for="detail">Cover image *</label>
                <input type="file" id="cover_image" name="cover_image" class="form-control">
            </div> -->
		</div>	
	
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection