<?php

namespace Modules\Authentication\Repositories\Api;

use DB;
use Hash;
use Carbon\Carbon;
use Modules\User\Entities\User;
use Modules\User\Entities\MobileCode;
use Modules\Core\Packages\SMS\SmsGetWay;
use Modules\User\Entities\PasswordReset;
use Modules\Core\Traits\Attachment\Attachment;

class AuthenticationRepository
{
    public function __construct(User $user, PasswordReset $password, SmsGetWay $sms)
    {
        $this->password  = $password;
        $this->user      = $user;
        $this->sms       = $sms;
    }

    public function register($request)
    {
        DB::beginTransaction();

        try {
            $data = $request->except(["image", "id_image"]);

            $data = array_merge($data, [
                "image"             => '/uploads/users/user.png',
                "admin_approved"    => 0,
                "is_verified"       => !config("services.sms.have_sms"),
                'password'  => Hash::make($request['password']),
            ]);
            $user = $this->user->create($data);
            $imagesUpload = [];
            if ($request->image) {
                $imagesUpload["image"] = Attachment::uploadAttach($request->image, $user->getTable(), $user);
            }

            if ($request->id_image) {
                $imagesUpload["id_image"] = Attachment::uploadAttach($request->id_image, $user->getTable(), $user);
            }

            if (count($imagesUpload)> 0) {
                $user->update($imagesUpload);
            }

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    public function findUserByEmail($request)
    {
        $user = $this->user->where('email', $request->email)->first();
        return $user;
    }

    public function findUserByMobile($mobile, $phone_code)
    {
        return  $this->user->where(
            [
            'mobile'       => $mobile,
            'phone_code'   => $phone_code
          ]
        )->firstOrFail();
    }

    public function createToken($request)
    {
        $user = $this->findUserByEmail($request);

        $this->deleteTokens($user);

        $newToken = strtolower(str_random(64));

        $token =  $this->password->insert([
          'email'       => $user->email,
          'token'       => $newToken,
          'created_at'  => Carbon::now(),
        ]);

        $data = [
          'token' => $newToken,
          'user'  => $user
        ];

        return $data;
    }

    public function resetPassword($request)
    {
        $user = $this->findUserByEmail($request);

        $user->update([
          'password' => Hash::make($request->password)
        ]);

        $this->deleteTokens($user);

        return true;
    }

    public function deleteTokens($user)
    {
        $this->password->where('email', $user->email)->delete();
    }

    public function sendCode($user)
    {
        $code = generateRandomCode();
        if (config("services.sms.test")) {
            return $this->saveOrUpdateMobileCode($user, $code);
        }
        $result =  $this->sms->send($code, $user->getPhone());
        if ($result["Result"] == "true") {
            return $this->saveOrUpdateMobileCode($user, $code);
        }
    }

    public function saveOrUpdateMobileCode($user, $code=null)
    {
        $mobileCode = MobileCode::updateOrCreate([
                "mobile"    => $user->mobile ,
                "phone_code"=> $user->phone_code,
                "user_type"=> $user ? get_class($user)  : null ,
                "user_id"  => $user ? $user->id : null
              
            ], [
                'code'      => $code,
            ]);
    
        return $mobileCode;
    }

    public function verifyUser($user)
    {
        $user->update(["is_verified"=>true]);
        $user->mobileCode()->update(["code"=>null]);
    }
}
