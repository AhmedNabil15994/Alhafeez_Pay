<?php

namespace Modules\Apps\Repositories\Dashboard;

use Modules\Apps\Entities\ContactUs as Model;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class ContactUsRepository extends CrudRepository
{
    /**
    * Status attribute in model
    * @var array
    */
    protected $fileAttribute = [
     
    ];

    /**
    * Status attribute in model
    * @var array
    */
    protected array $statusAttribute = [
      
    ];

    public function __construct()
    {
        parent::__construct(Model::class);
    }
}
