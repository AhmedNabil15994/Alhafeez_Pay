<?php

namespace Modules\Core\Traits\Dashboard;

use Illuminate\Http\Request;
use Modules\Core\Traits\DataTable;
use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

trait CrudDashboardController
{
    use ControllerSetterAndGetter;
    use AuthorizesRequests;

    public function __construct()
    {
        $this->setViewPath($this->view_path ?? null);
        $this->setResource($this->model_resource ?? null);
        $this->setModel();
        $this->setRepository();
        $this->setRequest();
        // $this->setBasePermissions($this->repository->getModel());
        // $this->checkPermissions();
    }

    /**
     * Check Permissions
     *
     * @return void
     */
    public function checkPermissions()
    {
        $this->middleware("can:show_{$this->basePermissions}", ["index","datatable", "show"]);
        $this->middleware("can:edit_{$this->basePermissions}", ["edit","update","switcher"]);
        $this->middleware("can:add_{$this->basePermissions}", ["store","create"]);
        $this->middleware("can:delete_{$this->basePermissions}", ["destroy","deletes"]);
    }

    /**
     * @param $view_name
     * @param array $params
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function view($view_name, $params = [])
    {
        return view()->exists($this->view_path  .'.'. $view_name) ?
            view($this->view_path  .'.'. $view_name, $params):
            view($this->default_view_path  .'.'. $view_name, $params);
    }

    public function index()
    {
        return $this->view('index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->repository->QueryTable($request));

        $resource = $this->model_resource;
        $datatable['data'] = $resource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function show($id)
    {
        $model = $this->repository->findById($id);
        return $this->view('show', compact('model'));
    }

    public function create()
    {
        $model = $this->model;
        return $this->view('create', compact('model'));
    }

    public function store()
    {
        $request = App::make($this->request);

        try {
            $create = $this->repository->create($request);

            if ($create) {
                return Response()->json([true , __('apps::dashboard.messages.created')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function edit($id)
    {
        $model = $this->repository->findById($id);

        return $this->view('edit', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $request = App::make($this->request);

        try {
            $update = $this->repository->update($request, $id);

            if ($update) {
                return Response()->json([true , __('apps::dashboard.messages.updated')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {

        try {
            $delete = $this->repository->delete($id);

            if ($delete) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->repository->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function switcher($id, $action)
    {
        try {
            $switch = $this->repository->switcher($id, $action);

            if ($switch) {
                return Response()->json();
            }

            return Response()->json([false  , __('apps::dashboard.messages.failed')], 400);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
