<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\User\Transformers\Api\UserResource;
use Modules\User\Http\Requests\Api\ChildRequest;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\User\Http\Requests\Api\UpdateChildRequest;
use Modules\User\Http\Requests\Api\UpdateProfileRequest;
use Modules\User\Http\Requests\Api\ChangePasswordRequest;
use Modules\User\Repositories\Api\UserRepository as User;
use Modules\User\Transformers\Api\UserNotificationResource;

class UserController extends ApiController
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function profile()
    {
        $user =  $this->user->userProfile(["nationality"]);
        return $this->response(new UserResource($user));
    }

    public function notifications(Request $request)
    {
        $user = auth()->user();
        return $this->responsePagination(
            UserNotificationResource::collection(
                $this->user->listNotifications($user, $request)
            )
        );
    }

    public function deleteNotifications(Request $request)
    {
        $user = auth()->user();
        $this->user->deleteNotification($user, $request);
        return $this->response([]);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $this->user->update($request, auth()->user());

        $user =  $this->user->userProfile(["nationality"]);

        return $this->response(new UserResource($user));
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $this->user->changePassword($request);

        return $this->response([]);
    }

    public function addChild(ChildRequest $request)
    {
        $user = $this->user->storeChild($request);
        $user->loadMissing(["nationality"]);
        return $this->response(new UserResource($user));
    }

    public function listChild(Request $request)
    {
        $users = $this->user->listChildForUser(auth()->user(), $request, ["nationality", "level"]);
      
        return $this->responsePagination(UserResource::collection($users));
    }

    public function updateChild(UpdateChildRequest $request, $id)
    {
        $parent = auth()->user();
        $user = $this->user->findChildById($parent, $id);
        $user = $this->user->update($request, $user);
        $user->loadMissing(["nationality", "level"]);

        return $this->response(new UserResource($user));
    }

    public function deleteChild(Request $request, $id)
    {
        $parent = auth()->user();
        $user = $this->user->findChildById($parent, $id);
        $this->user->deleteUser($user);
        return $this->response([]);
    }
}
