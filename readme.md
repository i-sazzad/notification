1. Run *composer require ranger/notification*

2. In *config/app.php* in *providers* add:<br />
*\Ranger\Notification\NotificationServiceProvider::class*

3. Go to *vendor/ranger/notification* folder

4. Keep "*src/views/notification*" folder in "*resources/views*"

5. Add *@include('notification.notification')* in the file where the bell will be shown

5. Add routes:<br />
*Route::get('ajax/get-notifications', 'NotifyController@getAllNotifications');*<br />
*Route::post('ajax/read-notifications', 'NotifyController@readNotifications');*<br />
*Route::post('ajax/read-all-notifications', 'NotifyController@readAllNotifications');*<br />
*Route::post('ajax/execute-all-notifications', 'NotifyController@executeAllNotifications');*<br />
*Route::get('show-all-notification', 'NotifyController@showAllNotifications');*<br />
*Route::post('notify', 'NotifyController@getFromApi');*