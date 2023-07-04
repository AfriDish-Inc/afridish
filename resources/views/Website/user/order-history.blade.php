@extends('layouts.user')
@section('content')
<?php //echo "<pre>"; print_r($orders); die; ?>
<div class="container testimonials subscription">
    <div class="row">
        <div class="col-md-12">
          <div class="wrapper all-products">
            <h2>Order History</h2>
            </div>

        </div>
      </div>
      </div>
      </div>
     
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
      <a class="nav-link active" href="{{url('order-history')}}"><img src="{{ asset('website/img/o-history.svg')}}"> ORDER HISTORY</a>
    </li>
   <!--  <li class="nav-item">
      <a class="nav-link" href="{{url('order-history')}}"><img src="{{ asset('website/img/saved.svg')}}"> SAVED ADDRESSES</a>
    </li> -->
  </ul>
</div>
  <!-- Tab panes -->
  <div class="col-md-9">
  <div class="tab-content">
     <div id="order-history" class="container tab-pane active">
        <div class="row">
            <div class="col-md-12">
                <div class="my-wishlist">
                  <p class="page-navigation"><span>Home/<a href="#">Order</a></p>
                 @foreach($orders as $key => $order)
                 <input type="hidden" class="order_id" name="order_id" value="{{$order->id}}">
                  <div class="wish-lists">
                      <div class="p-image"><img src="{{ asset('upload/images/')}}/{{$order->product_image}}"></div>
                      <h4>{{$order->product_name}}</h4>
                      <div class="rating-set">
                        <label>Give Rating</label>
                        <div class="rating">
  
                           <input type="radio" class="rating_value"  name="rating" value="5" id="15"><label for="15">☆</label>
                           <input type="radio" class="rating_value" name="rating" value="4" id="14"><label for="14">☆</label>
                           <input type="radio" class="rating_value" name="rating" value="3" id="13"><label for="13">☆</label>
                           <input type="radio" class="rating_value" name="rating" value="2" id="12"><label for="12">☆</label>
                           <input type="radio" class="rating_value" name="rating" value="1" id="11"><label for="11">☆</label>
                          </div>
                      </div>

                      <p class="price">${{$order->price}}</p>
                      <a class="btn btn-success" href="{{url('order-details?id=')}}{{$order->id}}">View Order</a>
                      <!-- <a href="#" class="atc-btn">Ask For Refund</a>
                      <a href="#" class="o-stbtn"> Deliverd </a> -->
                  </div>
                  @endforeach
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
@section('scripts')
@parent

<script>
   function updateProductStatus(order_id,rating_val)
    {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        
        if (confirm('{{ trans('global.areYouSure') }}')) 
        {
            $.ajax({
                method: 'POST',
                url: 'order-rating',
                data: { order_id: order_id, rating: rating_val },
                success: function (data){
                    $(".update-status").show(); 
                    window.setTimeout(function(){location.reload()},2000);
                }
            })
        }

        else{
            location.reload();
        }
    }

    // Update category status
    $('.rating_value"]').click(function()
    {
        alert('test');
        var order_id = $(this).val('order_id');
        
        var status = 1;

        updateProductStatus(order_id,rating_val);
    });

</script>
@endsection