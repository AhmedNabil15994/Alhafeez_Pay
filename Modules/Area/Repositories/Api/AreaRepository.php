<?php

namespace Modules\Area\Repositories\Api;

use Modules\Area\Entities\Area;
use Modules\Area\Entities\City;
use Modules\Area\Entities\State;
use Modules\Area\Entities\Country;

class AreaRepository
{
    public function __construct(Country $country, City $city, State $state, Area $area)
    {
        $this->state   = $state;
        $this->area    = $area;
        $this->city    = $city;
        $this->country = $country;
    }

    public function getAllCities($order = 'id', $sort = 'desc')
    {
        $cities = $this->city->active()->with('states')->orderBy($order, $sort)->get();
        return $cities;
    }

    public function getAllCountries($with=[], $order = 'id', $sort = 'desc')
    {
        return $this->country
                    ->active()->with($with)->orderBy($order, $sort)->get();
    }
}
