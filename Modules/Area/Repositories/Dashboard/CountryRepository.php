<?php

namespace Modules\Area\Repositories\Dashboard;

use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Area\Entities\Country as Model;

class CountryRepository extends CrudRepository
{
    public function __construct()
    {
        parent::__construct(Model::class);
    }
}
