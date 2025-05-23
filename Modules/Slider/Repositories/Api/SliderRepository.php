<?php

namespace Modules\Slider\Repositories\Api;

use Modules\Slider\Entities\Slider as Model;

class SliderRepository
{
    public function __construct(Model $model)
    {
        $this->model   = $model;
    }

    public function getRandomPerRequest($request)
    {
        $models = $this->model
                ->active()
                ;

        return $models->unexpired()->started()->inRandomOrder()->take(6)->get();
    }
}
