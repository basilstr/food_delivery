<?php

namespace App\Http\Controllers\Api\Client\V1;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;


class ClientController extends Controller
{
    public function login(Request $request)
    {
        $phone = $request->input('phone');
        $phone = preg_replace("/[^0-9]/", '', $phone);
        $code = $request->input('code');
        return Client::getApiToken(['phone' => $phone, 'sms_code' => intval($code)]);
    }

}
