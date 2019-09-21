<?php

namespace App\Listeners;

use App\Events\UserAdded;
use App\Mail\NewUserCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendUserConfirmationEmail
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
     * @param  UserAdded  $event
     * @return void
     */
    public function handle(UserAdded $event)
    {
        \Mail::to($event->user->email)->send(
            new NewUserCreated($event->user)
        );
        //
    }
}
