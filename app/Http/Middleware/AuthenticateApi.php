<?php

namespace App\Http\Middleware;

use App\Models\Client;
use App\Models\Courier;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthenticateApi extends Middleware
{

    protected function authenticate($request, array $guards)
    {
        $path = $request->decodedPath();
        $token = $request->bearerToken();
        if($token){
            $nameModel = false;
            if(strpos($path, 'api/client') !== false) $nameModel = Client::class;
            if(strpos($path, 'api/user') !== false) $nameModel = User::class;
            if(strpos($path, 'api/courier') !== false) $nameModel = Courier::class;

            if($nameModel) {
                $model = $nameModel::where('api_token', $token)
                    ->where('api_token_expiration', '>', date('Y-m-d H:i:s', time()))
                    ->first();
                if ($model) {
                    // якщо статус != АКТИВНИЙ
                    if ($model->status != $nameModel::ACTIVE) {
                        throw new AuthenticationException(
                            'Blocked', $guards, $this->redirectTo($request)
                        );
                    }
                    return;
                }
            }
        }
        $this->unauthenticated($request, $guards);
    }

}
