<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Parents;
use Illuminate\Http\Request;
use Modules\Vendor\Entities\Vendor;

class isVendor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if( is_null(auth()->guard('vendor')->user()) )
        {
            return redirect()->route('vendors.login');
        }

        if( !in_array($request->route()->getName(),
            [
                'subscriptions.trial',
                'subscriptions.go-trial',
                'subscriptions.renew',
                'subscriptions.go-renew',
                'subscriptions.subscribe',
                'subscriptions.go-subscribe',
                'subscriptions.pay',
                'subscriptions.no_for_childs'
                ]) )
        {
            $vendor = auth()->guard('vendor')->user();

            if( is_null(Parents::ParentOrChild($vendor)->subscription) )
            {
                if( !is_null($vendor->parent_id) )
                {
                    return redirect()->route('subscriptions.no_for_childs', Parents::ParentOrChild($vendor));
                }

                if( setting('subscriptions', 'trial')!=="disabled" )
                {
                    return redirect()->route('subscriptions.trial', auth()->guard('vendor')->user());
                }

                return redirect()->route('subscriptions.subscribe', auth()->guard('vendor')->user());
            }

            if( Parents::ParentOrChild($vendor)->subscription->status=='expired'
            ||  Parents::ParentOrChild($vendor)->subscription->expires_at <= now() )
            {
                if( !is_null($vendor->parent_id) )
                {
                    return redirect()->route('subscriptions.no_for_childs', Parents::ParentOrChild($vendor));
                }

                return redirect()->route('subscriptions.renew', auth()->guard('vendor')->user());
            }

            if( Parents::ParentOrChild($vendor)->subscription->trial_taken!=='in_trial' )
            {
                $subscription_invoice = Parents::ParentOrChild($vendor)->subscription
                ->invoices()->orderBy('id', 'desc')->first();

                if(
                    is_null($subscription_invoice) ||
                    ( !is_null($subscription_invoice) &&
                        $subscription_invoice->status!=='paid' )
                    )
                {
                    if( !is_null($vendor->parent_id) )
                    {
                        return redirect()->route('subscriptions.no_for_childs', Parents::ParentOrChild($vendor));
                    }

                    return redirect()->route('subscriptions.pay');
                }
            }
        }

        return $next($request);
    }
}
