<?php

namespace App\Imports;

use App\Store;
use App\StoreDeliveryType;
use App\StoreAvailability;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Config;


class StoresImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $googleKey = Config::get('app.googleKey');
        $storeAddress =  trim(str_replace(' ', '%20',  $row['address']));
        $url = "https://maps.googleapis.com/maps/api/geocode/json?parameters&address=$storeAddress&key=$googleKey";
        $storeTypes = $row['types'];
        // $result = file_get_contents($url);
        // $arr = json_decode($result, true);
        
        $ch = curl_init();
        // IMPORTANT: the below line is a security risk, read https://paragonie.com/blog/2017/10/certainty-automated-cacert-pem-management-for-php-software
        // in most cases, you should set it to true
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);

        $arr = json_decode($result);
        if(!array_key_exists("error_message",$arr))
        {
            $store = new Store;
            $store->name = $row['name'];
            $store->address = $row['address'];
            $store->detail = $row['description'];
            $store->phone_number = $row['phone_no'];
            $store->lat = $arr->results[0]->geometry->location->lat;
            $store->lng = $arr->results[0]->geometry->location->lng;
            $store->std_code = "+".$row['std_code'];
            $store->save();

            $deliveryType = explode(',',$storeTypes);

            // Store Delivery Type
            foreach($deliveryType as $type)
            {
                $StoreDeliveryType = new StoreDeliveryType;
                $StoreDeliveryType->store_id = $store->id;
                $StoreDeliveryType->delivery_type = trim($type);
                $StoreDeliveryType->save();
            }

            $weekDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

            // Store Availibility
            foreach($weekDays as $day)
            {
                $StoreAvailability = new StoreAvailability;
                $StoreAvailability->store_id = $store->id;
                $StoreAvailability->day = $day;
                $StoreAvailability->start_time = date("H:i", strtotime('09:00'));
                $StoreAvailability->end_time = date("H:i", strtotime('18:00'));
                $StoreAvailability->save();
            }

            // Stores Product 
            $storeProducts = explode(',',$row['storeproducts']);
            foreach($storeProducts as $storeProduct)
            {
                $productIdUnit = explode('-',$storeProduct);
                
                    // Insert in product_store (pivot table)
                    $store->product()->attach($productIdUnit[0] , 
                                            ['product_units' => $productIdUnit[1]]);  
                
            }
        }

        else
        {
            return $arr->error_message;
        }
    }
}
