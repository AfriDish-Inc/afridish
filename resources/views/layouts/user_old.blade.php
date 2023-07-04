<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,500;0,700;0,800;1,200;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- style -->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet"href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
  </head>
  <body>
  @include('common.header')
  @yield('content')
  <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
      {{ csrf_field() }}
       <input type="hidden" name="user_type" value="C">
  </form>
  @include('common.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
      var swiper = new Swiper(".mySwiper", {
        slidesPerView: 3,
        spaceBetween: 30,
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
      });

      $(function() {
         $('.imgchange img').on('click',  function() {
              $('#changeMe').attr('src', this.src);
          });
      });

      function zoom(e){
        var zoomer = e.currentTarget;
        e.offsetX ? offsetX = e.offsetX : offsetX = e.touches[0].pageX
        e.offsetY ? offsetY = e.offsetY : offsetX = e.touches[0].pageX
        x = offsetX/zoomer.offsetWidth*100
        y = offsetY/zoomer.offsetHeight*100
        zoomer.style.backgroundPosition = x + '% ' + y + '%';
      }

       $(document).ready(function(){
          // This button will increment the value
          $('.qtyplus').click(function(e){
              e.preventDefault();
              var currentVal = $(this).siblings(".qty").val();
              let product_quantity = parseInt(currentVal)+1;
              var cart_id = $(this).siblings(".cart_id").val();
              var product_id = $(this).siblings(".product_id").val();
              if (product_quantity > 0) {
              $.ajax({
                 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                 url: "{{url('updateCart')}}",
                 type: 'POST',
                 data: {cart_id:cart_id,product_quantity:product_quantity,product_id:product_id},
                 success: function(response){
                    $("#ajax_meesasge").text(response.message);
                    window.setTimeout(function(){location.reload()},1000)
                     return false;
                   
                 }

             });
              if (!isNaN(currentVal)) {
                  $(this).siblings(".qty").val(parseInt(currentVal) + 1);
              } else {
                  $(this).siblings(".qty").val(0);
              }
             }else{
               $("#ajax_meesasge").text('Min 1 product should be add !');
             }
          });
          // This button will decrement the value till 0
          $(".qtyminus").click(function(e) {
              e.preventDefault();
              var currentVal = $(this).siblings(".qty").val();
              let product_quantity = parseInt(currentVal)-1;
              var cart_id = $(this).siblings(".cart_id").val();
              var product_id = $(this).siblings(".product_id").val();
               if (product_quantity > 0) {
              $.ajax({
                   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                   url: "{{url('updateCart')}}",
                   type: 'POST',
                   data: {cart_id:cart_id,product_quantity:product_quantity,product_id:product_id},
                   success: function(response){
                     $("#ajax_meesasge").text(response.message);
                    window.setTimeout(function(){location.reload()},1000)
                  }
              });
              if (!isNaN(currentVal) && currentVal > 0) {
                 $(this).siblings(".qty").val(parseInt(currentVal) - 1);
              } else {
                  $(this).siblings(".qty").val(0);
              }
              }else{
               $("#ajax_meesasge").text('Min 1 product should be add !');

             }
            });
          });

        $(document).ready(function(){
          $('.plus').click(function(e){
              e.preventDefault();
              fieldName = $(this).attr('field');
              var currentVal = parseInt($('input[name='+fieldName+']').val());
              if (!isNaN(currentVal)) {
                  $('input[name='+fieldName+']').val(currentVal + 1);
              } else {
                  $('input[name='+fieldName+']').val(0);
              }
          });
          $(".minus").click(function(e) {
              e.preventDefault();
              fieldName = $(this).attr('field');
              //var currentVal = $(this).siblings(".qty").val();
              var currentVal = parseInt($('input[name='+fieldName+']').val());
              if (currentVal > 1) {
                  $('input[name='+fieldName+']').val(currentVal - 1);
              } else {
                  $('input[name='+fieldName+']').val(1);
              }
          });
      });

      $(document).ready(function(){
          $(".type_check").change(function(){
            var price =   $("input[name='price']").val();
             $('.range-value').html(price);
            var sortBy = $('select[name="sortBy"]').find(":selected").val();
            /*var category_id = $.QueryString("category_id");
            category_id = [category_id];*/
            var category_id = [];
            $.each($("input[name='category_id[]']:checked"), function(){            
                category_id.push($(this).val());
            });


           cat_id =  $('.active').attr('at');
          // alert(cat_id);

          category_id.push(cat_id);
            var brand_id = [];
            $.each($("input[name='brand_id[]']:checked"), function(){            
                brand_id.push($(this).val());
            });

            var colour_id = [];
            $.each($("input[name='colour_id[]']:checked"), function(){            
                colour_id.push($(this).val());
            });
            $('#products').empty();
             $.ajax({
               headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
               url: "{{url('productdata')}}",
               type: 'POST',
               data: {category_id:category_id,colour_id:colour_id,brand_id:brand_id,sortBy:sortBy,price:price},
               success: function(response){

                  var htmldata = [];
                 $.each(response, function(k, v) {
                  if (v.is_fav == 1) {
                        var svg = '<a href="javascript::void(0)" onclick="wishlist('+v.id+')"><svg width="20px" height="18px" viewBox="0 0 20 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="Home" transform="translate(-666.000000, -1039.000000)" fill="#E91414" fill-rule="nonzero"><g id="Group-23" transform="translate(441.000000, 1021.000000)"> <g id="Group-5" transform="translate(18.000000, 18.000000)"><path d="M212.17418,0 C208.967635,0 207,2.8041035 207,5.10431851 C207,10.0777697 212.652879,14.6940415 216.642857,17.6326531 C220.632934,14.6938448 226.285714,10.0772777 226.285714,5.10431851 C226.285714,2.80430029 224.317981,0 221.111534,0 C219.320816,0 217.790849,1.42773324 216.642956,2.78412901 C215.495062,1.42773324 213.965095,0 212.174377,0 L212.17418,0 Z" id="Path-Copy"></path></g></g></g></g></svg><a>';
                     }else{
                         var svg = '<a href="javascript::void(0)" onclick="wishlist('+v.id+')"><svg width="20px" height="18px" viewBox="0 0 20 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><title>Path</title><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="Home" transform="translate(-374.000000, -1039.000000)" fill="#CACACA" fill-rule="nonzero"><path d="M379.17418,1039 C375.967635,1039 374,1041.8041 374,1044.10432 C374,1049.07777 379.652879,1053.69404 383.642857,1056.63265 C387.632934,1053.69384 393.285714,1049.07728 393.285714,1044.10432 C393.285714,1041.8043 391.317981,1039 388.111534,1039 C386.320816,1039 384.790849,1040.42773 383.642956,1041.78413 C382.495062,1040.42773 380.965095,1039 379.174377,1039 L379.17418,1039 Z" id="Path"></path></g></g></svg></a>'; 
                     }
                  var image = v.image;
                  var n = image.split('|');
                      newdata = '<a href="{{url('user/products-details')}}/'+v.id+'"><div class="product outer-layer-prod"><div class="prod-img"><img src="{{ asset('upload/images/') }}/'+n[0]+'" height="160" width="160" alt="product1"/><div class="d-flex prod-feature"><div class="offer">-2%</div>'+svg+'</div></div><div class="prod-details"><div class="prod-info"><strong>'+v.name+'</strong><div class="d-flex justify-content-center align-items-center"><strike>$'+v.price+'</strike><b>'+v.price+'</b></div></div><a class="add-cart" href="{{url('/user/addcartlist?product_id=')}}'+v.id+'&product_quantity=1">Add to cart <img src="{{ asset('frontend/images/next.svg') }}" alt=""/></a></div><div class="view "><div class="see bg"><img src="{{ asset('frontend/images/eye.svg') }}" alt=""/></div><div class="star bg"><img src="{{ asset('frontend/images/star.svg') }}" alt=""/></div><div class="prod-search bg"><img src="{{ asset('frontend/images/search_prod.svg') }}" alt=""/></div></div></div></a>';

                      htmldata.push(newdata);
                    
                  });
                  $("#products").append(htmldata);
              }
          });
      }); 

      var category_id = $.QueryString("category_id");
      category_id = [category_id];
      $('#products').empty();
         $.ajax({
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           url: "{{url('productdata')}}",
           type: 'POST',
           data: {category_id:category_id},
           success: function(response){
              var htmldata = [];
             $.each(response, function(k, v) {
              if (v.is_fav == 1) {
                        var svg = '<a href="javascript::void(0)" onclick="wishlist('+v.id+')"><svg width="20px" height="18px" viewBox="0 0 20 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="Home" transform="translate(-666.000000, -1039.000000)" fill="#E91414" fill-rule="nonzero"><g id="Group-23" transform="translate(441.000000, 1021.000000)"> <g id="Group-5" transform="translate(18.000000, 18.000000)"><path d="M212.17418,0 C208.967635,0 207,2.8041035 207,5.10431851 C207,10.0777697 212.652879,14.6940415 216.642857,17.6326531 C220.632934,14.6938448 226.285714,10.0772777 226.285714,5.10431851 C226.285714,2.80430029 224.317981,0 221.111534,0 C219.320816,0 217.790849,1.42773324 216.642956,2.78412901 C215.495062,1.42773324 213.965095,0 212.174377,0 L212.17418,0 Z" id="Path-Copy"></path></g></g></g></g></svg></a>';
                     }else{
                         var svg = '<a href="javascript::void(0)" onclick="wishlist('+v.id+')"><svg width="20px" height="18px" viewBox="0 0 20 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><title>Path</title><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="Home" transform="translate(-374.000000, -1039.000000)" fill="#CACACA" fill-rule="nonzero"><path d="M379.17418,1039 C375.967635,1039 374,1041.8041 374,1044.10432 C374,1049.07777 379.652879,1053.69404 383.642857,1056.63265 C387.632934,1053.69384 393.285714,1049.07728 393.285714,1044.10432 C393.285714,1041.8043 391.317981,1039 388.111534,1039 C386.320816,1039 384.790849,1040.42773 383.642956,1041.78413 C382.495062,1040.42773 380.965095,1039 379.174377,1039 L379.17418,1039 Z" id="Path"></path></g></g></svg></a>'; 
                     }
              var image = v.image;
              var n = image.split('|');
                  newdata = '<a href="{{url('user/products-details')}}/'+v.id+'"><div class="product outer-layer-prod"><div class="prod-img"><img src="{{ asset('upload/images/') }}/'+n[0]+'" height="160" width="160" alt="product1"/><div class="d-flex prod-feature"><div class="offer">-2%</div>'+svg+'</div></div><div class="prod-details"><div class="prod-info"><strong>'+v.name+'</strong><div class="d-flex justify-content-center align-items-center"><strike>$'+v.price+'</strike><b>'+v.price+'</b></div></div><a class="add-cart" href="{{url('/user/addcartlist?product_id=')}}'+v.id+'&product_quantity=1">Add to cart <img src="{{ asset('frontend/images/next.svg') }}" alt=""/></a></div><div class="view "><div class="see bg"><img src="{{ asset('frontend/images/eye.svg') }}" alt=""/></div><div class="star bg"><img src="{{ asset('frontend/images/star.svg') }}" alt=""/></div><div class="prod-search bg"><img src="{{ asset('frontend/images/search_prod.svg') }}" alt=""/></div></div></div></a>';

                  htmldata.push(newdata);
                
              });
              $("#products").append(htmldata);
          }
       }); 

     }); 

      function showproduct(id="",cat_id) {
            category_id = [id];
            var elems = document.querySelector(".active");
            if(elems !==null){
             elems.classList.remove("active");
            }
            var d = document.getElementById('catId'+cat_id);
            d.className += " active";
            $('#products').empty();
             $.ajax({
               headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
               url: "{{url('productdata')}}",
               type: 'POST',
               data: {category_id:category_id},
               success: function(response){

                  var htmldata = [];
                 $.each(response, function(k, v) {
                  var image = v.image;
                  var n = image.split('|');
                     if (v.is_fav == 1) {
                        var svg = '<a href="javascript::void(0)" onclick="wishlist('+v.id+')"><svg width="20px" height="18px" viewBox="0 0 20 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="Home" transform="translate(-666.000000, -1039.000000)" fill="#E91414" fill-rule="nonzero"><g id="Group-23" transform="translate(441.000000, 1021.000000)"> <g id="Group-5" transform="translate(18.000000, 18.000000)"><path d="M212.17418,0 C208.967635,0 207,2.8041035 207,5.10431851 C207,10.0777697 212.652879,14.6940415 216.642857,17.6326531 C220.632934,14.6938448 226.285714,10.0772777 226.285714,5.10431851 C226.285714,2.80430029 224.317981,0 221.111534,0 C219.320816,0 217.790849,1.42773324 216.642956,2.78412901 C215.495062,1.42773324 213.965095,0 212.174377,0 L212.17418,0 Z" id="Path-Copy"></path></g></g></g></g></svg></a>';
                     }else{
                         var svg = '<a href="javascript::void(0)" onclick="wishlist('+v.id+')"><svg width="20px" height="18px" viewBox="0 0 20 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><title>Path</title><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="Home" transform="translate(-374.000000, -1039.000000)" fill="#CACACA" fill-rule="nonzero"><path d="M379.17418,1039 C375.967635,1039 374,1041.8041 374,1044.10432 C374,1049.07777 379.652879,1053.69404 383.642857,1056.63265 C387.632934,1053.69384 393.285714,1049.07728 393.285714,1044.10432 C393.285714,1041.8043 391.317981,1039 388.111534,1039 C386.320816,1039 384.790849,1040.42773 383.642956,1041.78413 C382.495062,1040.42773 380.965095,1039 379.174377,1039 L379.17418,1039 Z" id="Path"></path></g></g></svg></a>'; 
                     }



                      newdata = '<a href="{{url('user/products-details')}}/'+v.id+'"><div class="product outer-layer-prod"><div class="prod-img"><img src="{{ asset('upload/images/') }}/'+n[0]+'" height="160" width="160" alt="product1"/><div class="d-flex prod-feature"><div class="offer">-2%</div>'+svg+'</div></div><div class="prod-details"><div class="prod-info"><strong>'+v.name+'</strong><div class="d-flex justify-content-center align-items-center"><strike>$'+v.price+'</strike><b>'+v.price+'</b></div></div><a class="add-cart" href="{{url('/user/addcartlist?product_id=')}}'+v.id+'&product_quantity=1">Add to cart <img src="{{ asset('frontend/images/next.svg') }}" alt=""/></a></div><div class="view "><div class="see bg"><img src="{{ asset('frontend/images/eye.svg') }}" alt=""/></div><div class="star bg"><img src="{{ asset('frontend/images/star.svg') }}" alt=""/></div><div class="prod-search bg"><img src="{{ asset('frontend/images/search_prod.svg') }}" alt=""/></div></div></div></a>';

                      htmldata.push(newdata);
                    
                  });
                  $("#products").append(htmldata);
              }
          });
      }


      function wishlist(id){
         $.ajax({
               headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
               url: "{{url('addwishlist')}}",
               type: 'POST',
               data: {product_id:id},
               success: function(response){
                   $('#is_fav').html(response.favcount);
                   location.reload()
              }
           });   
      }

    
        const email = document.querySelector('input[name=email]');
        const button = document.querySelector('#btn');
        const text =  document.querySelector('#message');

        const validateEmail= (email) => {
            var regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return regex.test(String(email).toLowerCase());
        }

        button.addEventListener('click',()=>{
            if(validateEmail(email.value)){
              text.innerText="Valid email";
            }else{
              text.innerText="Invalid email";
            }
        })

      

      </script>
    </body>
</html>