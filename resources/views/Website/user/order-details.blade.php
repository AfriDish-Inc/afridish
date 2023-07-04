@extends('layouts.user')
@section('content')
<?php //echo "<pre>"; print_r($itemdata);die; ?>
<div class="container-fluid b-all-products">
  <div class="container testimonials subscription">
    <div class="row">
        <div class="col-md-12">
          <div class="wrapper all-products">
            <h2>Order Details</h2>
            </div>

        </div>
      </div>
      <div class="row">
          <div class="col-md-12">
              <div class="my-wishlist orders">
                  <p class="page-navigation order-page"><span>Home/<a href="#">Order Details</a></p>
                  	@foreach($itemdata as $value)
                  <div class="placed-order">
                      <div class="o-image">
                          <img src="{{ asset('upload/images/')}}/{{$value->product_image}}">
                      </div>  
                      <div class="o-description">
                          <h4>{{$value->product_name}}</h4>
                          <p class="t-price">${{$value->price}}</p>
                          <p class="qty">Quantity : <span class="qty-total">{{$value->order_quantity}}</span></p>
                          <!-- <div class="sfl">
                              <a href="#">SAVE FOR LATER</a>
                              <a href="#">REMOVE</a>
                          </div> -->
                      </div>
                     <!--  <p class="o-stat in-stock">In Stock</p> -->
                  </div>
                  @endforeach
                  
                  <div class="po-goback">
                        <a href="{{url('order-history')}}" class="cncl">Go Back</a>
                  </div>
              </div>

          </div>    
      </div>
</div>
@endsection