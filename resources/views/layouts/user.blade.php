<!DOCTYPE html>
<html lang="en">
   <head>
      <title>{{ collect(request()->segments())->last() }}</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
      <link rel="icon" type="img/png" sizes="32x32" href="{{asset('website/img/favicon.png')}}">

      <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>
      <link rel="stylesheet" href="{{ asset('website/css/style.css') }}">
      <link rel="stylesheet" href="{{ asset('website/css/owl.css') }}">
      <link rel="stylesheet" href="{{ asset('website/css/owl.carousel.min.css') }}">
      <link rel="stylesheet" href="{{ asset('website/css/owl.theme.default.min.css') }}">
      <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css'>
      <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css'>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
      <!-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyCnru_6zFd4mgPokHRIkBcbEGzYijxop8A&libraries=places&callback=initMap"></script> -->
      <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyD7dkCf41VM0SG9DsBWhfa-FHN2OwJu35A&callback=initMap"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>

   </head>
   <body>

      <!-- Header -->
      @include('Website.common.header')
      <!-- Header end -->
      <!-- Content -->
      @yield('content')
      <!-- Content end-->   
      <!-- Footer -->
      @include('Website.common.footer')
      <!-- Footer end -->
      <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
          <input type="hidden" name="user_type" value="A">
      </form>
      
      <script src='https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js'></script>
      <script src="{{ asset('website/js/popper.js')}}"></script>
      <script src="{{ asset('website/js/bootstrap.min.js')}}"></script>
      <script src="{{ asset('website/js/owl.carousel.min.js')}}"></script>
      <script src="{{ asset('website/js/main.js')}}"></script>
      <script src="{{ asset('website/js/validate.js') }}"></script>

     
     <script type="text/javascript">
        function initialize() {
            var input = document.getElementById('pac-input');
            var autocomplete = new google.maps.places.Autocomplete(input);
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
                $('.lat').val(place.geometry.location.lat());  
                $('.lon').val(place.geometry.location.lng()); 
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize); 
    </script>
      <script>


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
                   //$("#ajax_meesasge").text(response.message);
                  toastr.options =
                    {
                      "closeButton" : true,
                      "progressBar" : true
                    }
                  if(response.status){
                      toastr.success(response.message);//
                    }else{
                      toastr.error(response.message);//
                    }

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
               toastr.options =
                {
                  "closeButton" : true,
                  "progressBar" : true
                }
               toastr.error("Min 1 product should be added !");
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
                     toastr.options =
                    {
                      "closeButton" : true,
                      "progressBar" : true
                    }
                  if(response.status){
                      toastr.success(response.message);//
                    }else{
                      toastr.error(response.message);//
                    }
                    window.setTimeout(function(){location.reload()},1000)
                  }
              });
              if (!isNaN(currentVal) && currentVal > 0) {
                 $(this).siblings(".qty").val(parseInt(currentVal) - 1);
              } else {
                  $(this).siblings(".qty").val(0);
              }
              }else{
                toastr.options =
                {
                  "closeButton" : true,
                  "progressBar" : true
                }
                toastr.error("Min 1 product should be added !");
              // $("#ajax_meesasge").text('Min 1 product should be add !');

             }
            });
          });

        
         $(document).ready(function(){
         $('.my-slider').slick({
           slidesToShow: 4,
           slidesToScroll: 1,
           arrows: true,
           dots: true,
           speed: 300,
           infinite: true,
           autoplaySpeed: 3000,
           autoplay: true,
           responsive: [
         {
           breakpoint: 991,
           settings: {
             slidesToShow: 3,
           }
         },
         {
           breakpoint: 767,
           settings: {
             slidesToShow: 2,
           }
         }
         ]
         });
         });
         $(document).ready(function(){
         $('.my-sliderp').slick({
           slidesToShow: 4,
           slidesToScroll: 1,
           arrows: true,
           dots: true,
           speed: 300,
           infinite: true,
           autoplaySpeed: 3000,
           autoplay: false,
           responsive: [
         {
           breakpoint: 991,
           settings: {
             slidesToShow: 3,
           }
         },
         {
           breakpoint: 767,
           settings: {
             slidesToShow: 2,
           }
         }
         ]
         });
         });
           $(document).ready(function(){
         $('.my-slideres').slick({
           slidesToShow: 2,
           slidesToScroll: 1,
           arrows: true,
           dots: true,
           speed: 1000,
           infinite: true,
           autoplaySpeed: 3000,
           autoplay: true,
           responsive: [
         {
           breakpoint: 991,
           settings: {
             slidesToShow: 2,
           }
         },
         {
           breakpoint: 767,
           settings: {
             slidesToShow: 1,
           }
         }
         ]
         });
         });
      </script>
      <script>
       $('.slider-for').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  asNavFor: '.slider-nav'
});
$('.slider-nav').slick({
  slidesToShow: 4,
  slidesToScroll: 1,
  asNavFor: '.slider-for',
  dots: true,
  centerMode: true,
  focusOnSelect: true
});
      $(document).ready(function(){
      $('.my-slider').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        arrows: true,
        dots: true,
        speed: 300,
        infinite: true,
        autoplaySpeed: 3000,
        autoplay: true,
        responsive: [
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 3,
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2,
        }
      }
    ]
      });
    });
      $(document).ready(function(){
      $('.my-sliderp').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        arrows: true,
        dots: true,
        speed: 300,
        infinite: true,
        autoplaySpeed: 3000,
        autoplay: false,
        responsive: [
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 3,
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2,
        }
      }
    ]
      });
    });
        $(document).ready(function(){
      $('.my-slideres').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        arrows: true,
        dots: true,
        speed: 300,
        infinite: true,
        autoplaySpeed: 3000,
        autoplay: false,
        responsive: [
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 2,
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 1,
        }
      }
    ]
      });
    });
    </script>
    
    <script>
$(document).ready(function(){
  $(".nav-tabs a").click(function(){
    $(this).tab('show');
  });
});
</script> 
<script type="text/javascript">
  var num;

$('.button-count:first-child').click(function(){
  num = parseInt($('input:text').val());
  if (num > 1) {
    $('input:text').val(num - 1);
  }
  if (num == 2) {
    $('.button-count:first-child').prop('disabled', true);
  }
  if (num == 10) {
    $('.button-count:last-child').prop('disabled', false);
  }
});

$('.button-count:last-child').click(function(){
  num = parseInt($('input:text').val());
  if (num < 10) {
    $('input:text').val(num + 1);
  }
  if (num > 0) {
    $('.button-count:first-child').prop('disabled', false);
  }
  if (num == 9) {
    $('.button-count:last-child').prop('disabled', true);
  }
});


</script>

<script>
/*document.addEventListener("DOMContentLoaded", function() {
	var button = document.getElementsByClassName("favorite")[0];
	button.addEventListener("click", function(e) {
		button.classList.toggle("liked");
	});
});*/
</script>
<script>
		$(document).ready(function(){
			$('.navbar-toggler').click(function(){
				$('.navbar-collapse').toggle(0,function(){
					console.log("");
				});
			});
		});
	</script>
<script>
		$(document).ready(function(){
			$('.signout').click(function(){
				$('.dropdown-menu').toggle(100,function(){
					console.log("");
				});
			});
		});

    $(document).ready(function(){
          $(".type_check").on('click', function() {
          
            var price =   $("input[name='price']").val();
             $('.range-value').html(price);
            var sortBy = $('select[name="sortBy"]').find(":selected").val();
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

            //$('#products').empty();
             $.ajax({
               headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
               url: "{{url('productdata')}}",
               type: 'POST',
               data: {category_id:category_id,brand_id:brand_id,sortBy:sortBy,price:price},
               success: function(response){
                $('#products').empty();
                  var htmldata = [];
                 $.each(response, function(k, v) {
                   if (v.is_fav == 1) {
                        var svg = '<a href="javascript::void(0)" onclick="wishlist('+v.id+')" ><img src="{{ asset('website/img/favorite.svg')}}"></a>';
                     }else{
                         
                         var svg = '<a href="javascript::void(0)" onclick="wishlist('+v.id+')" ><img src="{{ asset('website/img/wish.svg')}}"></a>';
                     }
                  var image = v.image;
                  var n = image.split('|');
                      newdata = '<a href="{{url('product-details?id=')}}'+v.id+'"><div class="col-md-3"><div class="main-frame"><div class="product-thumbnail"><img src="{{ asset('upload/images/')}}/'+n[0]+'"><div class="wish-btn"><div class="tag-status"><span>NEW</span>'+svg+'</div></div><div class="atc"><a href="javascript::void(0)" onclick="addToCart('+v.id+',1)">Add To Cart</a></div></div><div class="product-info"><div class="star-miles"><div class="rating"><input type="radio" name="rating'+k+'"  value="5" id="p5'+k+'" ><label for="p5'+k+'">☆</label><input type="radio" name="rating'+k+'" value="4" id="p4'+k+'" ><label for="p4'+k+'">☆</label><input type="radio" name="rating'+k+'" value="3" id="p3'+k+'" ><label for="p3'+k+'">☆</label><input type="radio" name="rating'+k+'" value="2" id="p2'+k+'" ><label for="p2'+k+'">☆</label><input type="radio" name="rating'+k+'" value="1" id="p1'+k+'" ><label for="p1'+k+'">☆</label></div></div><h4 class="product-title">'+v.name+'</h4><p class="price">$'+v.price+'</p></div></div></div></a>';

                      htmldata.push(newdata);
                    
                  });
                 //console.log(htmldata);

                  $("#products").append(htmldata);
              }
          });
      }); 

          



      /*var category_id = $.QueryString("category_id");
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
                        var svg = '<a href="{{url('/add-wish-list?id=')}}'+v.id+'"><img src="{{ asset('website/img/favorite.svg')}}"></a>';
                     }else{
                         
                         var svg = '<a href="{{url('/add-wish-list?id=')}}'+v.id+'"><img src="{{ asset('website/img/wish.svg')}}"></a>';
                     }
              var image = v.image;
              var n = image.split('|');
                  newdata = '<a href="{{url('product-details?id=')}}'+v.id+'"><div class="col-md-3"><div class="main-frame"><div class="product-thumbnail"><img src="{{ asset('upload/images/')}}/'+n[0]+'"><div class="wish-btn"><div class="tag-status"><span>NEW</span>'+svg+'</div></div><div class="atc"><a href="{{url('/addcartlist?product_id=')}}/'+v.id+'&product_quantity=1">Add To Cart</a></div></div><div class="product-info"><div class="star-miles"><div class="rating"><input type="radio" name="rating" value="5" id="5" ><label for="5">☆</label><input type="radio" name="rating" value="4" id="4" ><label for="4">☆</label><input type="radio" name="rating" value="3" id="3" ><label for="3">☆</label><input type="radio" name="rating" value="2" id="2" ><label for="2">☆</label><input type="radio" name="rating" value="1" id="1" ><label for="1">☆</label></div></div><h4 class="product-title">'+v.name+'</h4><p class="price">$'+v.price+'</p></div></div></div></a>';

                  htmldata.push(newdata);
                
              });
              $("#products").append(htmldata);
          }
       }); */



     }); 

      function wishlist(id){
         $.ajax({
               headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
               url: "{{url('addwishlist')}}",
               type: 'POST',
               data: {product_id:id},
               success: function(response){
                  toastr.options =
                    {
                      "closeButton" : true,
                      "progressBar" : true
                    }
                  if(response.status == 2){
                    window.location.href = "{{url('login')}}";
                  }else if(response.status){
                    $(".is_fav"+id).attr("src","{{ asset('website/img/favorite.svg')}}");
                    $("#wish_count").text(response.favcount);
                    toastr.success(response.message);
                  }else{
                    $(".is_fav"+id).attr("src","{{ asset('website/img/wish.svg')}}");
                    $("#wish_count").text(response.favcount);
                    toastr.info(response.message);
                  }
              }
           });   
      }

      function addToCart(id,qty){
         $.ajax({
               headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
               url: "{{url('addtocart')}}",
               type: 'POST',
               data: {product_id:id,product_quantity:qty},
               success: function(response){
                  toastr.options =
                    {
                      "closeButton" : true,
                      "progressBar" : true
                    }
                  if(response.status == 2){
                    window.location.href = "{{url('login')}}";
                  }else if(response.status){
                    $("#cart_count").text(response.favcount);
                    toastr.success(response.message);
                  }else{
                    $("#cart_count").text(response.favcount);
                    toastr.info(response.message);
                  }
              }
           });   
      }


      function removeCart(id){
         $.ajax({
               headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
               url: "{{url('removecart')}}",
               type: 'POST',
               data: {cart_id:id},
               success: function(response){
                  toastr.options =
                    {
                      "closeButton" : true,
                      "progressBar" : true
                    }
                  if(response.status){
                    $("#cart_count").text(response.favcount);
                    toastr.success(response.message);
                  }
              }
           });   
      }


      
	</script>
  <script>
       $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
      const rangeInput = document.querySelectorAll(".range-input input"),
priceInput = document.querySelectorAll(".price-input input"),
range = document.querySelector(".slider .progress");
let priceGap = 1000;

priceInput.forEach(input =>{
    input.addEventListener("input", e =>{
        let minPrice = parseInt(priceInput[0].value),
        maxPrice = parseInt(priceInput[1].value);
        
        if((maxPrice - minPrice >= priceGap) && maxPrice <= rangeInput[1].max){
            if(e.target.className === "input-min"){
                rangeInput[0].value = minPrice;
                range.style.left = ((minPrice / rangeInput[0].max) * 100) + "%";
            }else{
                rangeInput[1].value = maxPrice;
                range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
            }
        }
    });
});

rangeInput.forEach(input =>{
    input.addEventListener("input", e =>{
        let minVal = parseInt(rangeInput[0].value),
        maxVal = parseInt(rangeInput[1].value);

        if((maxVal - minVal) < priceGap){
            if(e.target.className === "range-min"){
                rangeInput[0].value = maxVal - priceGap
            }else{
                rangeInput[1].value = minVal + priceGap;
            }
        }else{
            priceInput[0].value = minVal;
            priceInput[1].value = maxVal;
            range.style.left = ((minVal / rangeInput[0].max) * 100) + "%";
            range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
        }
    });
});
 $('.checkout_form').click(function(e){
              e.preventDefault();
              var stripe_id= $('#stripe_id').val();
              var payment_method=$('input[name="payment_method"]:checked').val();

              
  
       if(stripe_id=='' && payment_method=='stripe')
       {
        $('#paymentCardModal').modal('show');
       }
       else{
       $("#cart_form").submit();
       }

            });




 $("#card_form").validate({
   
    rules:{
        'name': {
                'required': true
            },
             
        'card_number':{
            "required":true,
            "minlength":16,
             "maxlength":16,
           
           
        },
          "exp_date": {
            "required":true,
           
        },
        "cvc": {
             "required":true,
            "minlength": 3,
              "maxlength":4,
           
        }
    },

      messages: {
  
     'name': {
      required: "Name field is required.",
    },
     'card_number': {
      required: "Card number field is required.",
    },
     'exp_date': {
      required: "Exp date field is required.",
    },
    'cvc': {
      required: "Cvc field is required.",
    },
},
    submitHandler:function(form){
        var name=$('#holder_name').val();
        
        var card_number=$('#cardnumber').val();
        var exp_month=$('#month').val();
        var exp_year=$('#year').val();
        var cvc =$('#securitycode').val();
          $.ajax({
                 type: 'POST',
                url: "{{ url('addUserCard') }}",
                    
                   
                    data:{
                        name:name,
                        card_number:card_number,
                        exp_month:exp_month,
                        exp_year:exp_year,
                        cvc:cvc
                    },
                    success: function(data) {
                        console.log(data);
                          if (data.hasOwnProperty('message')) {
                    swal.fire({
                        animation: true,
                        icon: 'success',
                        title: data.message,
                        closeOnClickOutside: false,
                        allowOutsideClick: false,
                        backdrop: `rgba(0,0,123,0.4) left top no-repeat`
                    }).then(function() {
                        window.location.reload();
                    });
                }
                 if (data.hasOwnProperty('inavlid')) {
                    swal.fire({
                        animation: true,
                        icon: 'error',
                        title: data.inavlid,
                        closeOnClickOutside: false,
                        allowOutsideClick: false,
                        backdrop: `rgba(0,0,123,0.4) left top no-repeat`
                    });
                }
                    }


                });

    }
   });
    </script>

   </body>
</html>