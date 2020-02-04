<?php

namespace App\Listeners\Users\Auth;

use App\Events\Users\Auth\SignIn;
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


    }
}
