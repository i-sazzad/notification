@extends('layout.frontend')
@section('content')
    <style>
        .card-header a:not(.btn) {
            color: #000000 !important;
            opacity: .8 !important;
        }
    </style>
    <div class="content sm-gutter">
        <!-- START CONTAINER FLUID -->
        <div class="container-fluid padding-25">
            <div class="card  bg-white">
                <div class="card-block">
                    <div class="table-responsive">
                        <!-- START card -->
                        <div class="card card-transparent">
                            <div class="card-title btn_left p-l-20">
                                <h5 class="m-b-0">All Notification</h5>
                            </div>
                            <span class="border-bottom"></span>
                            <div class="card-header ">
                                <!-- START Notification Body-->
                                <div class="notification-container" style="cursor: pointer !important;">

                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
