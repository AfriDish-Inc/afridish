
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>popup</title>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>


  <style type="text/css">
    body{
      font-family: 'Poppins', sans-serif;
    }
 .modal-body h3 {
    text-align: center;
    margin: 0;
    font-size: 25px;
    margin-top: 2rem;
}
.yes-no {
    display: flex;
    align-items: center;
    justify-content: space-around;
    width: 75%;
    margin: 2rem auto 0rem;
}
.modal-header {
    border: none;
}
.modal-body {
    padding-top: 0;
}
.yes:hover{
  opacity: 0.9;
}
button.no:hover {
    background: #d8d8d8;
}
.modal-header img {
    max-width: 70px;
    width: 100%;
    object-fit: contain;
}
    .yes-no {
    display: flex;
    align-items: center;
    justify-content: space-around;
    width: 66%;
    margin: 2rem auto 0rem;
}
.popup{
      position: fixed;
    top: 0;
    left: 0;
    z-index: 1050;
    width: 100%;
    height: 100%;
    overflow: hidden;
    outline: 0;
}
button.no {
    display: inline-block;
    background: #ffffff;
    color: #000000;
    padding: 8px 25px;
    width: 48%;
    text-align: center;
    transition: .2s all ease;
    text-decoration: none;
    border: 1.50832px solid #484848;
    border-radius: 37.7079px;
}
.yes-no .yes {
    background: #010B1B;
    border-radius: 35.1976px;
    color: #ffffff!important;
    padding: 0.5rem 1.5rem;
    transition: .2s all ease;
    border: none;
    width: 48%;
}
.modal-footer p {
    font-size: 12px;
    font-weight: 300;
}
.modal-footer {
    border: none;
    background: #f4f4f4;
    margin: 2rem auto 0;
    width: 100%;
    justify-content: center;
    border-bottom-right-radius: 15px;
    border-bottom-left-radius: 15px;
}
.modal-footer p a {
    color: #000;
    text-decoration: revert;
}
/*.modal{
  display: block!important;
  opacity: 1!important;
}*/
div#exampleModalCenter:before {
    z-index: -1;
    position: fixed;
    inset: 0px;
    background-color: rgb(0 0 0 / 20%);
    -webkit-tap-highlight-color: transparent;
    width: 100%;
    height: 100%;
    content: '';
}
.modal-content {
    border-radius: 15px;
    box-shadow: rgba(0, 0, 0, 0.14) 0px 5px 15px 0px;
    border: none;
}
.fade:not(.show) {
    opacity: 1;
}

@media only screen and (max-width: 767px) {
.yes-no {
    flex-direction: column;
    width: 70%;
}
.yes-no button {
    width: 100%!Important;
}
button.yes {
    margin-bottom: 10px;
}
.yes, .no {
    padding: 14px!important;
}
}
  </style>
</head>
<body>


<!-- Modal -->
<div class="popup fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <img src="https://puffie.iapplabz.co.in/website/img/logo.png">
      <!--   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body">
        <h3>Are you 19 and older?</h3>
        <div class="yes-no">
            <a class="btn btn-success" href="{{url('age-varify?age_verify=1')}}" class="yes">Yes</a>
            <a class="btn btn-danger" href="{{url('age-varify?age_verify=')}}" class="no">No</a>
        </div>
      </div>
       <div class="modal-footer">
          <p>By clicking Yes, you agree to the&nbsp;<a target="_blank" href="{{url('term-condition')}}">Terms</a>&nbsp;and&nbsp;<a target="_blank" href="{{url('privacy')}}">Privacy Policy</a>.</p></div>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function(){       
   $('#exampleModalCenter').modal('show');
    }); 
</script>

</body>
</html>