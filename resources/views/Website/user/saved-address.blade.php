@extends('layouts.user')
@section('content')
<?php //echo "<pre>"; print_r($cartdata); die; ?>
<div class="container shopping-cart">
 <script>
  @if(Session::has('message'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
      toastr.success("{{ session('message') }}");
  @endif
</script>
  <div class="row">
  <div class="col-md-3">
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link " href="{{url('shoping-cart')}}"><img src="{{ asset('website/img/cart-c.svg')}}"> CART</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('billing-address')}}"><img src="{{ asset('website/img/user.svg')}}"> BILLING ADDRESS</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('checkout')}}"><img src="{{ asset('website/img/support.svg')}}"> CHECKOUT</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('order-history')}}"><img src="{{ asset('website/img/o-history.svg')}}"> ORDER HISTORY</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="{{url('saved-address')}}"><img src="{{ asset('website/img/saved.svg')}}"> SAVED ADDRESSES</a>
    </li>
  </ul> 
</div>
  <!-- Tab panes -->
  <div class="col-md-9">
  <div class="tab-content">
     <div id="order-history" class="container tab-pane active">
        <div class="row">
            <div class="col-md-12">
                <div class="my-wishlist">
                  <p class="page-navigation"><span>Home/<a href="#">Cart</a></p>
                  <div class="wish-lists">
                      <div class="p-image"><img src="{{ asset('website/img/product.png')}}"></div>
                      <h4>Impact Whey Protein</h4>
                      <div class="rating-set">
                        <label>Give Rating</label>
                        <ul class="ratings-star">
                            <li><a><img src="{{ asset('website/img/star.svg')}}"></a></li>
                            <li><a><img src="{{ asset('website/img/star.svg')}}"></a></li>
                            <li><a><img src="{{ asset('website/img/star.svg')}}"></a></li>
                            <li><a><img src="{{ asset('website/img/star.svg')}}"></a></li>
                            <li><a><img src="{{ asset('website/img/star.svg')}}"></a></li>
                        </ul>
                      </div>
                      <p class="price">$100</p>
                      <a href="#" class="atc-btn">Ask For Refund</a>
                      <a href="#" class="o-stbtn">Delivered</a>
                      <a href="" class="close-bt"><img src="{{ asset('website/img/close.svg')}}"></a>
                  </div>
              </div>
            </div>
        </div>
    </div>
  </div>
</div>

</div>
</div>
</div>
@endsection