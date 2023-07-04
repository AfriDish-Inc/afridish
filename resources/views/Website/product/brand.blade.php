@extends('layouts.user')
@section('content')

<div class="container-fluid b-all-products">
         <div class="container testimonials subscription">
            <div class="row">
               <div class="col-md-12">
                  <div class="wrapper all-products">
                     <h2>All Brands</h2>
                     <p>Browse the collection of the category products.</p>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="row t-brands">
                  	@if(count($brands) > 0)
                  	@foreach($brands as $key => $brand)
                     <div class="col-md-2">
                           <div class="product-thumbnail">
                              <img src="{{ asset('upload/images/')}}/{{$brand->cover_image}}">
                              <div class="wish-btn">
                                 <div class="tag-status">
                                    <span class="tag">{{$brand->name}}</span>
                                   <!--  <a href="#"><img src="{{ asset('website/img/wwish.svg')}}"></a> -->
                                 </div>
                              </div>
                           </div>
                     </div>
                     @endforeach
                     @else
                     <div><h3>No Brand Found</h3></div>
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </div>
@endsection