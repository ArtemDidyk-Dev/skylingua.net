@extends('frontend.layouts.index')

@section('title',empty(language('frontend.dashboard.title')) ? language('frontend.dashboard.name') : language('frontend.dashboard.title'))
@section('keywords', language('frontend.dashboard.keywords') )
@section('description',language('frontend.dashboard.description') )


@section('content')


    <!-- Page Content -->
    <div class="content ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-md-4 theiaStickySidebar">
                    @if ($user->role_id == 3)
                        @include('frontend.dashboard.employer._sidebar', ['user' => $user])
                    @elseif ($user->role_id == 4)
                        @include('frontend.dashboard.freelancer._sidebar', ['user' => $user])
                    @endif
                </div>
                <div class="col-xl-9 col-md-8">

                    <!-- project list -->
                    <div class="my-projects-view favourite-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="transaction-table card">
                                    <div class="card-header">
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col">
                                                <h5 class="card-title">{{ language('Notifications') }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="notification-container">
                                            <div class="notification-item-header">
                                                <div class="notification-item-header-left">
                                                    <!--  SELECT ALL START  -->
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="selectAllNotifications">
                                                        <label class="form-check-label" for="selectAllNotifications">
                                                            {{ language('Select All') }}
                                                        </label>
                                                    </div>
                                                    <!--  SELECT ALL END  -->
                                                </div>
                                                <div class="notification-item-header-right">


                                                    <div class="dropdown">
                                                        <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                            {{ language('Settings') }}
                                                        </a>

                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="">

                                                            <!--  DELETE BTN START  -->
                                                            <li id="notificationDelete">
                                                                <i class="fas fa-trash-alt"></i>
                                                                <span>{{ language('Delete') }}</span>
                                                            </li>
                                                            <!--  DELETE BTN END  -->

                                                            <!--  MARK AS READ BTN START  -->
                                                            <li id="notificationMarkAsRead">
                                                                <i class="fas fa-envelope-open"></i>
                                                                <span>{{ language('Mark As Read') }}</span>
                                                            </li>
                                                            <!--  MARK AS READ BTN END  -->

                                                            <!--  MARK AS UNREAD BTN START  -->
                                                            <li id="notificationMarkAsUnread">
                                                                <i class="fas fa-envelope"></i>
                                                                <span>{{ language('Mark As Unread') }}</span>
                                                            </li>
                                                            <!--  MARK AS UNREAD BTN END  -->

                                                            <!-- DELETE ALL NOTIFICATIONS START -->
                                                            <li id="allNotificationsDelete">
                                                                <i class="fas fa-trash-alt"></i>
                                                                <span>{{ language('Delete All Notifications') }}</span>
                                                            </li>
                                                            <!-- DELETE ALL NOTIFICATIONS END -->

                                                            <!-- Mark as read all notifications START -->
                                                            <li id="allNotificationsMarkAsRead">
                                                                <i class="fas fa-envelope-open"></i>
                                                                <span>{{ language('Mark As Read All Notifications') }}</span>
                                                            </li>
                                                            <!-- Mark as read all notifications END -->

                                                        </ul>
                                                    </div>


                                                </div>
                                            </div>
                                            <div class="notification-item-body">

                                                @if($notifications->total() > 0)
                                                    @foreach($notifications as  $notification)
                                                        <!--  NOTIFICATION {{ $notification->id }} START -->
                                                        <div class="notification-line @if($notification->status == 0) active @endif">
                                                            <div class="notification-item-body-left">
                                                                <!--  SELECT ALL START  -->
                                                                <div class="form-check">
                                                                    <input class="form-check-input selectNotification" type="checkbox" data-notificationID="{{ $notification->id }}"  >
                                                                </div>
                                                                <!--  SELECT ALL END  -->
                                                            </div>
                                                            <div class="notification-item-body-right">
                                                                <div class="notification-content">{{ $notification->notification_id }} - {{ $notification->text }}</div>
                                                                <div class="notification-date"><i class="far fa-clock"></i><span>{{ $notification->created_at }}</span></div>
                                                            </div>
                                                        </div>
                                                        <!--  NOTIFICATION 1 END -->
                                                    @endforeach
                                                @else
                                                    {{ language('frontend.common.not_result') }}
                                                @endif


                                            </div>


                                        </div>
                                    </div>


                                    <!--  PAGINATION START  -->
                                    <div class="card-footer d-flex justify-content-end">
                                        {{ $notifications->appends(['search' => isset($searchText) ? $searchText : null])
    ->render('vendor.pagination.frontend.dashboard-pagination') }}
                                    </div>
                                    <!--  PAGINATION END  -->


                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- project list -->

                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

@endsection


@section('CSS')
@endsection

@section('JS')
    <script>
        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /*   DELETE NOTIFICATION START   */
            $(document).on('click','#notificationDelete',function (){

                let notificationsID = getNotificationsID();

                if (notificationsID == '') {
                    alert('{{ language('frontend.notification.pleace_select') }}')
                } else {

                    $.ajax({
                        url: '{{ route('frontend.notification.delete') }}',
                        type: 'POST',
                        data: {data: notificationsID},
                        dataType: 'JSON',
                        success: function (data) {
                            if (data.success == true) {
                                window.location.href = "{{ route('frontend.cabinet.notification') }}";
                            } else {
                                alert('{{ language('frontend.notification.error_system_warning') }}')
                            }
                        }
                    });

                }

            });
            /*   DELETE NOTIFICATION END   */

            /*   MARK AS READ NOTIFICATION START   */
            $(document).on('click','#notificationMarkAsRead',function (){

                let notificationsID = getNotificationsID();

                if (notificationsID == '') {
                    alert('{{ language('frontend.notification.pleace_select') }}')
                } else {

                    $.ajax({
                        url: '{{ route('frontend.notification.mark') }}',
                        type: 'POST',
                        data: {
                            action: 1,
                            data: notificationsID
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            if (data.success == true) {
                                markAsReadOrUnread();
                                headerNotificationCount(data.count);
                            } else {
                                alert('{{ language('frontend.notification.error_system_warning') }}')
                            }
                        }
                    });

                }

            });
            /*   MARK AS READ NOTIFICATION END   */


            /*   MARK AS UNREAD NOTIFICATION START   */
            $(document).on('click','#notificationMarkAsUnread',function (){

                let notificationsID = getNotificationsID();

                if (notificationsID == '') {
                    alert('{{ language('frontend.notification.pleace_select') }}')
                }

                $.ajax({
                    url: '{{ route('frontend.notification.mark') }}',
                    type: 'POST',
                    data: {
                        action: 0,
                        data: notificationsID
                    },
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.success == true) {
                            markAsReadOrUnread(false);
                            headerNotificationCount(data.count);
                        } else {
                            alert('{{ language('frontend.notification.error_system_warning') }}')
                        }
                    }
                });

            });
            /*   MARK AS UNREAD NOTIFICATION END   */


            /*   ALL NOTIFICATIONS DELETE START   */
            $(document).on('click','#allNotificationsDelete',function (){

                $.ajax({
                    url: '{{ route('frontend.notification.delete') }}',
                    type: 'POST',
                    data: {

                    },
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.success == true) {
                            window.location.href = "{{ route('frontend.cabinet.notification') }}";
                        } else {
                            alert('{{ language('frontend.notification.error_system_warning') }}')
                        }
                    }
                });

            });
            /*   ALL NOTIFICATIONS DELETE END   */


            /*   MARK AS READ ALL NOTIFICATIONS START   */
            $(document).on('click','#allNotificationsMarkAsRead',function (){

                $.ajax({
                    url: '{{ route('frontend.notification.mark') }}',
                    type: 'POST',
                    data: {
                        action: 1
                    },
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.success == true) {
                            markAsReadAll();
                            headerNotificationCount(0);
                        } else {
                            alert('{{ language('frontend.notification.error_system_warning') }}');
                        }
                    }
                });

            });
            /*   MARK AS READ ALL NOTIFICATIONS END   */



            /*  GET NOTIFICATIONS ID FUNCTION START   */
            function getNotificationsID(){
                let notificationID = [];
                $('.selectNotification:checked').each(function (index,data){
                    notificationID.push(data.getAttribute('data-notificationID'));
                });
                return notificationID;
            }
            /*  GET NOTIFICATIONS ID FUNCTION END   */


            /*   HEADER NOTIFICATION COUNT FUNCTION START   */
            function headerNotificationCount(count = 0){
                $('header .notification-header span').text(count);
                if (count == 0) {
                    $('header .notification-header span').addClass('bg-grey');
                } else {
                    $('header .notification-header span').removeClass('bg-grey');
                }
            }
            /*   HEADER NOTIFICATION COUNT FUNCTION END   */

            /*   MARK AS READ OR UNREAD FUNCTION START   */
            function markAsReadOrUnread(active = true){

                if(active){
                    $('.selectNotification:checked').each(function (index,data){
                        let element = $(data);
                        element.closest('.notification-line').removeClass('active');
                    });

                }else {
                    $('.selectNotification:checked').each(function (index,data){
                        let element = $(data);
                        element.closest('.notification-line').addClass('active');
                    });
                }

                $('#selectAllNotifications').prop('checked',false);

                $('.selectNotification').each(function (index,data){
                    let element = $(data);
                    element.prop('checked',false);
                })

            }
            /*   MARK AS READ OR UNREAD FUNCTION END   */


            /*   MARK AS READ ALL FUNCTION START   */
            function markAsReadAll(){

                $('.selectNotification').each(function (index,data){
                    let element = $(data);
                    element.closest('.notification-line').removeClass('active');
                });

                $('#selectAllNotifications').prop('checked',false);

                $('.selectNotification').each(function (index,data){
                    let element = $(data);
                    element.prop('checked',false);
                })

            }
            /*   MARK AS READ ALL FUNCTION END   */

            /*   SELECT ALL NOTIFICATIONS START   */
            $(document).on('click','#selectAllNotifications',function (){
                let notifications = $('.selectNotification');

                if($(this).is(':checked')){
                    notifications.each(function (index,data){
                        let element = $(data);
                        element.prop('checked','checked');
                    })
                }else {
                    notifications.each(function (index,data){
                        let element = $(data);
                        element.prop('checked',false);
                    })
                }

            });
            /*   SELECT ALL NOTIFICATIONS END   */

            /*   SELECT NOTIFICATION START   */
            $(document).on('click','.selectNotification',function (){

                let selectNotification = $('.selectNotification').length;
                let checkCheckbox = $('.selectNotification[type=checkbox]:checked').length;

                if(selectNotification == checkCheckbox){
                    $('#selectAllNotifications').prop('checked','checked');
                }else {
                    $('#selectAllNotifications').prop('checked',false);
                }

            });
            /*   SELECT NOTIFICATION END   */

        });
    </script>
@endsection

