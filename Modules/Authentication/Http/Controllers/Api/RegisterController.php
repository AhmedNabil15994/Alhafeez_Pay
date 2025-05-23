<?php

namespace Modules\Authentication\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\User\Transformers\Api\UserResource;
use Modules\Authentication\Foundation\Authentication;
use Modules\Authentication\Http\Requests\Api\RegisterRequest;
use Modules\Authentication\Http\Requests\Api\CompanyRegisterRequest;
use Modules\Authentication\Repositories\Api\AuthenticationRepository as AuthenticationRepo;

class RegisterController extends ApiController
{
    use Authentication;

    public function __construct(AuthenticationRepo $auth)
    {
        $this->auth = $auth;
    }

    public function register(RegisterRequest $request)
    {
        $registered = $this->auth->register($request);

        if ($registered) {
            if ($request->without_token) {
                return $this->response(
                    new UserResource($registered)
                );
            }

            return $this->tokenResponse($registered);
        }
        return $this->error(__('authentication::api.register.messages.failed'), [], 401);
    }

    public function tokenResponse($user = null)
    {
        $user = $user ? $user : auth()->user();
        $token = $this->generateToken($user);
        $user->loadMissing(["nationality"]);
        return $this->response([
            'access_token' => $token,
            'user'         => new UserResource($user),
            'token_type'   => 'Bearer'
        ]);
    }
}
