<!DOCTYPE html>
<html lang="en">
<head>
<title>{{ collect(request()->segments())->last() }}</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
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
<link rel="stylesheet" href="https://cdn.tutorialjinni.com/intl-tel-input/17.0.8/css/intlTelInput.css"/>
<script src="https://cdn.tutorialjinni.com/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyD7dkCf41VM0SG9DsBWhfa-FHN2OwJu35A&callback=initMap"></script>

</head>
<body>
    @yield("content")
    <script type="text/javascript">
      var input = document.querySelector("#phone");
        window.intlTelInput(input, {
          separateDialCode: true,
          initialCountry: 'CA',
          allowExtensions: true,
           formatOnDisplay: true,
           autoFormat: true,
           autoHideDialCode: true,
           autoPlaceholder: true,
        });
    </script>

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
    $(document).ready(function(){
       $("#vendor_type").on('change', function() {
          categories = $('#vendor_type').find(":selected").text();
              if(categories == "Dispensaries"){
                  $('.address').show();
              }else{
                 $('.address').hide(); 
              }
             
        });
    });
  </script>
</body>
</html>
