@extends('layouts.user')
@section('content')
<?php //echo "<pre>"; print_r($products); die;  ?>
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

<div class="container-fluid b-all-products">
         <div class="container testimonials subscription">
            <div class="row">
               <div class="col-md-12">
                  <div class="wrapper all-products">
                     <h2>Browse All Products</h2>
                     <p>Browse the collection of the category products.</p>
                  </div>
               </div>
            </div>
            <div class="row"> 
               <div class="col-md-3">
                  <div class="filter">
                     <div class="heading">
                        <h4>Filter</h4>
                        <img src="{{ asset('website/img/filter.svg')}}">
                     </div>
                     <div class="catelog sorting">
                        <div class="s-left">
                           <h5>Sort By</h5>
                          <!--  <select>
                              <option>Default</option>
                              <option>Newest</option>
                              <option>Popular</option>
                           </select> -->
                            <select class="form-select type_check" id="dynamic_select" name="sortBy" aria-label="Default select example">
                               <option value="">Sorting</option>
                               <option  value="lth">Newest</option>
                               <option  value="htl">Oldest</option>
                           </select>
                        </div>
                        <div class="s-left">
                           <h5>Show</h5>
                           <select>
                              <option>8</option> 
                              <option>10</option>
                              <option>12</option>
                              <option>18</option>
                           </select>
                        </div>
                     </div>
                     <!--range slider -->
                     <div class="catelog">
                        <h5>Price</h5>
                        <!-- <div class="slider">
                           <div class="progress"></div>
                        </div>
                        <div class="range-input">
                           <input type="range" class="range-min" min="0" max="6000" value="0" step="100">   
                           <input type="range" class="range-max" min="0" max="6000" value="6000" step="100">
                        </div>
                        <div class="price-input">
                           <div class="field">
                              $
                              <input type="number" name="price" class="input-min" value="0">
                           </div>
                        </div> -->
                        <label for="customRange1" class="form-label">$<span class="range-value">0</span> </label>
                            <input type="range" class="form-range type_check" name="price" id="customRange1" value="0"  min="0" max="6000" oninput="this.nextElementSibling.value = this.value">
                     </div>
                     <div class="catelog">
                        <h5>Category</h5>
                        <div class="checkbox-list">
                           	@if(count($categories) > 0)
                              @foreach($categories as $key => $category)
                              <div class="form-group">
                                 <input class="type_check categoryFilter" name="category_id[]" type="checkbox" value="{{$category->id}}" id="cat{{$key}}">
                                 <label for="cat{{$key}}">{{$category->category_name}}</label>
                              </div>
                      	     @endforeach
                             @endif		
                           <!-- @if(count($categories) > 10)
                           <a href="#">View More <img src="{{ asset('website/img/arrow.svg')}}"></a>
                           @endif -->
                        </div>
                     </div>
                     <div class="catelog">
                        <h5>Brands</h5>
                        <div class="checkbox-list">
                           <form>
                           	  @if(count($brands) > 0)
                            	    @foreach($brands as $key => $brand)
	                                <div class="form-group">
	                                   <input type="checkbox" class="form-check-input type_check" name="brand_id[]" value="{{$brand->id}}" id="bran{{$key}}">
	                                   <label for="bran{{$key}}">{{$brand->name}}</label>
	                                </div>
	                                @endforeach
                                @endif
                           </form>
                           <!-- @if(count($brands) > 10)
                              <a href="#">View More <img src="{{ asset('website/img/arrow.svg')}}"></a>
                           @endif -->
                        </div>
                     </div>
                     
                  </div>
               </div>
               <div class="col-md-9">
                  <div class="row allproducts" id="products">
                  @if(count($products) > 0)
                  	@foreach($products as $key => $product)
                  	@if($product->image)
                     <?php $image = explode('|',$product->image); ?>
                     @endif
                  	 <a href="{{url('product-details?id=')}}{{$product->id}}">
	                     <div class="col-md-3">
	                        <div class="main-frame">
	                           <div class="product-thumbnail">
	                              <img src="{{ asset('upload/images/')}}/{{$image[0]}}">
	                              <div class="wish-btn">
	                                 <div class="tag-status">
	                                    
                                       <!-- <a href="{{url('/add-wish-list?id=')}}{{$product->id}}"> -->
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
	                              <!-- <div class="atc"><a href="{{url('/addcartlist?product_id=')}}{{$product->id}}&product_quantity=1">Add To Cart</a></div> -->
                                 <div class="atc"><a href="javascript::void(0)" onclick="addToCart({{$product->id}},1)">Add To Cart</a></div>
	                           </div>
	                           <div class="product-info">
	                              <div class="star-miles">
                                    <div class="rating">
                                      <input type="radio" name="prating{{$key}}" value="5" id="p5{{$key}}" @if(round($product->rating_count) == 5) checked @else @endif><label for="p5{{$key}}">☆</label>
                                      <input type="radio" name="prating{{$key}}" value="4" id="p4{{$key}}" @if(round($product->rating_count) == 4) checked @else @endif><label for="p4{{$key}}">☆</label>
                                      <input type="radio" name="prating{{$key}}" value="3" id="p3{{$key}}" @if(round($product->rating_count) == 3) checked @else @endif><label for="p3{{$key}}">☆</label>
                                      <input type="radio" name="prating{{$key}}" value="2" id="p2{{$key}}" @if(round($product->rating_count) == 2) checked @else @endif><label for="p2{{$key}}">☆</label>
                                      <input type="radio" name="prating{{$key}}" value="1" id="p1{{$key}}" @if(round($product->rating_count) == 1) checked @else @endif><label for="p1{{$key}}">☆</label>
                                    </div>
	                              </div>
                                 
	                              <h4 class="product-title">{{$product->name}}</h4>
	                              <p class="price">${{$product->price}}</p>
	                           </div>
	                        </div>
	                     </div>
                     </a>
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