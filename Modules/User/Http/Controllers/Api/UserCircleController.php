<?php
namespace Modules\User\Http\Controllers\Api;

use Illuminate\Http\Request;

use Modules\Ensaan\Transformers\Api\CourseResource;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Ensaan\Transformers\Api\StudentResource;
use Modules\User\Transformers\Api\SelimUserResource;
use Modules\Ensaan\Http\Requests\Api\RegisterAttends;
use Modules\Ensaan\Transformers\Api\CircleQuizResource;
use Modules\Ensaan\Transformers\Api\CircleTimeResource;
use Modules\Ensaan\Transformers\Api\QuizResultResource;
use Modules\Ensaan\Transformers\Api\CircleAttachResource;
use Modules\Ensaan\Transformers\Api\CircleAttendResource;
use \Modules\User\Repositories\Api\UserRepository as Repo;
use Modules\Ensaan\Http\Requests\Api\RecordQuizResultRequest;
use Modules\Ensaan\Transformers\Api\CircleResource as ModelResource;

class UserCircleController extends ApiController
{

}
