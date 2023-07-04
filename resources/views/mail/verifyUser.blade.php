<!DOCTYPE html>
<html>
  <head>
    <title>Welcome Email</title>
  <body>
    <style>
    @media only screen and (max-width: 600px) {
    .inner-body {
    width: 100% !important;
    }
    
    .footer {
    width: 100% !important;
    }
    }
    
    @media only screen and (max-width: 500px) {
    .button {
    width: 100% !important;
    }
    }
    </style>
    
    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
    <td align="center">
    <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    {{ $header ?? '' }}
    
    <!-- Email Body -->
    <tr>
    <td class="body" width="100%" cellpadding="0" cellspacing="0">
    <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
    <!-- Body content -->
    <tr>
    <td class="content-cell">
      <h2>Welcome {{$user['email']}}</h2>
    <br/>
    Your registered email-id is {{$user['email']}}
    <br/>
    Your password is {{$user['password']}}
    <br/>

    </td>
    </tr>
    </table>
    </td>
    </tr>
    
    {{ $footer ?? '' }}
    </table>
    </td>
    </tr>
    </table>
    </body>
</html>