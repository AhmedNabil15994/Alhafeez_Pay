<?php
namespace Modules\Apps\Http\Controllers\Dashboard;

use Illuminate\Routing\Controller;
use Modules\Core\Traits\Dashboard\CrudDashboardController;

class ContactUsController extends Controller
{
    use CrudDashboardController;

    protected $view_path = "apps::dashboard.contactUs";
}
