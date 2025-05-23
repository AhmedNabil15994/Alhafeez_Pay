<?php

namespace Modules\Slider\Repositories\Dashboard;

use Illuminate\Http\Request;
use \Modules\Slider\Entities\Slider as Model;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class SliderRepository extends CrudRepository
{
    /**
    * Status attribute in model
    * @var array
    */
    protected $fileAttribute = [
        "image"     => "image"
    ];

    public function __construct()
    {
        parent::__construct(Model::class);
    }

    /**
     * Prepare Data before save or edir
     *
     * @param array $data
     * @param \Illuminate\Http\Request $request
     * @param boolean $is_create
     * @return array
     */
    public function prepareData(array $data, Request $request, $is_create = true): array
    {
        $data["value"] = $request->value ?? null;
        return $data;
    }
}
