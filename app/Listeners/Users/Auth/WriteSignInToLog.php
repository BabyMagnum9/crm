<?php

namespace App\Listeners\Users\Auth;

use App\Events\Users\Auth\SignIn;
use App\Models\Users\UserLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WriteSignInToLog
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SignIn  $event
     * @return void
     */
    public function handle(SignIn $event)
    {
        $user = $event->getUser();
        $log = new UserLog();
        $log->{'user_id'} = $user->getKey();
        $log->{'event_id'} = 1;
        $log->{'targetable_id'} = $user->getKey();
        $log->{'targetable_type'} = get_class($user);
        $log->{'ip'} = ip2long(request()->getClientIp());
        $log->save();
    }
}
