<style>
    .word-wrap {
        word-break: break-word;
        line-height: 2.5em;
        padding-right: 5px !important;
    }

    .notification-item {
        line-height: 12px !important;
    }
</style>


<div class="dropdown-menu notification-toggle" role="menu"
     aria-labelledby="notification-center">
    <!-- START Notification -->
    <div class="notification-panel">
        <!-- START Notification Body-->
        <div class="notification-body  scrollable">
            <div class="notification-container" style="cursor: pointer !important;">

            </div>
        </div>
        <!-- END Notification Body-->
        <!-- START Notification Footer-->
        <div class="notification-footer d-flex" id="readAll">
            <a href="{{url('/show-all-notification')}}" style="color:#0063c5 !important;">Show all</a>
            <a href="#" class="readAll ml-auto">Read all</a>
        </div>
        <!-- START Notification Footer-->
    </div>
    <!-- END Notification -->
</div>
@push('scripts')
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <!--start notification-->
    <script>
        $(document).on('click', '.dropdown-notifications .dropdown-menu', function (e) {
            e.stopPropagation();
        });

        $(document).on('click', '.unread', function (e) {
            let uid = $(this).attr('data-id');
            $.ajax({
                type: "post",
                url: "{{ url('ajax/read-notifications') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'uid': uid
                },
            }).done(function (response) {
                $('div[data-id=' + uid + ']').removeClass('unread')
            });
        });

        $(document).on('click', '.readAll', function (e) {
            $.ajax({
                type: "post",
                url: "{{ url('ajax/read-all-notifications') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
            }).done(function (response) {
                $('.notification-item').removeClass('unread')
            });
        });

        $(document).on('click', '#notification-center', function (e) {
            $.ajax({
                type: "post",
                url: "{{ url('ajax/execute-all-notifications') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
            }).done(function (response) {
                $('#notification-center').removeClass('fa fa-bell').addClass('fa fa-bell-o')
            });
        });

        $(function () {
            $.ajax({
                type: "get",
                url: "{{ url('ajax/get-notifications') }}",
            }).done(function (response) {
                let html = '';
                $.each(response.data, function (key, value) {
                    let status = (value.read_status === 0) ? 'unread' : '';
                    let message = value.message;
                    if (message.length > 56) {
                        message = value.message.slice(0, 108) + '...';
                    }
                    html += `
                        <div class="notification-item clearfix ${status}  border-bottom-light d-flex-column" data-id="${value.uid}">
                            <a class="text-dark word-wrap d-flex">
                               ${message}
                            </a>
                            <div class="pull-right" style="font-size: 11px;color: #727272;">
                                ${value.createdAt}
                            </div>
                        </div>


                `;
                });
                let count = $('.notif-count').text(response.count);
                $('.notification-center').attr('data-value', response.count);
                if (response.count > 0) {
                    count.show()
                } else {
                    $('#notification-center').removeClass('fa fa-bell').addClass('fa fa-bell-o')
                    count.hide()
                }
                $('.notification-container').append(html)
            });

            $('.notification-center').on('click', function () {
                $('.notif-count').text(0).hide();
                $('.notification-center').attr('data-value', 0);
            });

            var pusher = new Pusher('dbb3b83c00a62d9e2dd6', {
                cluster: 'ap2',
                encrypted: true
            });

// Subscribe to the channel we specified in our Laravel Event
            var channel = pusher.subscribe('notification-channel');

// Bind a function to a Event (the full Laravel class)
            channel.bind('notification-event', function (data) {
                let user_id = '{{Auth::user()->id}}';
                if ($.inArray(user_id, data.to_user_id.split(",")) !== -1) {
                    let message = data.message;
                    if (message.length > 56) {
                        message = data.message.slice(0, 108) + '...';
                    }
                    var newNotificationHtml = `
                        <div class="notification-item clearfix unread border-bottom-light d-flex-column" data-id="${data.uid}">
                            <a class="text-dark word-wrap d-flex">
                               ${message}
                            </a>
                             <div class="pull-right" style="font-size: 11px;color: #727272;">
                               ${data.time_difference}
                            </div>
                        </div>
                `;
                    // notifications.html(newNotificationHtml + existingNotifications);
                    var notificationsWrapper = $('.notification-center');
                    var data_value = parseInt(notificationsWrapper.attr("data-value"));
                    $('.notification-container').prepend(newNotificationHtml);

                    data_value += 1;
                    notificationsWrapper.attr('data-value', data_value);
                    notificationsWrapper.find('.notif-count').text(data_value).css('display', '');
                    $('#notification-center').removeClass('fa fa-bell-o').addClass('fa fa-bell')
                }
            });
        })
    </script>
    <!--end notification-->
@endpush

