1. In *config/app.php* under *providers* add:<br />
*\Ranger\Notification\NotificationServiceProvider::class*

2. Keep "*src/views/notification*" folder in "*resources/views*"

3. Add routes:<br />
*Route::get('ajax/get-notifications', 'NotifyController@getAllNotifications');*<br />
*Route::post('ajax/read-notifications', 'NotifyController@readNotifications');*<br />
*Route::post('ajax/read-all-notifications', 'NotifyController@readAllNotifications');*<br />
*Route::post('ajax/execute-all-notifications', 'NotifyController@executeAllNotifications');*<br />
*Route::get('show-all-notification', 'NotifyController@showAllNotifications');*<br />
*Route::post('notify', 'NotifyController@getFromApi');*