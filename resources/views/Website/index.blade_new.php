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

  @if(Session::has('success'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
      toastr.success("{{ session('success') }}");
  @endif
</script>

<div class="container-fluid banner"> 
   <div class="container">
     
      <div class="searc-location">
         <div class="srch"><img src="{{ asset('website/img/search-icon.svg')}}">
            <form class="form-inline my-2 my-lg-0" action="{{url('/')}}">
            <input class="form-control mr-sm-2" type="search" name="search" placeholder="Products" aria-label="Search">
            </form>
         </div>
         <div class="srch snd"><img src="{{ asset('website/img/location.svg')}}">
            <form class="form-inline my-2 my-lg-0" action="{{url('/')}}">
              
              <div id="map" class="form-group">  
                 <input id="pac-input" class="form-control mr-sm-2" placeholder="Insert the location"  name="address" ame="location" type="text">  
                 <div id="map-canvas"> </div>  
                 <input name="latitude" class="lat"  type="hidden">  
                 <input name="longitude" class="lon"  type="hidden">  
            </div>
            </form>
         </div>
      </div>
   
      <div class="home-slider owl-carousel js-fullheight">
         <div class="slider-item js-fullheight">
            <div class="overlay"></div>
            <div class="container">
               <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
                  <div class="col-md-7 ftco-animate">
                     <h1>WELCOME TO HOME OF CANNABIS</h1>
                     <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                     
                  </div>
                  <div class="col-md-5 ftco-animate">
                     <img src="{{ asset('website/img/banner.png')}}">
                  </div>
               </div>
            </div>
         </div>
         <div class="slider-item js-fullheight" style="background-image:url({{ asset('website/img/slider-2.jpg')}});">
            <div class="overlay"></div>
            <div class="container">
               <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
                  <div class="col-md-7 ftco-animate">
                     <h1>KAABO SI ILE CANNABIS</h1>
                     <p>Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                    
                  </div>
                  <div class="col-md-5 ftco-animate">
                     <img src="{{ asset('website/img/banner.png')}}">
                  </div>
               </div>
            </div>
         </div>
         <div class="slider-item js-fullheight" style="background-image:url({{ asset('website/img/slider-2.jpg')}});">
            <div class="overlay"></div>
            <div class="container">
               <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
                  <div class="col-md-7 ftco-animate">
                     <h1>KARIBU NYUMBANI KWA CANNABIS</h1>
                     <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                     
                  </div>
                  <div class="col-md-5 ftco-animate">
                     <img src="{{ asset('website/img/banner.png')}}">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!--brands-->
<div class="container brands">
   <div class="row">
      <div class="col-md-3">
         <div class="wrapper">
            <h2>Top Brands</h2>
            <p>Lorem Ipsum has been the industry's standard dummy text</p>
            <a href="{{url('product-brand')}}" class="v-products">View All Brands</a> 
         </div>
      </div>
      <div class="col-md-9">
         <div class="my-slider">
            @if(count($brands) > 0)
               @foreach($brands as $key => $brand)
               <div>
                  <div class="product-thumbnail">
                     <img src="{{ asset('upload/images/')}}/{{$brand->cover_image}}">
                     <div class="wish-btn">
                        <div class="tag-status">
                           <span class="tag">{{$brand->name}}</span>
                        </div>
                     </div>
                  </div>
               </div>
               @endforeach
            @endif
         </div>
      </div>
   </div>
</div>
<!-- Shipping -->
<div class="container-fluid shipping">
   <div class="container">
      <div class="row">
         <div class="col-md-4">
            <div class="box">
               <div class="box-left">
                  <img src="{{ asset('website/img/truck.svg')}}">
               </div>
               <div class="box-right">
                  <h4>Free Shipping & Return</h4>
                  <p>On all order over $99.00</p>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="box">
               <div class="box-left">
                  <img src="{{ asset('website/img/earphone.svg')}}">
               </div>
               <div class="box-right">
                  <h4>Customer Support 24/7</h4>
                  <p>Instant access to support</p>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="box">
               <div class="box-left">
                  <img src="{{ asset('website/img/card.svg')}}">
               </div>
               <div class="box-right">
                  <h4>100% Secure Payment</h4>
                  <p>We ensure secure payment!</p>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!--featured products-->
<div class="container-fluid prodcts">
   <div class="container brands">
      <div class="row">
         <div class="col-md-3">
            <div class="wrapper">
               <h2>Featured Vendors</h2>
               <a href="{{url('vendors?is_feature=1')}}" class="v-products">View All Vendor</a> 
            </div>
         </div>
         <div class="col-md-9">
            <div class="my-sliderp"> 
               @foreach(\App\Models\User::where('is_feature',1)->paginate(10) as $key=>$featureproduct)
                  <div class="main-frame">
                    <a href="{{url('vendor-details?id=')}}{{$featureproduct->id}}">
                     <div class="product-thumbnail">
                        <img src="{{ asset('upload/images/')}}/{{$featureproduct->profile_picture}}">
                     </div>
                     <div class="product-info">
                        <h4 class="product-title">{{$featureproduct->name}}</h4> 
                     </div>
                     </a>
               </div>
            @endforeach
            </div>
         </div>
      </div>
   </div>
</div>
<!--singleporduct-->
<div class="container-fluid singlep">
   <div class="container">
      <div class="row f-section">
         <div class="col-md-6">
            <div class="img-sec"><img src="{{ asset('website/img/p.png')}}"></div>
         </div>
         <div class="col-md-6">
            <h2>Explore Best Brand,Products</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            <div class="explore-two">
               <a href="#" class="explore">Let’s Connect</a> 
               <a href="#" class="v-products">About Us</a> 
            </div>
         </div>
      </div>
   </div>
</div>
<!--Latest products-->
<div class="container-fluid prodcts">
   <div class="container brands">
      <div class="row">
         <div class="col-md-3">
            <div class="wrapper">
               <h2>Recommended Vendors</h2>
               <a href="{{url('product')}}" class="v-products">View All Vendors</a> 
            </div>
         </div>
         <div class="col-md-9">
            <div class="my-sliderp">
               @foreach(\App\Models\User::where('is_recommended',1)->paginate(10) as $key=>$featureproduct)
                  <div class="main-frame">
                    <a href="{{url('vendor-details?id=')}}{{$featureproduct->id}}">
                     <div class="product-thumbnail">
                        <img src="{{ asset('upload/images/')}}/{{$featureproduct->profile_picture}}">
                     </div>
                     <div class="product-info">
                        <h4 class="product-title">{{$featureproduct->name}}</h4> 
                     </div>
                     </a>
               </div>
            @endforeach
            </div>
         </div>
      </div>
   </div>
</div>
<!--Search By Category-->
<div class="container brands category">
   <div class="row">
      <div class="col-md-3">
         <div class="wrapper">
            <h2>Search By Category</h2>
            <p>Browse the collection of the categories.</p>
         </div>
      </div>
      <div class="col-md-9">
         <div class="row category-boxes">
            @if(count($categories) > 0)
               @foreach($categories as $key => $category)
                  
                  <div class="col-md-4">
                  <a href="{{url('product?category_id=')}}{{$category->id}}">
                     <div class="block-box">
                        <img src="{{ asset('upload/images/')}}/{{$category->image}}">
                        <p class="overlay">{{$category->category_name}}</p>
                     </div>
                     </a>
                  </div>
                  
                @endforeach
             @endif
         </div>
      </div>
   </div>
</div>
<!--testimonail section -->
<div class="container-fluid testimoni">
   <div class="container testimonials">
      <div class="row">
         <div class="col-md-12">
            <div class="wrapper">
               <h2>Our Proud Customers</h2>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="my-slideres">
               @foreach($testimonials as $testimonial)
               <div>
                  <div class="testimonial-sec">
                     <div class="left">
                        <img src="{{ asset('upload/images/')}}/{{$testimonial->cover_image}}">
                     </div>
                     <div class="right">
                        <img src="{{ asset('website/img/quotes.svg')}}">
                        <p>{{$testimonial->message}}</p>
                        <h4>{{$testimonial->title}}</h4>
                        <span>{{$testimonial->name}}</span>
                     </div>
                  </div>
               </div>
               @endforeach
            </div>
         </div>
      </div>
   </div>
</div>
<!--testimonail section -->
<!-- <div class="container-fluid ">
   <div class="container testimonials subscription">
      <div class="row">
         <div class="col-md-12">
            <div class="wrapper">
               <p>Subscribe to us to get the latest updates</p>
               <h2>12% Member Discount</h2>
               <form>
                  <div class="search-box">
                     <img src="{{ asset('website/img/email.svg')}}"><input type="search" placeholder="Please enter your email to subscribe">
                     <a href="#">Subscribe</a>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div> -->
@endsection