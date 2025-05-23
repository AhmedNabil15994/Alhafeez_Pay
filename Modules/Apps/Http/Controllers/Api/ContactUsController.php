<?php

namespace Modules\Apps\Http\Controllers\Api;

use Notification;
use Illuminate\Http\Request;
use Modules\Apps\Entities\ContactUs;
use Modules\Apps\Http\Requests\Api\ContactUsRequest;
use Modules\Apps\Notifications\Api\ContactUsNotification;

class ContactUsController extends ApiController
{
    public function send(ContactUsRequest $request)
    {
        ContactUs::create($request->validated());
        Notification::route('mail', setting('contact_us','email'))
        ->notify((new ContactUsNotification($request))->locale(locale()));

        return $this->response([]);
    }
}
