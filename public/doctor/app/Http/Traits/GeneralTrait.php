<?php
namespace App\Http\Traits;
use Illuminate\Support\Facades\Http;
use App\Support\Collection;

trait GeneralTrait{
    public function getPaymentMethod($hotel_code,$auth_code,$id=null){

        $rows = Http::post('https://live.ipms247.com/index.php/page/service.kioskconnectivity', [
            "RES_Request"=>[
            "Request_Type"=> "RetrievePayMethods",
            "Authentication"=> [
                    "HotelCode" => $hotel_code,
                    "AuthCode"  => $auth_code,
                ]
            ]
        ])['Success']['PayMethods'];
        // if($id != null){
        //     $rows= (new Collection($rows))->where('PaymentID',$id)->paginate(8);
        // }else{
        //     $rows= (new Collection($rows))->paginate(8);
        // }
        return $rows;
    }
    public function getPaymentNameById($hotel_code,$auth_code,$id){

        $rows = Http::post('https://live.ipms247.com/index.php/page/service.kioskconnectivity', [
            "RES_Request"=>[
            "Request_Type"=> "RetrievePayMethods",
            "Authentication"=> [
                    "HotelCode" => $hotel_code,
                    "AuthCode"  => $auth_code,
                ]
            ]
        ])['Success']['PayMethods'];
        $row= (new Collection($rows))->where('PaymentID',$id)->first();
        $name=null;
        if($row != null)
        {
            $name=$row['Name'];
        }
        return $name;
    }
    public function getIdentityType($hotel_code,$auth_code,$id=null){

        $rows = Http::post('https://live.ipms247.com/index.php/page/service.kioskconnectivity', [
            "RES_Request"=>[
            "Request_Type"=> "RetrieveIdentityType",
            "Authentication"=> [
                "HotelCode"=> $hotel_code,
                "AuthCode"=> $auth_code,
            ]
            ]
        ])['Success']['IdentityType'];
        // $rows= (new Collection($rows))->paginate(8);
        return $rows;
    }
    public function getIdentityTypeById($hotel_code,$auth_code,$id){

        $rows = Http::post('https://live.ipms247.com/index.php/page/service.kioskconnectivity', [
            "RES_Request"=>[
            "Request_Type"=> "RetrieveIdentityType",
            "Authentication"=> [
                    "HotelCode"=> $hotel_code,
                    "AuthCode"=> $auth_code,
            ]
            ]
        ])['Success']['IdentityType'];
        $row= (new Collection($rows))->where('IdentityTypeID',$id)->first();
        $name=null;
        if($row != null)
        {
            $name=$row['Name'];
        }
        return $name;
    }
    public function getRooms($hotel_code,$auth_code){

        $rows =(array)Http::post('https://live.ipms247.com/pmsinterface/pms_connectivity.php', [
            "RES_Request"=>[
            "Request_Type"=> "RoomInfo",
            "NeedPhysicalRooms"=>1,

            "Authentication"=> [
                    "HotelCode"=> auth()->user()->hotel->hotel_code,
                    "AuthCode"=> auth()->user()->hotel->auth_code,
            ]
        ]
        ])->json();
        $rows=($rows['RoomInfo']['RoomTypes']['RoomType']);
        $arr=array();
        foreach($rows as $row)
        {
            if(!empty($row['Rooms'])){
                foreach($row['Rooms'] as $ro){
                    $ro['Type']=$row['Name'];
                    array_push($arr,$ro);
                }
            }
        }
        $rows= (new Collection($arr))->all();
        return $rows;
    }

}
