<footer>
   <div class="container">
      <div class="row">
         <div class="col-md-3">
            <img class="footer-logo" src="{{ asset('website/img/logo.png')}}">
         </div>
         <div class="col-md-3">
            <h2>Quick Links</h2>
            <ul class="f-menu">
               <li><a href="{{url('vendors')}}">Vendors</a></li>
               <li><a href="#">Restaurants</a></li>
               <li><a href="#">Chef</a></li>
               <li><a href="{{url('businesses')}}">For Businesses</a></li>
               <li><a href="{{url('product')}}">Products</a></li>
               <li><a href="{{url('learn')}}">Learn</a></li>
            </ul>
         </div>
         <div class="col-md-3">
            <h2>Company</h2>
            <ul class="f-menu">
               <li><a href="{{url('about-us')}}">About Us</a></li>
               <li><a href="{{url('contact-us')}}">Contact Us</a></li>
               <!-- <li><a href="{{url('vendors?vendor_category_id=')}}2">Brands</a></li> -->
               <li><a href="{{url('branch')}}">Branches</a></li>
            </ul>
         </div>
         <div class="col-md-3">
            <h2>Reach Us :</h2>
            <ul class="f-menu">
               <li><a href="#"><img src="{{ asset('website/img/locate.svg')}}">Toronto, Canada </a></li>
               <li><a href="#"><img src="{{ asset('website/img/fmail.svg')}}"> Support@afridish.ca</a></li>
            </ul>
            <h2>Follow Us :</h2>
            <ul class="f-icons">
               <li><a target="_blank" href="https://www.facebook.com/Afridishca/"><img src="{{ asset('website/img/facebook.png')}}"></a></li>
               <li><a target="_blank" href="https://twitter.com/afridishca"><img src="{{ asset('website/img/twitter.png')}}"></a></li>
               <li><a target="_blank" href="https://www.linkedin.com/company/afridish/"><img src="{{ asset('website/img/linked-in.svg')}}"></a></li>
               <li><a target="_blank" href="https://www.instagram.com/afridishca/"><img src="{{ asset('website/img/instagram.png')}}"></a></li>
            </ul>
         </div>
      </div>
      <div class="row copyright">
         <div class="col-md-8">
            <ul class="copyright-menu">
               <li><a href="{{url('privacy')}}">Privacy Policy</a></li>
               <li><a href="{{url('term-condition')}}">Term of use</a></li>
            </ul>
         </div>
         <div class="col-md-4">
            <p>© 2023 AfriDish. All rights reserved.</p>
         </div>
      </div>
   </div>
</footer>