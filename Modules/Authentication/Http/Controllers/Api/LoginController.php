<?php

namespace Modules\Authentication\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\User\Transformers\Api\UserResource;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Authentication\Foundation\Authentication;
use Modules\Authentication\Http\Requests\Api\LoginRequest;
use Modules\Authentication\Http\Requests\Api\SendCodeRequest;
use Modules\Authentication\Http\Requests\Api\VerifiedCodeRequest;
use Modules\Authentication\Repositories\Api\AuthenticationRepository as AuthenticationRepo;

class LoginController extends ApiController
{
    use Authentication;

    public function __construct(AuthenticationRepo $auth)
    {
        $this->auth = $auth;
    }

    public function postLogin(LoginRequest $request)
    {
        $failedAuth =  $this->loginByIdNumber($request);

        if ($failedAuth) {
            return $this->invalidData($failedAuth, [], 422);
        }

        return $this->tokenResponse();
    }

    public function tokenResponse($user = null)
    {
        $user = $user ? $user : auth()->user();
        
        $user->loadMissing(["nationality", "level"]);
        $user->loadCount("unreadUserNotifications");

        $token = $this->generateToken($user);

        return $this->response([
            'access_token' => $token,
            'user'         => new UserResource($user),
            'token_type'   => 'Bearer',
        ]);
    }

    public function sendCode(SendCodeRequest $request)
    {
        $user = $this->auth->findUserByMobile($request->mobile, $request->phone_code)  ;

        if ($request->check_verify && $user->is_verified) {
            return $this->error(__('authentication::api.register.messages.already_verified'));
        }
    
        if ($user) {
            if ($mobileCode =$this->auth->sendCode($user)) {
                return $this->response([
                  "code_verified" => config("app.env") !="production" ?  $mobileCode->code : true
              ], __('authentication::api.resend.success'));
            }

            return $this->error(__('authentication::api.register.messages.error_sms'), [], 420);
        }

        return  $this->error(__('authentication::api.register.messages.failed'), [], 401);
    }

    public function verifiedCode(VerifiedCodeRequest $request)
    {
        $user = $this->auth->findUserByMobile($request->mobile, $request->phone_code)  ;

        if ($user) {
            $this->auth->verifyUser($user);

            if ($request->not_get_token) {
                return $this->response([
                    'user'         => new UserResource($user),
                ]);
            }
            return $this->tokenResponse($user);

            return $this->error(__('authentication::api.register.messages.code'), [], 420);
        }

        return  $this->error(__('authentication::api.register.messages.failed'), [], 401);
    }

    public function logout(Request $request)
    {
        $user = auth()->user()->currentAccessToken()->delete();

        return $this->response([], __('authentication::api.logout.messages.success'));
    }
}
