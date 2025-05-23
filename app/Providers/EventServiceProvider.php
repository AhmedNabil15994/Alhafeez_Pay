<?php

namespace App\Providers;

use App\Observers\InvoiceObserver;
use Illuminate\Support\Facades\Event;
use App\Observers\TransactionObserver;
use Illuminate\Auth\Events\Registered;
use Modules\Vendor\Listeners\VendorRegisteredSubscriber;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    // protected $listen = [
    //     Registered::class => [
    //         SendEmailVerificationNotification::class,
    //     ],
    // ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }
}
