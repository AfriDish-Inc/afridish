@extends('layouts.user')
@section('content')
<script>
  @if(Session::has('message'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
      toastr.success("{{ session('message') }}");
  @endif

  @if(Session::has('errors'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
      toastr.error("{{ session('errors') }}"); 
  @endif
</script>
<div class="container product-details"> 
<div class="row">
   <div class="col-md-5">
      <div id="page">
         <div class="row">
            <div class="Slider-Syncing">
               <?php if($products->image){ $images = explode('|', $products->image); }   ?>
               @if(count($images) > 0 )
               <div class="slider slider-for">
                  @foreach($images as $key => $value)
                     <div><img src="{{ asset('upload/images/')}}/{{$value}}"></div>
                  @endforeach
               </div>
               <div class="slider slider-nav">
                   @foreach($images as $key => $value)
                     <div><img src="{{ asset('upload/images/')}}/{{$value}}"></div>
                  @endforeach
               </div>
               @endif
               
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-7">
      <div class="product-information">
         <h4>{{$products->name}}</h4>
         <div class="rating">
  
  <input type="radio" name="rating" value="5" id="5" @if(round($rating_count) == 5)checked @else @endif><label for="5">☆</label>
  <input type="radio" name="rating" value="4" id="4" @if(round($rating_count) == 4)checked @else @endif><label for="4">☆</label>
  <input type="radio" name="rating" value="3" id="3" @if(round($rating_count) == 3)checked @else @endif><label for="3">☆</label>
  <input type="radio" name="rating" value="2" id="2" @if(round($rating_count) == 2)checked @else @endif><label for="2">☆</label>
  <input type="radio" name="rating" value="1" id="1" @if(round($rating_count) == 1)checked @else @endif><label for="1">☆</label>
</div><span class="review">{{$reviewCount}} Review</span><img src="{{ asset('website/img/line.svg')}}"><a href="#review" class="review">Write A Review</a>
         <p class="product-price">${{$products->price}}</p>
         <a href="javascript::void(0)" onclick="wishlist({{$products->id}})">
             <?php if(Auth::user()){ $isWishlist = \App\Models\Wishlist::where('product_id',$products->id)->where('user_id',Auth::user()->id)->first(); }else{ $isWishlist = ""; } ?>
               @if(!empty($isWishlist))
                <img class="is_fav{{$products->id}}" src="{{ asset('website/img/favorite.svg')}}">
               @else
                <img class="is_fav{{$products->id}}" src="{{ asset('website/img/wish.svg')}}">
               @endif

            Add To Wishlist</a>
      </div>
      <div class="p-description">
         <p>{{$products->detail}}</p>  
         <ul class="brands">
            <li><label>Brand</label> : <span class="custom-mark">{{App\Models\Brand::where('id',$products->brand_id)->first()->name}}</span></li>
            <li><label>Product Code</label> : <span>{{$products->sku}}</span></li>
            <li><label>Availability</label> : <span class="custom-mark">@if($products->quantity > 0) In Stock @else Out of Stock @endif</span></li>
         </ul>
         <div class="atc-data">
            <p>Qty 
            <form><input type="number" name="" placeholder="1"><a href="javascript::void(0)" onclick="addToCart({{$products->id}},1)" class="add-to-bag"><img src="{{ asset('website/img/bag.svg')}}">Add To Cart</a></form>
            </p>
         </div>
      </div>
   </div>
</div>
</div>
<div class="container-fluid tabs-section">
      <ul class="container nav nav-tabs">
         <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#description">Description</a>
         </li>
         <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#review">Reviews</a>
         </li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content">
         <div id="description" class="container tab-pane fade">
            <br>
            <p>{{$products->description}}</p>
         </div>
         <div id="review" class="container tab-pane  active">
            <br>
            <div class="container-fluid reviews-section">
               <div class="row">
                  <div class="col-md-6">
                     <div class="review-div">
                        <h4>Write A Review</h4>
                        <form class="review-form" action="{{url('/submit-review')}}" method="post">
                           @csrf
                           <input type="hidden" name="product_id" value="{{$products->id}}">
                           <label>Rate The Product</label>
                           <div class="rating">
                             <input type="radio" name="rating" value="5" id="10"><label for="10">☆</label>
                             <input type="radio" name="rating" value="4" id="9"><label for="9">☆</label>
                             <input type="radio" name="rating" value="3" id="8"><label for="8">☆</label>
                             <input type="radio" name="rating" value="2" id="7"><label for="7">☆</label>
                             <input type="radio" name="rating" value="1" id="6"><label for="6">☆</label>
                           </div>

                           <div class="form-groups">
                              
                              <div class="name">
                                 <label>Name</label>
                                 <input type="text" name="name" value="{{Auth::user()->name ?? ''}}" readonly>
                              </div>
                              <div class="email">
                                 <label>Email</label>
                                 <input type="text" pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)+$" name="email" value="{{Auth::user()->email ?? ''}}" readonly>
                              </div>
                           </div>
                           <div class="form-group">
                              <label>Message</label>
                              <textarea rows="3" cols="40" name="message" required>{{ old('message') }}</textarea>
                           </div>
                           <div class="submit-cancel">
                              <button type="submit" class="sbmt">Submit</button>
                              <a href="#" class="cncl">Cancel</a>
                           </div>
                        </form>
                     </div>
                  </div>
                  <div class="col-md-6">
                     @if(count($productReview) > 0)
                     @foreach($productReview as $key=>$reviewvalue)
                     <div class="product-review">
                        <div class="reviewer-name">
                           <div class="name-design">
                              <h4>{{$reviewvalue->name}}</h4>
                              <span>Client</span>
                           </div>
                        </div>
                        <p>{{$reviewvalue->message}}</p>
                        <div class="rating">
                          <input type="radio" name="rating{{$key}}" value="5" id="{{$key}}5" @if(round($reviewvalue->rating) == 5)checked @else @endif><label for="{{$key}}5">☆</label>
                          <input type="radio" name="rating{{$key}}" value="4" id="{{$key}}4" @if(round($reviewvalue->rating) == 4)checked @else @endif><label for="{{$key}}4">☆</label>
                          <input type="radio" name="rating{{$key}}" value="3" id="{{$key}}3" @if(round($reviewvalue->rating) == 3)checked @else @endif><label for="{{$key}}3">☆</label>
                          <input type="radio" name="rating{{$key}}" value="2" id="{{$key}}2" @if(round($reviewvalue->rating) == 2)checked @else @endif><label for="{{$key}}2">☆</label>
                          <input type="radio" name="rating{{$key}}" value="1" id="{{$key}}1" @if(round($reviewvalue->rating) == 1)checked @else @endif><label for="{{$key}}1">☆</label>
                        </div>
                     </div>
                     @endforeach
                     @else
                     <h4 class="no-rating-found">No rating found</h4>
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="container-fluid prodcts">
      <div class="container brands">
         <div class="row">
            <div class="col-md-3">
               <div class="wrapper">
                  <h2>Related Products</h2>
                  <p>Browse the collection of the category products.</p> 
                  <a href="{{url('product')}}" class="v-products">View All Products</a> 
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
                     @else
                     <div><h3>No Product Found</h3></div>
                     @endif
               </div>
            </div>
         </div>
      </div>
   </div>
   @endsection