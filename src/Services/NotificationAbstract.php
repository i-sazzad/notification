<?php

namespace Imran\Notification\Services;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;
use Pusher\PusherException;

abstract class NotificationAbstract implements NotificationInterface
{
    private $pusher;

    /**
     * @return bool|Pusher
     */
    protected function setPusher()
    {
        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true
        );
        try {
            $this->pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );

            return $this->pusher;

        } catch (PusherException $e) {
            $context = [
                'get_file' => $e->getFile(),
                'get_line' => $e->getLine(),
            ];
            Log::error($e->getMessage(), $context);
            return false;
        }
    }

    /**
     * @param int $from_user_id
     * @param string $to_user_id
     * @param string $message
     * @param array $data
     * @return array
     */
    public function setParamData(int $from_user_id, string $to_user_id, string $message, array $data) : array
    {
        $data['uid'] = uniqid();
        $data['from_user_id'] = $from_user_id;
        $data['to_user_id'] = $to_user_id;
        $data['message'] = $message;
        $data['created_at'] = date('Y-m-d H:m:s');
        $data['time_difference'] = Carbon::parse(date('Y-m-d H:m:s'))->diffForHumans();

        return $data;
    }

    /**
     * @param $request
     * @param array $data
     * @return array
     */
    public function setRequestData($request, array $data) : array
    {
        $data['uid'] = uniqid();
        $data['from_user_id'] = $request->from_user;
        $data['to_user_id'] = $request->to_user;
        $data['message'] = $request->message;
        $data['created_at'] = date('Y-m-d H:m:s');
        $data['time_difference'] = Carbon::parse(date('Y-m-d H:m:s'))->diffForHumans();

        return $data;
    }

}
