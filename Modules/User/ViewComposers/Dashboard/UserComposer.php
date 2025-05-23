<?php

namespace Modules\User\ViewComposers\Dashboard;

use Modules\User\Repositories\Frontend\UserRepository as User;
use Illuminate\View\View;
use Cache;

class UserComposer
{
    public $users = [];

    public function __construct(User $user)
    {
        $this->user->vendor();
        $this->users =  $user->getAll();
    }

    public function compose(View $view)
    {
        $this->user->vendor();
        $view->with('users' , $this->users);
    }
}
