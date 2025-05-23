<?php

namespace Modules\Authentication\Http\Controllers\Frontend;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Vendor\Entities\Vendor;
use Modules\Vendor\Enum\VendorType;
use Illuminate\Support\Facades\Hash;
use Modules\Vendor\Repositories\Frontend\CustomTokenTrait;
use Illuminate\Support\Facades\Session;
use Modules\Vendor\Events\VendorRegisteredEvent;
use Modules\Authentication\Http\Requests\Frontend\RegisterRequest;

class AuthController extends Controller
{
    use CustomTokenTrait;

    public function login(Request $request)
    {
        $message = new \Illuminate\Support\MessageBag;

        if( Str::lower($request->method())=='get' )
        {
            return view('authentication::frontend.auth.login');
        }

        //who are the use by his email
        $user = Vendor::whereIn('type', VendorType::getTypeRegisterApi())->where('email', $request->email)->first();
        if( is_null($user) )
        {
            $errors = $message->add('email', __('authentication::frontend.login.validations.user_not_found'));
            Session::flash('errors', $errors);
            return redirect()->route('vendors.login');
        }

        //check if valid password
        if( !Hash::check($request->password, $user->password) )
        {
            $errors = $message->add('password', __('authentication::frontend.login.validations.wrong_credential'));
            Session::flash('errors', $errors);
            return redirect()->route('vendors.login');
        }

        //define back URL
        $url = route('vendors.home');
        if( !is_null($request->back_url) && filter_var($request->back_url, FILTER_VALIDATE_URL) )
        {
            $app_url_parse = parse_url( config('app.url') );
            $back_url_parse = parse_url( $request->back_url );

            if( isset($app_url_parse['host']) && isset($back_url_parse['host']) && $app_url_parse['host']==$back_url_parse['host'] )
            {
                $url = $request->back_url;
            }
        }

        \Auth::guard('vendor')->login($user);
        return redirect()->route('vendors.home');
    }

    public function logout()
    {
        \Auth::guard('vendor')->logout();
        return redirect()->route('vendors.login');
    }

    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->except('_token', 'password_confirm');
            unset($data['password']);

            $vendor = Vendor::create(array_merge($data, ['password' => Hash::make($request->password)]));
            $this->createToken($vendor);

            event( new VendorRegisteredEvent($vendor) );

            if ($vendor) {
                return Response()->json(
                    [
                        'success' => true,
                        'message' => __('vendor::frontend.messages.your_account_created_check_email')
                    ]
                );
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function verify(Request $request)
    {
        abort_if(is_null($request->email) || is_null($request->token), 404);
        $vendor = Vendor::where('email', $request->email)->firstOrFail();
        return redirect()->route('subscriptions.trial', $vendor);
        if( $this->verifyToken($vendor, $request->token) )
        {
            $vendor->email_verified_at = now();
            $vendor->save();

            return redirect()->route('subscriptions.trial', $vendor);
        }

        return view('authentication::frontend.auth.token_expired');
    }

    public function reGenerate(Request $request)
    {
        abort_if(is_null($request->email), 404);
        $vendor = Vendor::where('email', $request->email)->firstOrFail();

        $this->createToken($vendor);
        event( new VendorRegisteredEvent($vendor) );

        return ['success' => true];
    }
}
