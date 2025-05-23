<?php

namespace Modules\User\Repositories\Api;

use DB;
use Hash;
use Modules\User\Entities\User;
use Modules\User\Enum\UserType;
use Modules\Core\Traits\Attachment\Attachment;

class UserRepository
{
    public function __construct(User $user)
    {
        $this->user  = $user;
    }

    public function getAll()
    {
        return $this->user->orderBy('id', 'DESC')->get();
    }

    public function changePassword($request)
    {
        $user = auth()->user();

        if ($request['password'] == null) {
            $password = $user['password'];
        } else {
            $password  = Hash::make($request['password']);
        }

        DB::beginTransaction();

        try {
            $user->update([
                'password'      => $password,
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    public function update($request, $user=null)
    {
        $user = $user ?? auth()->user();

        $data = $request->except(["image", "id_image"]);

        if ($request->password) {
            $data["password"]  = Hash::make($request['password']);
        }

        if (
            config("services.sms.have_sms") &&
            ($user->phone_code != $request['phone_code'] || $user->mobile != $request['mobile'])
        ) {
            $data["is_verified"] = 0;
        }

        if ($request->image) {
            Attachment::deleteAttachment($user->image);
            $data["image"] = Attachment::uploadAttach($request->image, $user->getTable(), $user);
        }

        if ($request->id_image) {
            Attachment::deleteAttachment($user->id_image);
            $data["id_image"] = Attachment::uploadAttach($request->id_image, $user->getTable(), $user);
        }


        DB::beginTransaction();

        try {
            $user->update($data);

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

   
    public function userProfile($with=[])
    {
        return $this->user->where('id', auth()->id())->with($with)->first();
    }

    public function findById($id, $with=[], $fail=false)
    {
        $base =  $this->user->where('id', $id)->with($with);
        if ($fail) {
            return $base->firstOrFail();
        }
        return $base->first();
    }

    public function deleteUser($user)
    {
        Attachment::deleteFolder("users/".$user->id);
    }

    public function listNotifications($user, $request)
    {
        $base =  $user->userNotifications()->latest("id");
        if ($request->unread) {
            $base->whereNull("read_at");
        }
        if ($request->mark_read) {
            $this->markUnreadNotificationAsRead($user);
        }
        return $base->paginate($request->page_count ?? config("app.page_count", 15));
    }

    public function markUnreadNotificationAsRead($user)
    {
        $user->unreadUserNotifications()->update(["read_at"=>now()]);
    }

    public function deleteNotification($user, $request)
    {
        $base =  $user->userNotifications();
        if (is_string($request->id)) {
            $base->where("id", $request->id);
        };
        if (is_array($request->id)) {
            $base->whereIn("id", $request->id);
        };

        $base->delete();
    }
}
