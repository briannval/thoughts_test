<?php

namespace App\Listeners;

use App\Events\ThoughtCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Notifications\NewThought;

class SendThoughtCreatedNotifications implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ThoughtCreated $event): void
    {
        foreach (User::whereNot('id', $event->thought->user_id)->cursor() as $user) {
            $user->notify(new NewThought($event->thought));
        } // send to all except author
    }
}
