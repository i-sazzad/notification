1. In composer.json: 
"psr-4": {
            "App\\": "app/",
            "Imran\\Notification\\": "vendor/imran/notification/src/"
        },
		
2. in config/app under providers: \Imran\Notification\NotificationServiceProvider::class

3. keep notification folder in resources/views

4. add routes:
Route::get('ajax/get-notifications', 'NotifyController@getAllNotifications');
Route::post('ajax/read-notifications', 'NotifyController@readNotifications');
Route::post('ajax/read-all-notifications', 'NotifyController@readAllNotifications');
Route::post('ajax/execute-all-notifications', 'NotifyController@executeAllNotifications');
Route::get('show-all-notification', 'NotifyController@showAllNotifications');
Route::post('notify', 'NotifyController@getFromApi');