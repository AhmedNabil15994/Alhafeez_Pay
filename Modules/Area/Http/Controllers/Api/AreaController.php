<?php

namespace Modules\Area\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Area\Transformers\Api\AreaResource;
use Modules\Area\Transformers\Api\CityResource;
use Modules\Area\Transformers\Api\StateResource;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Area\Transformers\Api\CountryResource;
use Modules\Area\Repositories\Api\AreaRepository as Area;

class AreaController extends ApiController
{
    public function __construct(Area $area)
    {
        $this->area = $area;
    }

    public function cities()
    {
        $citites =  $this->area->getAllCities();
        return CityResource::collection($citites);
    }

    public function countries()
    {
        return $this->response(
            CountryResource::collection(
                $this->area->getAllCountries()
            )
        );
    }
}
