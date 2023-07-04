@extends('layouts.user')
@section('content')
<?php //echo "<pre>"; print_r($vendor); die;  ?>
<script>
  @if(Session::has('message'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
      toastr.success("{{ session('message') }}");
  @endif

  @if(Session::has('success'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
      toastr.success("{{ session('success') }}");
  @endif

  @if(Session::has('error'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true 
  }
      toastr.error("{{ session('error') }}");
  @endif
</script>

<div class="container product-details">
  <div class="row">
      <div class="col-md-12">
          <form class="vendor-details">
              <div class="name-icon">
                  <img src="{{ asset('upload/images/')}}/{{$restaurant->profile_picture}}">
                  <div class="v-name">
                      <label>Restaurant Name</label>
                      <input type="text" value="{{$restaurant->name}}">
                  </div>
                </div>
                <div class="under-flex">
                  <div class="v-name">
                    <label>Restaurant Email</label>
                  <input type="email" value="{{$restaurant->email}}">
                </div>
              </div>
                <div class="v-name">
                    <label>Address</label>
                    <textarea rows="4" cols="50">{{$restaurant->address}}</textarea>
                </div>
            </form>
          </div>
      </div>
</div>

<div class="container-fluid prodcts">
<div class="container brands">
  <div class="row">
    <div class="col-md-3">
         <div class="wrapper">
            <h2>Products</h2>
            <a href="{{url('product')}}" class="v-products">Products</a> 
         </div>
      </div>
      <div class="col-md-9">
          <div class="my-sliderp">
            @if(count($relatedProducts) > 0)
                     @foreach($relatedProducts as $key => $product)
                     @if($product->image)
                     <?php $image = explode('|',$product->image); 
                        $productReview = \App\Models\ProductReview::where('product_id',$product->id)->latest()->get();
                        if(count($productReview) > 0){
                           $ratingsum = \App\Models\ProductReview::where('product_id',$product->id)->avg('rating');
                           $product->rating_count = round($ratingsum);
                        }else{
                           $product->rating_count = "0";
                        }
                     ?>
                     @endif
                    
                        
                       <div class="main-frame">
                       <a href="{{url('product-details?id=')}}{{$product->id}}">
                          <div class="product-thumbnail">
                             <img src="{{ asset('upload/images/')}}/{{$image[0]}}">
                             <div class="wish-btn">
                                <div class="tag-status">
                                   <span>NEW</span>
                                  <!--  <a href="{{url('/add-wish-list?id=')}}{{$product->id}}"> -->
                                   <a href="javascript::void(0)" onclick="wishlist({{$product->id}})">
                                      <?php if(Auth::user()){ $isWishlist = \App\Models\Wishlist::where('product_id',$product->id)->where('user_id',Auth::user()->id)->first(); }else{
                                         $isWishlist = "";
                                      } ?>
                                      @if(!empty($isWishlist))
                                        <img class="is_fav{{$product->id}}"  src="{{ asset('website/img/favorite.svg')}}">
                                      @else
                                       <img class="is_fav{{$product->id}}" src="{{ asset('website/img/wish.svg')}}">
                                      @endif
                                   </a>
                                </div>
                             </div>
                             <div class="atc"><a href="javascript::void(0)" onclick="addToCart({{$product->id}},1)">Add To Cart</a></div>
                          </div>
                          <div class="product-info">
                             <div class="star-miles">
                                <div class="rating">
                                  <input type="checkbox" name="rrating{{$key}}" value="5" id="r5{{$key}}" @if($product->rating_count == 5) checked @else @endif><label for="r5{{$key}}">☆</label>
                                  <input type="checkbox" name="rrating{{$key}}" value="4" id="r4{{$key}}" @if($product->rating_count == 4) checked @else @endif><label for="r4{{$key}}">☆</label>
                                  <input type="checkbox" name="rrating{{$key}}" value="3" id="r3{{$key}}" @if($product->rating_count == 3) checked @else @endif><label for="r3{{$key}}">☆</label>
                                  <input type="checkbox" name="rrating{{$key}}" value="2" id="r2{{$key}}" @if($product->rating_count == 2) checked @else @endif><label for="r2{{$key}}">☆</label>
                                  <input type="checkbox" name="rrating{{$key}}" value="1" id="r1{{$key}}" @if($product->rating_count == 1) checked @else @endif><label for="r1{{$key}}">☆</label>
                                </div>
                                <div class="distance">
                                   <img src="{{ asset('website/img/location1.svg')}}"> 9 Miles
                                </div>
                             </div>
                             <h4 class="product-title">{{$product->name}}</h4>
                             <p class="price">${{$product->price}}</p>
                          </div>
                          </a>
                       </div>
                  
                
                  @endforeach
                
            </div>
             @else
                 <div><h3>No Product Found</h3></div>
                 @endif
            </div>
        </div>
      </div>
    </div>
@endsection