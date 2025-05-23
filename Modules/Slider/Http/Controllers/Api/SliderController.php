<?php

namespace Modules\Slider\Http\Controllers\Api;

use Illuminate\Http\Request;

use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Slider\Repositories\Api\SliderRepository as Repo;
use Modules\Slider\Transformers\Api\SliderResource as ModelResource;

class SliderController extends ApiController
{
    public function __construct(Repo $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        return $this->response(
            ModelResource::collection($this->repo->getRandomPerRequest($request))
        );
    }

}
