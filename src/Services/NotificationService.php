<?php

namespace Ranger\Notification\Services;

use Ranger\Notification\Events\NotificationEvent;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Pusher\ApiErrorException;
use Pusher\PusherException;

class NotificationService extends NotificationAbstract
{
    private static $notification_channel = 'notification-channel';
    private static $notification_event = 'notification-event';

    /**
     * @param int $from_user_id
     * @param string $to_user_id
     * @param string $message
     * @param array $data
     * @return array
     */
    public function setDataForParam(int $from_user_id, string $to_user_id, string $message, array $data) : array
    {
        return parent::setParamData($from_user_id, $to_user_id, $message, $data);
    }

    /**
     * @param $request
     * @param array $data
     * @return array
     */
    public function setDataForRequest($request, array $data) : array
    {
        return parent::setRequestData($request, $data);
    }

    /**
     * @param array $data
     * @return mixed|void
     */
    public function notify(array $data) {
        $pusher = $this->setPusher();

        try{
            $pusher->trigger(self::$notification_channel, self::$notification_event, $data);
            //To listener
            event(new NotificationEvent(self::$notification_channel, self::$notification_event, $data));

        }catch (GuzzleException $e) {
            $context = [
                'get_file' => $e->getFile(),
                'get_line' => $e->getLine(),
            ];
            Log::error($e->getMessage(), $context);
        } catch (ApiErrorException $e) {
            $context = [
                'get_file' => $e->getFile(),
                'get_line' => $e->getLine(),
            ];
            Log::error($e->getMessage(), $context);
        } catch (PusherException $e) {
            $context = [
                'get_file' => $e->getFile(),
                'get_line' => $e->getLine(),
            ];
            Log::error($e->getMessage(), $context);
        }

    }
}
