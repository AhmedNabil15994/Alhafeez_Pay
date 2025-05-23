<?php

namespace Modules\User\Repositories\Dashboard;

use DB;
use Hash;
use Modules\User\Entities\User;
use Modules\User\Enum\UserType;
use Modules\Core\Traits\Attachment\Attachment;

class UserRepository
{
    public function __construct(User $user)
    {
        $this->user      = $user;
    }

    public function getAll()
    {
        return $this->user->baseType(UserType::CIVIL)->orderBy('id', 'DESC')->get();
    }

    public function getAllActive()
    {
        return $this->user->baseType(UserType::CIVIL)->select("id", "name")->orderBy('id', 'DESC')->get();
    }

    public function userCreatedStatistics()
    {
        $data["userDate"] = $this->user
                            ->baseType(UserType::CIVIL)
                            ->select(\DB::raw("DATE_FORMAT(created_at,'%Y-%m') as date"))
                            ->groupBy('date')
                            ->pluck('date');

        $userCounter = $this->user
                        ->baseType(UserType::CIVIL)
                        ->select(\DB::raw("count(id) as countDate"))
                        ->groupBy(\DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                        ->get();

        $data["countDate"] = json_encode(array_pluck($userCounter, 'countDate'));

        return $data;
    }

    public function countUsers($order = 'id', $sort = 'desc')
    {
        $users = $this->user->baseType(UserType::CIVIL)->count();

        return $users;
    }

    /*
    * Get All Normal Users Without Roles
    */
    public function getAllUsers($order = 'id', $sort = 'desc')
    {
        $users = $this->user->baseType(UserType::CIVIL)->orderBy($order, $sort)->get();
        return $users;
    }

    /*
    * Find Object By ID
    */
    public function findById($id, $with=[])
    {
        $user = $this->user->withDeleted()->with($with)->find($id);
        return $user;
    }

    /*
    * Find Object By ID
    */
    public function findByEmail($email)
    {
        $user = $this->user->where('email', $email)->first();
        return $user;
    }

    /*
    * Find Object By ID
    */
    public function findByEmailOrMobile($email, $mobile)
    {
        $user = $this->user->where(['email' => $email ,'mobile' => $mobile])->first();
        return $user;
    }


    /*
    * Create New Object & Insert to DB
    */
    public function create($request)
    {
        DB::beginTransaction();

        try {
            $data = $request->except(["image", "id_image"]);

            $data = array_merge($data, [
                "image"             => '/uploads/users/user.png',
                "admin_approved"    => $request->admin_approved ?? 0,
                "is_verified"       => $request->is_verified ?? 0,
                'password'  => Hash::make($request['password']),
                "type"       => UserType::CIVIL,
            ]);

            $user = $this->user->create($data);

            if ($request->image) {
                $imagesUpload["image"] = Attachment::uploadAttach($request->image, $user->getTable(), $user);

                if ($request->id_image) {
                    $imagesUpload["id_image"] = Attachment::uploadAttach($request->id_image, $user->getTable(), $user);
                }

                if (count($imagesUpload)> 0) {
                    $user->update($imagesUpload);
                }
            }

            if ($request->parent_id) {
                $user->parents()->attach($request->parent_id);
            }

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }



    /*
    * Find Object By ID & Update to DB
    */
    public function update($request, $id)
    {
        DB::beginTransaction();

        $user = $this->findById($id);
        $request->trash_restore ? $this->restoreSoftDelte($user) : null;

        $data = $request->except(["image", "id_image","password"]);

        if ($request->password) {
            $data["password"]  = Hash::make($request['password']);
        }



        if ($request->image) {
            Attachment::deleteAttachment($user->image);
            $data["image"] = Attachment::uploadAttach($request->image, $user->getTable(), $user);
        }

        if ($request->id_image) {
            Attachment::deleteAttachment($user->id_image);
            $data["id_image"] = Attachment::uploadAttach($request->id_image, $user->getTable(), $user);
        }

        $data = array_merge($data, [
                "admin_approved"    => $request->admin_approved ?? 0,
                "is_verified"       => $request->is_verified ?? 0,
        ]);

        try {
            $user->update($data);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelte($model)
    {
        $model->restore();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $model = $this->findById($id);

            if ($model->trashed()):
              Attachment::deleteFolder($model->getTable()."/".$model->id);
            $model->forceDelete(); else:
              $model->delete();
            endif;

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /*
    * Find all Objects By IDs & Delete it from DB
    */
    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {
            foreach ($request['ids'] as $id) {
                $model = $this->delete($id);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /*
    * Generate Datatable
    */
    public function QueryTable($request)
    {
        $query = $this->user
        ->where('id', '!=', auth()->id())->baseType(UserType::CIVIL)->withDeleted()
        ;

        if ($request->input('search.value')) {
            $query->where(function ($query) use ($request) {
                $query->where('id', 'like', '%'. $request->input('search.value') .'%');
                $query->orWhere('name', 'like', '%'. $request->input('search.value') .'%');
                $query->orWhere('email', 'like', '%'. $request->input('search.value') .'%');
                $query->orWhere('mobile', 'like', '%'. $request->input('search.value') .'%');
            });
        }

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    /*
    * Filteration for Datatable
    */
    public function filterDataTable($query, $request)
    {
        // Search Users by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '') {
            $query->whereDate('created_at', '>=', $request['req']['from']);
        }

        if (isset($request['req']['to']) && $request['req']['to'] != '') {
            $query->whereDate('created_at', '<=', $request['req']['to']);
        }

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only') {
            $query->onlyDeleted();
        }

        if ($request->has("req.admin_approved")) {
            $query->where("admin_approved", $request->input("req.admin_approved"));
        }

        // dd($request->all());

        if ($request->has("req.level_id")) {
            $query->where("level_id", $request->input("req.level_id"));
        }

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with') {
            $query->withDeleted();
        }

        return $query;
    }
}
