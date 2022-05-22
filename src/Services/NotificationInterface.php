<?php

namespace Ranger\Notification\Services;


interface NotificationInterface
{
    /**
     * @param int $from_user_id
     * @param string $to_user_id
     * @param string $message
     * @param array $data
     * @return mixed
     */
    public function setParamData(int $from_user_id, string $to_user_id, string $message, array $data);

    /**
     * @param $request
     * @param $data
     * @return mixed
     */
    public function setRequestData($request, array $data);

    /**
     * @param array $data
     * @return mixed
     */
    public function notify(array $data);

}
