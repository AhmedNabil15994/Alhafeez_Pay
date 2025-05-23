<?php
namespace App\Tocaan\Payments\Core\Contracts;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Tocaan\Payments\Core\Gateway;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

interface GatewayContract
{
    public function pay(null|array $credentials): null|RedirectResponse;
    public function success(Request $request);
    public function failure(Request $request);
}
