<?php

namespace Modules\Authentication\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\User\Transformers\Api\UserResource;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Authentication\Http\Requests\Api\ForgetPasswordRequest;
use Modules\Authentication\Notifications\Api\ResetPasswordNotification;
use Modules\Authentication\Repositories\Api\AuthenticationRepository as Authentication;

class ForgotPasswordController extends ApiController
{
    function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $token = $this->auth->createToken($request);

        $token['user']->notify((new ResetPasswordNotification($token))->locale(locale()));

        return $this->response([], __('authentication::api.forget_password.messages.success') );
    }
}
