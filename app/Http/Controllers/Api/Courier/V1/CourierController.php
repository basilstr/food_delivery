<?php

namespace App\Http\Controllers\Api\Courier\V1;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use Illuminate\Http\Request;


class CourierController extends Controller
{
    public function login(Request $request)
    {
        $phone = $request->input('phone');
        $phone = preg_replace("/[^0-9]/", '', $phone);
        $password = $request->input('password');
        return Courier::getApiToken(['phone' => $phone, 'password' => $password]);
    }

}
