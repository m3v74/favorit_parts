<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetController extends Controller
{
    public function getPrices(Request $request)
    {
        $code = $request->code;
        $analogs = !($request->analogs == 'false');
        $fullResponse = [];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.favorit-parts.ru/hs/hsprice/?key=A1234567-ABCD-1234-ABCD-ABC123456789&number=$code",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $responseFirst = json_decode($response);
        if ($analogs) {
            $goods = $responseFirst->goods;
            foreach ($goods as $item) {
                $brand = $item->brand;
                $curl = curl_init();
                $url = "http://api.favorit-parts.ru/hs/hsprice/?key=A1234567-ABCD-1234-ABCD-ABC123456789&number=$code&brand=$brand&analogues=on";
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($curl);
                curl_close($curl);
                $responseSecond = json_decode($response);
                $fullResponse[] = $responseSecond;
            }
        } else {
            $fullResponse[] = $responseFirst;
        }

        return $fullResponse;
    }
}
