<?php

namespace Ranger\Notification\Listeners;

use Ranger\Notification\Events\NotificationEvent;
use Ranger\Notification\Notification;
use Illuminate\Support\Facades\Log;

class NotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    private $data;
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NotificationEvent  $event
     * @return void
     */
    public function handle(NotificationEvent $event)
    {
        $this->data = $event->data;
        try {
            $notification = new Notification();
            $notification->uid = $this->data['uid'];
            $notification->from_user_id = $this->data['from_user_id'];
            $notification->to_user_id = $this->data['to_user_id'];
            $notification->message = $this->data['message'];
            $notification->created_at = $this->data['created_at'];

            $notification->save();
        } catch (\Exception $e){
            $context = [
                'get_file' => $e->getFile(),
                'get_line' => $e->getLine(),
            ];
            Log::error($e->getMessage(), $context);
        }

    }
}
