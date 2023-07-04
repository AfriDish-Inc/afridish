<html xmlns="http://www.w3.org/1999/xhtml"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $mailSubject }}</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet"> </head>
  
    <body style="background-color:#eff2f7;
    font-family: 'Roboto', sans-serif;padding:0;margin:0;font-weight: normal;color: #2e2e2e;line-height: 1.6em;vertical-align:middle;padding:20px;">
    <div style="overflow:auto;background: #fff;padding:30px;width:600px;margin: 0 auto;">
  
      <table style="color: #6b6b6b;width:100%;margin:0px auto;background-color:#fff;border-collapse: collapse;box-sizing: border-box;padding:30px;border-radius:5px;text-align:left;">
        <thead>
          <tr style="display:block">
            <th style="font-weight: normal;text-align:center;display:block">
              <img style="max-width:100%;margin:10px 0;" src="{{asset('images/newLogo.png')}}">
              <p style="height:1px;width:100%;background:#c7c7c7;"></p>
            </th>
          </tr>
          <tr style="display:block">
            <td style="font-weight: normal;display:block">
              <div style="margin:20px 0 10px 0;position: relative;"><img src="{{asset('images/banner.png')}}" style="max-width:100%">
                <p style="position: absolute;top: 17%;left: 26%;color: #fff;font-size: 2.4rem;"><b>AfriDish <span style="color: #ffba00;"></span><b></b></b></p><b><b>
              </b></b></div><b><b>
              <p style="margin:10px 0;text-align:left;font-size:26px">Hi <span style="font-weight:bold;">{{ $userName }}!</span></p>
              <p style="line-height: 27px;margin:10px 0 20px;width:100%;float: left;font-weight: normal;text-align:center;">{{ $mailContent }}</p>
            </b></b></td></tr>
          </thead>
  
          <tbody>
  
  
            <tr>
              <td colspan="6">
                <p style="line-height: 22px;float: left;margin:30px 0 10px;font-weight: normal;text-align:left;">Kind Regards,<br>The AfriDish Team
                </p>
              </td>
            </tr>
            <tr>
              <td colspan="6  ">
                <p style="height:1px;width:100%;background:#c7c7c7;"></p>
                <p style="line-height: 12px;margin:15px 0 0; font-weight: normal;text-align:center;">
                    <a href="#"><img style="max-width:100%;" src="{{asset('images/insta.png')}}"></a>
                    <a href="#"><img style="max-width:100%;" src="{{asset('images/fb.png')}}"></a>
                    <a href="#"><img style="max-width:100%;" src="{{asset('images/tw.png')}}"></a>
                </p>
                <p style="line-height: 19px;margin:10px 0; font-weight: normal;font-size:12px;text-align:center">
                  <a style="margin:10px 0;border-radius:5px;display:inline;color:#afafaf;text-align:center;text-decoration:none;" href="{{URL::to('/')}}">Visit AfriDish  site</a>&nbsp;&nbsp;
                </p>
              </td>
            </tr>
          </tbody></table>
    </div>
  
  
  </body></html>