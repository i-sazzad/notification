1. in config/app under providers: \Ranger\Notification\NotificationServiceProvider::class

2. keep notification folder in resources/views

3. add routes:
Route::get('ajax/get-notifications', 'NotifyController@getAllNotifications');
Route::post('ajax/read-notifications', 'NotifyController@readNotifications');
Route::post('ajax/read-all-notifications', 'NotifyController@readAllNotifications');
Route::post('ajax/execute-all-notifications', 'NotifyController@executeAllNotifications');
Route::get('show-all-notification', 'NotifyController@showAllNotifications');
Route::post('notify', 'NotifyController@getFromApi');