<?php

namespace Imran\Notification;

use App\Http\Controllers\Controller;
use Imran\Notification\Services\NotificationService;
use Illuminate\Http\Request;


class NotificationController extends Controller
{
    private $data = [];

    /**
     * @param $from_user_id
     * @param $to_user_id
     * @param $message
     */
    public function generateNotification($from_user_id, $to_user_id, $message)
    {
        $notification = new NotificationService();
        $param_data = $notification->setDataForParam($from_user_id, $to_user_id, $message, $this->data);

        $notification->notify($param_data);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getNotification($request) : array
    {
        $notification = new NotificationService();
        $request_data = $notification->setDataForRequest($request, $this->data);

        $notification->notify($request_data);

        $data = [
            'status' => 'success',
            'status_code' => 200,
            'date' => date('Y-m-d')
        ];

        return $data;
    }

}
