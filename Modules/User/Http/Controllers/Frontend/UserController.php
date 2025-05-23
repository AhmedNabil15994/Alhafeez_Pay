<?php

namespace Modules\User\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\User\Entities\User as UserModel;
use Modules\User\Http\Requests\Frontend\UserRequest;
use Modules\User\Transformers\Frontend\UserResource;
use Modules\User\Repositories\Frontend\UserRepository as User;

class UserController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return view('user::frontend.users.index');
    }

    public function datatable(Request $request)
    {
        $this->user->vendor();
        $datatable = DataTable::drawTable($request, $this->user->QueryTable($request));

        $datatable['data'] = UserResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create(Request $request)
    {
        $this->user->vendor();
        $model = new UserModel;

        if( is_null($request->id_number) )
        {
            return redirect()->route('vendors.users.enter_id');
        }

        if( $model->where('id_number', $request->id_number)->exists() )
        {
            return redirect()->route('vendors.users.add_note', ['id_number' => $request->id_number]);
        }

        return view('user::frontend.users.create', compact("model"));
    }

    public function enterIdNumber()
    {
        return view('user::frontend.users.check.enter_id');
    }

    public function addNote(Request $request)
    {
        $model = $this->user->findBy('id_number', $request->id_number);
        abort_if(is_null($model), 404);

        return view('user::frontend.users.check.add_note', compact('model'));
    }

    public function submitNote(Request $request)
    {
        $model = $this->user->findBy('id_number', $request->id_number);
        $this->user->vendor();
        abort_if(is_null($model), 404);

        $model->notes()->updateOrCreate(
            [
                'vendor_id' => $this->user->getVendor()->id
            ],
            [
                'note' => $request->note,
                'status' => in_array($request->status, ['clean', 'blocked']) ? $request->status : 'clean'
            ]
            );

        return redirect()->route('vendors.home', ['id_number' => $model->id_number])->with('success', __('user::frontend.note_added'));
    }

    public function checkId(Request $request)
    {
        if( is_null($this->user->findBy('id_number', $request->id_number)) )
        {
            return redirect()->route('vendors.users.create', ['id_number' => $request->id_number]);
        }

        return redirect()->route('vendors.users.add_note', ['id_number' => $request->id_number]);
    }

    public function store(UserRequest $request)
    {
        $this->user->vendor();
        try {
            $create = $this->user->create($request);

            if ($create) {
                return Response()->json([true , __('apps::dashboard.messages.created')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        abort(404);
        return view('user::frontend.users.show');
    }

    public function edit($id)
    {
        $this->user->vendor();
        $model = $this->user->findById($id);
        abort_if( is_null($model), 404 );
        abort_if( $model->vendor_id != $this->user->getVendor()->id, 404 );

        return view('user::frontend.users.edit', compact('model'));
    }

    public function update(UserRequest $request, $id)
    {
        $this->user->vendor();
        try {
            $update = $this->user->update($request, $id);

            if ($update) {
                return Response()->json([true , __('apps::dashboard.messages.updated')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        $this->user->vendor();
        try {
            $delete = $this->user->delete($id);

            if ($delete) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        $this->user->vendor();
        try {
            $deleteSelected = $this->user->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
