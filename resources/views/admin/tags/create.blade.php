@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} Tag
        </div>

        <div class="card-body card-custom">
            <form action="{{ route('admin.tag.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="stor-frm-otr">
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        <label for="title">Tag {{ trans('cruds.user.fields.name') }}*</label>
                        <input type="text" id="title" name="title" class="form-control"
                            value="{{ old('title', isset($category) ? $category->title : '') }}" required>
                        @if ($errors->has('title'))
                            <em class="invalid-feedback">
                                {{ $errors->first('title') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.user.fields.name_helper') }}
                        </p>
                    </div>

                    <!-- <div class="form-group {{ $errors->has('cover_image') ? 'has-error' : '' }}">
                        <label for="detail">Cover image*</label>
                        <div class="uplad-img">
                        <input type="file" id="cover_image" name="cover_image" class="form-control" value="{{ old('cover_image', isset($category) ? $category->cover_image : '') }}" required>
                        @if ($errors->has('cover_image'))
    <em class="invalid-feedback">
                                {{ $errors->first('cover_image') }}
                            </em>
    @endif
                       </div>
                    </div> -->
                    <div>
                        <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                    </div>
            </form>


        </div>
    </div>
@endsection
