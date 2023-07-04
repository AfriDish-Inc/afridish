@extends('layouts.admin')
@section('content')
    <?php echo "<pre>"; print_r($category); die;
    ?>

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} Category
        </div>

        <div class="card-body card-custom">
            @if (auth()->user()->user_type == 'A')
                <form action="{{ route('admin.vendor-category.update', [$category->id]) }}" method="POST"
                    enctype="multipart/form-data">
                @elseif(auth()->user()->user_type == 'V')
                    <form action="{{ route('vendor.vendor-category.update', [$category->id]) }}" method="POST"
                        enctype="multipart/form-data">
            @endif

            @csrf
            @method('PUT')
            <div class="stor-frm-otr">
                <div class="form-group {{ $errors->has('category_name') ? 'has-error' : '' }}">
                    <label for="name">Category Name*</label>
                    <input type="text" id="category_name" name="category_name" class="form-control"
                        value="{{ old('name', isset($category) ? ucfirst($category->category_name) : '') }}" required>
                    @if ($errors->has('category_name'))
                        <em class="invalid-feedback">
                            {{ $errors->first('category_name') }}
                        </em>
                    @endif

                </div>
                <div class="form-group">
                    <label for="detail">Image</label>
                    <input type="file" id="image" name="image" accept="image/png, image/jpeg"
                        value="{{ old('name', isset($category) ? $category->image : '') }}" class="form-control">
                </div>
            </div>

            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
            </form>


        </div>
    </div>
@endsection
