@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} Product
    </div>

    <div class="card-body card-custom">
        @if(auth()->user()->user_type == "A")
           <form action="{{ route("admin.product.update", [$product->id]) }}" method="POST" enctype="multipart/form-data">
         @elseif(auth()->user()->user_type == "V")   
           <form action="{{ route("vendor.product.update", [$product->id]) }}" method="POST" enctype="multipart/form-data">
        @endif
        
            @csrf
            @method('PUT')
        <div class="stor-frm-otr">
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">Name*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($product) ? $product->name : '') }}" required>
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
               
            </div>

            <div class="form-group">
                <label for="detail">Price*</label>
                <input type="number" id="price" name="price" min="1" class="form-control" value="{{ old('price', isset($product) ? $product->price : '') }}" required>
                @if($errors->has('price'))
                    <em class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </em>
                @endif
            </div>

			<div class="form-group {{ $errors->has('detail') ? 'has-error' : '' }}">
                <label for="detail">Description*</label>
                <textarea name="detail" rows="10" cols="52" required>{{ isset($product) ? $product->detail : '' }}</textarea>
                @if($errors->has('detail'))
                    <em class="invalid-feedback">
                        {{ 'Description is required.' }}
                    </em>
                @endif
               
            </div>
            <div class="form-group {{ $errors->has('detail') ? 'has-error' : '' }}">
                <label for="detail">Description*</label>
                <textarea name="description" rows="10" cols="52" value="{{ old('description', isset($product) ? $product->description : '') }}" required>{{ isset($product) ? $product->description : '' }}</textarea>
                @if($errors->has('description'))
                    <em class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </em>
                @endif
               
            </div>

            <div class="form-group">
                <label for="detail">Quantity*</label>
                <input type="number" id="quantity" name="quantity" min="1" class="form-control" value="{{ old('quantity', isset($product) ? $product->quantity : '') }}" required>
                @if($errors->has('quantity'))
                    <em class="invalid-feedback">
                        {{ $errors->first('quantity') }}
                    </em>
                @endif   
            </div>

            <div class="form-group">
                <label for="image">Image *</label>
                <input type="file" id="image" name="image[]" accept="image/png,  image/jpeg" class="form-control" multiple value="{{ old('image', isset($product) ? $product->image : '') }}">
                @if($errors->has('image'))
                    <em class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </em>
                @endif
            </div>

		</div>
		<div class="stor-frm-otr">
			 <div class="form-group select-prdct">	
				<label for="category">Category Name*</label>
                <div class="select_arrow">
                    <i class=" fa fa-angle-left"></i>
				<select id="category_edit" name="category_id" required>
                        <option value=""> -- Select Category -- </option>

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
                <div class="form-group">
                <label for="detail">Video *</label>
                <input type="file" id="image" name="video" class="form-control" value="{{ old('video', isset($product) ? $product->video : '') }}">
                @if($errors->has('video'))
                    <em class="invalid-feedback">
                        {{ $errors->first('video') }}
                    </em>
                @endif
            </div> 
        </div>
        @if($product->address)
        <div class="stor-frm-otr address">
            <div class="form-group">
                <div id="map" class="form-group">  
                    <label for="exampleInputEmail1">Address</label>
                     <input id="pac-input" class="form-control address_title" placeholder="input the location" value="{{$product->address}}" name="address" ame="location" type="text">  
                     <div id="map-canvas"> </div>  
                     <input name="lat" class="lat" value="{{$product->latitude}}" type="hidden">  
                     <input name="lon" class="lon" value="{{$product->longitude}}" type="hidden">  
                </div>
            </div>   
        </div> 
        @endif 
        <div class="stor-frm-otr">
            <div class="form-group select-prdct">   
                <label for="category">Brand Name *</label>
                <div class="select_arrow">
                    <i class=" fa fa-angle-left"></i>
                <select name="brand_id" required> 
                        <option value=""> -- Select Brand -- </option>   
                    @foreach($brand as $bvalue)
                        <option value="{{ $bvalue->id }}" {{ $product->brand_id == $bvalue->id ? 'selected' : '' }}>{{ $bvalue->name }}</option>
                    @endforeach
                </select>
            </div>
            </div>
        </div>

        <div class="stor-frm-otr">
            <div class="form-group select-prdct">   
                <label for="category">Vendor *</label>
                <div class="select_arrow">
                    <i class=" fa fa-angle-left"></i>
                <select name="provider_id" required> 
                        <option value=""> -- Select Vendor -- </option>   
                    @foreach($provider as $pvalue)
                        <option value="{{ $pvalue->id }}" {{ $product->provider_id == $pvalue->id ? 'selected' : '' }}>{{ $pvalue->name }}</option>
                    @endforeach
                </select>
            </div>
            </div>
        </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection