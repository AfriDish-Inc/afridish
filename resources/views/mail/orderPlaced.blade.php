<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Order Confirmation</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet"> </head>

  <body style="background-color:#eff2f7;
  font-family: 'Roboto', sans-serif;padding:0;margin:0;font-weight: normal;color: #2e2e2e;line-height: 1.6em;vertical-align:middle;padding:20px;">
  <div style="overflow:auto;background: #fff;padding:30px;max-width:600px;margin: 0 auto;width:100%">

    <table style="color: #6b6b6b;width:100%;margin:0px auto;background-color:#fff;border-collapse: collapse;box-sizing: border-box;padding:30px;border-radius:5px;text-align:left;">

      <thead>
        <tr style="display:block">
          <th colspan="1"style="font-weight: normal;text-align:center;display:block">
            <img style="max-width:100%;margin:10px 0;"	src="{{asset('images/newLogo.png')}}";/>
            <p style="height:1px;width:100%;background:#c7c7c7;"></p>
          </th>
        </tr>
      </thead>

      <tbody style="font-size:15px;">
        <tr style="display:block">
          <td colspan="1"	style="font-weight: normal;display:block">
            <table style="width:100%">
              <thead>
                <tr>
                  <th>Order Type</th>
                  <th style="text-align:left;float:right;min-width:155px;">Order date,Time</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>{{ $orderType }}</td>
                  <td style="text-align:left;float:right;min-width:155px;">{{ $orderDate }}, {{ $orderTime }}</td>
                </tr>
              </tbody>
            </table>
            <p style="margin:10px 0;text-align:center;font-size:26px">Hi <span style="font-weight:bold;">{{ $userName }}!</span></p>
            <p style="line-height: 27px;margin:10px 0;width:100%;float:left;">

            </p>
            <p style="text-align:center"><img style="max-width:100px" src="{{asset('images/checked.png')}}"></p>
            <p style="line-height: 27px;margin:10px 0 20px;width:100%;float: left;font-weight: normal;text-align:left;">Your <b>Order ID: {{ $orderId }}</b> has been placed successfully, Kindly check the below mentioned Order Summary</p>
          </td>
          </tr>

          <tr>
            <td>
              <table style="width:100%;border:1px solid #c3c3c3;box-sizing: border-box;border-collapse: collapse;padding:10px;">
                <thead>
                  <tr>
                    <td style="background: #a7a7a7;color: #fff;;Padding: 10px 5px;text-align:center;">Item Name</td>
                    <td style="background: #a7a7a7;color: #fff;;Padding: 10px 5px;text-align:center;">Category</td>
                    <td style="background: #a7a7a7;color: #fff;;Padding: 10px 5px;text-align:center;">Unit</td>
                    <td style="background: #a7a7a7;color: #fff;;Padding: 10px 5px;text-align:center;">Unit Price</td>
                    <td style="background: #a7a7a7;color: #fff;;Padding: 10px 5px;text-align:center;">Quantity</td>
                    <td style="background: #a7a7a7;color: #fff;;Padding: 10px 5px;text-align:center;">Discount</td>
                    <td style="background: #a7a7a7;color: #fff;;Padding: 10px 5px;text-align:center;">Sub Total</td>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($productsData as $productData)
                    <tr>
                      @php $productImage = $productData['productImage'] @endphp
                      <td style=";Padding: 10px 5px;text-align:center;"><img src="{{asset("upload/images/$productImage")}}" style="max-width:35px;border:1px solid #c3c3c3;"><br> {{ $productData['productName'] }} </td>
                      <td style=";Padding: 10px 5px;text-align:center;">{{ $productData['productCategory'] }}</td>
                      <td style=";min-width:55px;Padding: 10px 5px;text-align:center;">{{ $productData['productQuantity'] }} {{ $productData['productQuantityUnit'] }}</td>
                      <td style=";Padding: 10px 5px;text-align:center;">{{ $productData['singleProductPrice'] }}</td>
                      <td style=";Padding: 10px 5px;text-align:center;"> {{ $productData['productUnits'] }} </td>
                      <td style=";Padding: 10px 5px;text-align:center;">CAD 100</td>
                      <td style=";min-width:65px;Padding:10px 5px;text-align:center;">CAD {{ $productData['productTotalPrice'] }}</td>
                    </tr>
                  @endforeach

                  <tr>
                    <th style=";Padding:5px;;text-align:center;">Total Item Price:</th>
                    <td style=";Padding:5px" colspan="6">CAD 1500</td>
                  </tr>
                  <tr>
                    <th style=";Padding:5px;text-align:center;">Discount:</th>
                    <td style=";Padding:5px" colspan="6">Promo (DISCOUNT 10 %)
                      CAD 150</td>
                    </tr>
                    <tr>
                      <th style=";Padding:5px;text-align:center;">VAT {{$taxPercent}}%:</th>
                      <td style=";Padding:5px" colspan="6">CAD {{ $taxAmount }}</td>
                    </tr>
                    <tr>
                      <th style=";Padding:5px;text-align:center;">Shipping Charges:</th>
                      <td style=";Padding:5px" colspan="6">CAD {{ $shippingCost }}</td>
                    </tr>
                    <tr>
                      <th style=";Padding:5px;text-align:center;">Grand Total:</th>
                      <td style=";Padding:5px" colspan="6">CAD {{ $orderAmount }}</td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>

            <tr>
              <td colspan="6">
                <span style="margin-top:2rem;width:50%;display:flex;align-items:center;float:left">
                  <span><img src="{{asset('images/store.png')}}" style="max-width:87px;float:left;"></span>
                  <span style="float:left;line-height:22px;margin-left:1rem;">{{ $storeName }}<br>{{ $storeAddress }}</span>
                </span>

                @if($orderType == 'Delivery')
                  <span style="margin-top:2rem;display:flex;float:right;width:50%">                  
                    <span style="float:right;">
                      <img src="{{asset('images/customer.png')}}" style="max-width:87px;float:left;">
                    </span>
                    <span style="float:right;line-height:22px;">
                      {{ $orderPersonName }}<br>{{ $orderDeliveryAddress }}
                    </span>
                  </span>
                @endif
              </td>
              </tr>

              <tr>
                <td colspan="6">
                <p style="line-height: 22px;float: left;margin:30px 0 10px;font-weight: normal;text-align:left;">Kind Regards,<br>The AfriDish Team
                </p>
              </td>
              </tr>

              <tr>
                <td>
                  <p style="height:1px;width:100%;background:#c7c7c7;"></p>
                  <p style="line-height: 12px;margin:15px 0 0; font-weight: normal;text-align:center;">
                    <a href="#"><img style="max-width:100%;" src="{{asset('images/insta.png')}}"></a>
                    <a href="#"><img style="max-width:100%;" src="{{asset('images/fb.png')}}"></a>
                    <a href="#"><img style="max-width:100%;" src="{{asset('images/tw.png')}}"></a>
                  </p>
                </td>
              </tr>
            </tbody>
          </table>
        </div>


      </body>
      </html>
