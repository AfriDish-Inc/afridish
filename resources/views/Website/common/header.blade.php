<div class="container-fluid header">
   <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
         <a class="navbar-brand logo" href="{{url('/')}}"><img src="{{ asset('website/img/logo.png')}}" ></a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
               <li class="nav-item">
                  <a class="nav-link" href="{{url('vendors')}}">VENDORS</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="{{url('restaurants')}}">RESTAURANTS</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="{{url('chefs')}}">CHEF</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="{{url('businesses')}}">FOR BUSINESSES</a>
               </li> 
               
               <li class="nav-item">
                  <a class="nav-link" href="{{url('learn')}}">LEARN</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="{{url('/product')}}">Products</a>
               </li>
               
               <div class="usr-choice">
               <li class="nav-item">
                  <a class="nav-link icn" href="#"><img src="{{ asset('website/img/bell.svg')}}"></a>
               </li>
               
               @if(Auth::user())
               <li class="nav-item">
                  <a class="nav-link icn" href="{{url('wish-list')}}"><img src="{{ asset('website/img/wish-hdr.svg')}}"><span id="wish_count">{{ App\Models\Wishlist::where('user_id',Auth::user()->id)->count() ?? "" }}</span> </a>
               </li>

               <li class="nav-item">
                  <a class="nav-link icn" href="{{url('shoping-cart')}}"><img src="{{ asset('website/img/cart.svg')}}"><span id="cart_count">{{ App\Models\Cart::where('user_id',Auth::user()->id)->count() ?? "" }}</span> </a>
               </li>
               </div>
               <form class=" form-inline my-2 my-lg-0 nav-item dropdown">
                <a href="#" class="signout nav-link dropdown-toggle"  id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      {{ Auth::user()->name }}
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                     <a class="dropdown-item" href="{{url('profile-setting')}}"><img src="{{ asset('website/img/user.svg') }}"> My Profile</a>
                     <!-- <a class="dropdown-item" href="#"><img src="{{ asset('website/img/support.svg') }}"> Support</a> -->
                     <a class="dropdown-item" href="#"><img src="{{ asset('website/img/settings.svg') }}"> Settings</a>
                     <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();"><img src="{{ asset('website/img/logout.svg') }}"> Log Out</a>
                  </div>
               </form>
               @else
               <li class="nav-item">
                  <a class="nav-link" href="{{url('login')}}">LOGIN</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link sign-up" href="{{url('register')}}">SIGN UP</a>
               </li>
               @endif
            </ul>
         </div>
      </nav>
   </div>
</div>