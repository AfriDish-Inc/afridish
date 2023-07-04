@extends('layouts.user')
@section('content')
<?php //echo "<pre>"; print_r($data);die; ?>
<script>
  @if(Session::has('success'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
      toastr.success("{{ session('success') }}");
  @endif
</script>
<div class="container-fluid b-all-products">
  <div class="container testimonials subscription">
    <div class="row">
        <div class="col-md-12">
          <div class="wrapper all-products">
            <h2>My Wishlist</h2>
                <p>Browse the collection of the category products.</p>
            </div>

        </div>
      </div>
      <div class="row">
          <div class="col-md-12">
              <div class="my-wishlist">
                  <p class="page-navigation"><span>Home/<a href="#">My-Wishlist</a></p>
                  @if(count($data) > 0)  
                  @foreach($data as $key=>$value)  
                   @if($value->image)
                    <?php $image = explode('|',$value->image); ?>
                   @endif
                  <div class="wish-lists">
                      <div class="p-image"><img src="{{ asset('upload/images/')}}/{{$image[0]}}"></div>
                      <h4>{{$value->name}}</h4>
                      <!-- <div class="product-count">
                        <button class="button-count no-active" disabled>-</button>
                        <input type="text" readonly class="number-product" value="1">
                        <button class="button-count">+</button>
                      </div> -->
                      
                      <p class="product-status">In Stock</p>
                      <p class="price">${{$value->price}}</p>
                      <a href="{{url('/addcartlist?product_id=')}}{{$value->product_id}}&product_quantity=1&wishlist=1" class="atc-btn">Add To Cart</a>
                      <a href="{{url('remove-wishlist?id=')}}{{$value->id}}" class="close-bt"><img src="{{ asset('website/img/close.svg')}}"></a>
                  </div>
                  @endforeach
                  @endif
              </div>

          </div>    
      </div>
    </div>
</div>
@endsection