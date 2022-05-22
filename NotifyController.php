<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ranger\Notification\Notification;
use Ranger\Notification\NotificationController;


class NotifyController extends NotificationController
{

    public function generate($from_user, $to_user, $message)
    {
        $this->generateNotification($from_user, $to_user, $message);
    }

    public function getFromApi(Request $request) : array
    {
        $callback = $this->getNotification($request);
        return $callback;
    }

    public function getAllNotifications() : JsonResponse
    {
        $data = Notification::whereMonth(
            'created_at', '=', Carbon::now()->month
        )->get();
        $notifications['count'] = 0;
        foreach ($data as $key => $value) {
            if (in_array(Auth::user()->id, $value->to_user_id)) {
                $notifications['data'][$key]['uid'] = $value->uid;
                $notifications['data'][$key]['message'] = $value->message;
                $notifications['data'][$key]['read_status'] = $value->read_status;
                $notifications['data'][$key]['createdAt'] = Carbon::parse($value->created_at)->diffForHumans();
                $notifications['data'][$key]['created_at'] = $value->created_at;
                if ($value->executed == 0) {
                    $notifications['count']++;
                }
            }
        }

        usort($notifications['data'], function ($element1, $element2) {
            $datetime1 = strtotime($element1['created_at']);
            $datetime2 = strtotime($element2['created_at']);
            return $datetime2 - $datetime1;
        });

        return response()->json($notifications);
    }

    public function readNotifications(Request $request) : string
    {
        Notification::where('uid', $request->uid)->update([
            'read_status' => 1
        ]);

        return '';
    }

    public function executeAllNotifications(Request $request) : string
    {
        Notification::where('uid', $request->uid)->update([
            'read_status' => 1
        ]);

        $data = Notification::all();
        foreach ($data as $value) {
            if (in_array(Auth::user()->id, $value->to_user_id)) {
                Notification::where('id', '=', $value->id)->update([
                    'executed' => 1
                ]);
            }
        }

        return '';
    }

    public function readAllNotifications() : string
    {
        Notification::where('read_status', 0)->update([
            'read_status' => 1
        ]);

        return '';
    }

    public function showAllNotifications()
    {
        return view('notification.all_notification');
    }

}
