@extends('layouts.user')
@section('content')
<?php //echo "<pre>"; print_r($cartdata); die; ?>
<div class="container testimonials subscription">
    <div class="row">
        <div class="col-md-12">
          <div class="wrapper all-products">
            <h2>Cart</h2>
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
      <a class="nav-link active" href="{{url('shoping-cart')}}"><img src="{{ asset('website/img/cart-c.svg')}}"> CART</a>
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
   <!--  <li class="nav-item">
      <a class="nav-link" href="{{url('order-history')}}"><img src="{{ asset('website/img/saved.svg')}}"> SAVED ADDRESSES</a>
    </li> -->
  </ul>
</div>
  <!-- Tab panes -->
  <div class="col-md-9">
  <div class="tab-content">
    
    <div id="cart" class="container tab-pane active">
        <div class="row">
          <div class="col-md-8">
              <div class="my-wishlist">
                  <p class="page-navigation"><span>Home/<a href="#">Cart</a></p>
                    <span style="color:#38D77D" id="ajax_meesasge"></span>
                    @foreach($cartdata as $key=>$cartvalue)
                     @if($cartvalue->image)
                     @php $image = explode('|',$cartvalue->image); @endphp
                     @endif

                  <div class="wish-lists">
                      <div class="p-image"><img src="{{ asset('upload/images/')}}/{{$image[0]}}"></div>
                      <h4>{{$cartvalue->name}}</h4>
                      <div class="product-count">
                        <input type="hidden" class="product_id"  name="product_id" value="{{$cartvalue->id}}">
                        <input type="hidden" class="cart_id"  name="cart_id"  value="{{$cartvalue->cart_id}}">
                        <input type='button' value='-' class='qtyminus button-count no-active' field='product_quantity' />
                        <input type='number' name='product_quantity' min="1" max="10"  readonly value='{{$cartvalue->product_quantity}}' class='qty number-product' />
                        <input type='button' value='+' class='qtyplus button-count'  field='product_quantity' />
                      </div>
                      <p class="price">${{$cartvalue->sub_total}}</p>
                      <a  href="{{url('delete-cart-product')}}/{{$cartvalue->cart_id}}" class="close-bt"><img src="{{ asset('website/img/close.svg')}}"></a>
                  </div>
                  @endforeach
              </div>

          </div>    
          <div class="col-md-4">
              <div class="summary">
                  <h4>Summary</h4>
                  <div class="order-total">
                      <p>Order Total</p>
                      <p>${{array_sum($total)}}</p>
                  </div>
                  <div class="order-total">
                      <p>VAT (20%):</p>
                      <p>${{array_sum($total)*.2}}</p>
                  </div>
                  <div class="order-total">
                      <p>Shipping</p>
                      <p>$0</p>
                  </div>
                  <div class="order-final">
                      <p>Subtotal</p>
                      <p>${{array_sum($total)+(array_sum($total)*.2)+0}}</p>
                  </div>
                  <form action="{{url('checkout')}}">
                    <button type="submit" class="pay-now" @if(array_sum($total)+(array_sum($total)*.2) > 0) @else disabled @endif> Proceed Checkout</button>
                  </form>
                  
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