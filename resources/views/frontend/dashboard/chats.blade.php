@extends('frontend.layouts.index')

@section('title', empty(language('frontend.dashboard.title')) ? language('frontend.dashboard.name') :
    language('frontend.dashboard.title'))
@section('keywords', language('frontend.dashboard.keywords'))
@section('description', language('frontend.dashboard.description'))


@section('content')

    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                {{--                <div class="col-xl-3 col-md-4 theiaStickySidebar"> --}}
                {{--                    @if ($user->role_id == 3) --}}
                {{--                        @include('frontend.dashboard.employer._sidebar', ['user' => $user]) --}}
                {{--                    @elseif ($user->role_id == 4) --}}
                {{--                        @include('frontend.dashboard.freelancer._sidebar', ['user' => $user]) --}}
                {{--                    @endif --}}
                {{--                </div> --}}
                <div class="col-xl-12 col-md-12">


                    <div class="chat-window">

                        <!-- Chat Left -->
                        <div class="chat-cont-left">
                            {{--                            <div class="chat-header"> --}}
                            {{--                                <form class="chat-search"> --}}
                            {{--                                    <div class="input-group"> --}}
                            {{--                                        <div class="input-group-prepend"> --}}
                            {{--                                            <i class="fas fa-search icon-circle"></i> --}}
                            {{--                                        </div> --}}
                            {{--                                        <input type="text" class="form-control rounded-pill" placeholder="Search"> --}}
                            {{--                                    </div> --}}
                            {{--                                </form> --}}
                            {{--                            </div> --}}
                            <div class="chat-users-list">
                                <div class="chat-scroll">

                                    @if (!empty($chats))
                                        @foreach ($chats as $chat)
                                            <a href="javascript:void(0);"
                                                class="media d-flex chat-user_id_{{ $chat['users_id'] }} @if ($chat['total_messages'] > 0) read-chat active @endif"
                                                data-user_id="{{ $chat['users_id'] }}"
                                                data-role_id="{{ $chat['role_id'] }}"
                                                data-user_profile_photo="{{ $chat['users_profile_photo'] }}"
                                                data-user_profile_link="{{ route('frontend.profile.index', $chat['users_id']) }}"
                                                data-user_name="{{ $chat['users_name'] }}"
                                                data-chat_delete_link="{{ route('frontend.dashboard.delete-chat', $chat['id']) }}">
                                                <div class="media-img-wrap flex-shrink-0">
                                                    <div class="avatar avatar-away1">
                                                        <img src="{{ $chat['users_profile_photo'] }}"
                                                            alt="{{ $chat['users_name'] }}"
                                                            class="avatar-img rounded-circle">
                                                    </div>
                                                </div>
                                                <div class="media-body flex-grow-1">
                                                    <div>
                                                        <div class="user-name">{{ $chat['users_name'] }}</div>
                                                        @if ($chat['last_messages'] || $chat['last_file'])
                                                            <div class="user-last-chat">
                                                                @if ($chat['last_file'])
                                                                    <i class="fa fa-paperclip"></i>
                                                                @endif
                                                                @if ($chat['last_messages'])
                                                                    {{ $chat['last_messages'] }}
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <div class="last-chat-time block">{{ $chat['date'] }}</div>
                                                        <div class="badge bgg-yellow badge-pill @if ($chat['total_messages'] < 1) d-none @endif"
                                                            id="total_messages">{{ $chat['total_messages'] }}</div>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    @else
                                        {{ language('frontend.common.not_result') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- /Chat Left -->

                        <!-- Chat Right -->
                        <div class="chat-cont-right">
                            <div class="chat-header d-none">
                                <a id="back_user_list" href="javascript:void(0)" class="back-user-list">
                                    <i class="material-icons">chevron_left</i>
                                </a>
                                <div class="media d-flex">
                                    <div class="media-img-wrap flex-shrink-0">
                                        <div class="avatar avatar-online1">
                                            <img src="{{ asset('storage/no-photo.jpg') }}" alt=""
                                                class="avatar-img rounded-circle">
                                        </div>
                                    </div>
                                    <div class="media-body flex-grow-1">
                                        <div class="user-name"></div>
                                        <div class="user-status">
                                            @if (!empty($chat))
                                                <a href="{{ route('frontend.profile.index', $chat['users_id']) }}" target="_blank">{{ language('view profile') }}</a> 
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="chat-options">
                                    @if ($user->role_id < 3)
                                        <div class="dropdown dropleft">
                                            <button class="btn btn-link pe-0" type="button" id="dropdownMenuChat"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="material-icons">more_vert</i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuChat">
                                                <a class="dropdown-item dropdown_view_profile"
                                                    href="#">{{ language('View Profile') }}</a>
                                                <a class="dropdown-item dropdown_delete_chat" href="#chatDeleteModal"
                                                    data-bs-toggle="modal">{{ language('Delete Chat') }}</a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="chat-body">
                                <div>
                                    <ul class="list-unstyled chat-scroll" id="chat-feed">
                                        <li>{{ language('select user...') }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="chat-footer d-none">
                                <form action="{{ route('frontend.dashboard.addMessages') }}" method="POST"
                                    id="send_message">
                                    @csrf
                                    <input type="hidden" name="user_to" id="user_to" value="" />

                                    <ul id="file_names" class="d-none"></ul>

                                    <div id="file-queue"></div>

                                    <div class="input-group">
                                        <div class="avatar">
                                            <img src="{{ $user->profile_photo ? asset('storage/profile/' . $user->profile_photo) : asset('storage/no-photo.jpg') }}"
                                                alt="" class="avatar-img rounded-circle">
                                        </div>
                                        <input type="text" name="message" class="input-msg-send form-control"
                                            id="message" placeholder="{{ language('Reply...') }}" autocomplete="off">

                                        @if (auth()->user()->roles[0]->id == 4)
                                            <a data-bs-toggle="modal" href="#payment_url" class="btn-pay_url btn"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="{{ language('Send payment url') }}">
                                                <i class="fa fa-credit-card"></i>
                                            </a>
                                        @endif

                                        <div class="btn-file btn" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ language('Send file') }}">
                                            <i class="fa fa-paperclip"></i>
                                            <input type="file" name="file" multiple id="file">
                                        </div>
                                        <button id="submit_submit" type="submit"
                                            class="btn btn-primary msg-send-btn rounded-pill"><i
                                                class="fab fa-telegram-plane"></i></button>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <!-- /Chat Right -->

                    </div>


                </div>
            </div>

        </div>
    </div>
    <!-- /Page Content -->



    @if (auth()->user()->roles[0]->id == 4)
        <!-- The Modal -->
        <div class="modal fade" id="payment_url">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ language('Generate Payment Url') }}</h4>
                        <span class="modal-close">
                            <a href="#" data-bs-dismiss="modal" aria-label="{{ language('Close') }}">
                                <i class="far fa-times-circle orange-text"></i>
                            </a>
                        </span>
                    </div>
                    <div class="modal-body">
                        <div class="modal-info">

                            <div class="alert alert-danger" style="display: none">
                                <ul style="margin: 0 0 0 20px;">
                                    <li>{{ language('This user does not have an active project.') }}</li>
                                </ul>
                            </div>

                            <div class="modal_loader text-center pt-4 pb-4">
                                <i class="fa fa-spinner fa-spin fa-5x fa-fw"></i>
                            </div>

                            <form action="{{ route('frontend.dashboard.freelancer.project-proposals.store.ajax') }}"
                                method="POST" id="payment_url_generator_form">
                                @csrf

                                <div class="feedback-form">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label for="project_id">{{ language('Projects list') }}</label>
                                            <select class="form-control select" name="project_id" id="project_id"
                                                required="required" disabled>
                                                <option value="">{{ language('--Select Projects--') }}</option>
                                            </select>
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="price">{{ language('Your Price') }}</label>
                                            <input name="price" id="price" type="number" min="0"
                                                step="0.01" class="form-control"
                                                placeholder="{{ language('Your Price') }}" required="required"
                                                autocomplete="OFF" value="" disabled>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="hours">{{ language('Estimated Days') }}</label>
                                            <input name="hours" id="hours" type="number" min="0"
                                                step="1" class="form-control"
                                                placeholder="{{ language('Example: 11 Days') }}" required="required"
                                                autocomplete="OFF" value="" disabled>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <textarea name="letter" id="letter" rows="5" class="form-control"
                                                placeholder="{{ language('Cover Letter') }}" autocomplete="OFF" disabled></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 submit-section">
                                        <label class="custom_check">
                                            <input name="agree" id="agree" type="checkbox" name="select_time"
                                                required="required" autocomplete="OFF"
                                                @if (old('agree')) checked="checked" @endif>
                                            <span class="checkmark"></span> {{ language('I agree to the') }} <a
                                                href="/page/terms-conditions"
                                                target="_blank">{{ language('Terms And Conditions') }}</a>
                                        </label>
                                        @error('agree')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 submit-section text-end">
                                        <button class="btn btn-primary submit-btn" type="submit"
                                            disabled>{{ language('Generate') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <div class="mt-2 mb-4 payment_address">
                            {{ setting('address', true) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /The Modal -->
    @endif



    <!-- The hireModal -->
    <div class="modal fade" id="hire-project">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>{{ language('Hire Project') }}</h4>
                    <span class="modal-close">
                        <a href="#" data-bs-dismiss="modal" aria-label="{{ language('Close') }}">
                            <i class="far fa-times-circle orange-text"></i>
                        </a>
                    </span>
                </div>
                <div class="modal-body text-center">
                    <div class="port-title">
                        <h3>{{ language('Are you sure to choose this freelancer?') }}</h3>
                    </div>


                    <div class="p-3 pb-0 mb-4 text-left" style="background-color: #f7f7f9; text-align: left">
                        <div class="row">
                            <div class="col-md-6 form-group lapash_price">
                                <label for="price" class="d-block">{{ language('Price') }}</label>
                                <span></span>€
                            </div>
                            <div class="col-md-6 form-group lapash_hours">
                                <label for="hours" class="d-block">{{ language('Estimated') }}</label>
                                <span></span> {{ language('days') }}
                            </div>
                            <div class="col-md-12 form-group lapash_letter">
                                <label for="letter" class="d-block">{{ language('Letter') }}</label>
                                <span></span>
                            </div>
                        </div>
                    </div>

                    <div class="submit-section text-right">
                        <a data-bs-dismiss="modal"
                            class="btn btn-primary black-btn submit-btn">{{ language('Cancel') }}</a>
                        <a href="#" type="submit"
                            class="btn btn-primary submit-btn lapash_url">{{ language('Hire&Pay') }}</a>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <div class="mt-2 mb-4 payment_address text-center">
                        {{ setting('address', true) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /The hireModal -->



    @if ($user->role_id < 3)
        <!-- The Chat Delete Modal -->
        <div class="modal fade" id="chatDeleteModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>{{ language('Chat Delete') }}</h4>
                        <span class="modal-close">
                            <a href="#" data-bs-dismiss="modal" aria-label="{{ language('Close') }}">
                                <i class="far fa-times-circle orange-text"></i>
                            </a>
                        </span>
                    </div>
                    <div class="modal-body text-center">
                        <div class="port-title">
                            <h3>{{ language('Are you sure to delete this chat?') }}</h3>
                        </div>


                    </div>
                    <div class="modal-footer justify-content-center">

                        <div class="submit-section text-right">
                            <a data-bs-dismiss="modal"
                                class="btn btn-primary black-btn submit-btn">{{ language('Cancel') }}</a>
                            <a href="#" type="submit"
                                class="btn btn-primary submit-btn chat_delete_url">{{ language('Delete') }}</a>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!-- /The hireModal -->
    @endif

@endsection


@section('CSS')
    <style>
        label.error {
            color: red;
        }

        .form-control.error {
            border-color: red;
        }

        #agree-error {
            display: block;
        }

        .select2-container--default .select2-selection--multiple {
            margin-top: 6px;
            margin-bottom: 6px;
            border: none;
            border-radius: 12px;
            position: relative;
            display: block;
            padding: 0px;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border: none;
        }

        .select2-dropdown {
            margin-top: 5px;
            border-radius: 12px;
        }

        .select2-container--default.select2-container--open.select2-container--below .select2-selection--single,
        .select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple {
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        /* Style for Select2 dropdown scrollbar */
        .select2-container--default .select2-results>.select2-results__options::-webkit-scrollbar {
            width: 5px;
            /* Set the width of the scrollbar */
        }

        /* Track */
        .select2-container--default .select2-results>.select2-results__options::-webkit-scrollbar-track {
            background: #fff;
            /* Set the background color of the track */
        }

        /* Handle */
        .select2-container--default .select2-results>.select2-results__options::-webkit-scrollbar-thumb {
            background: #496af1;
            /* Set the color of the scrollbar handle */
            border-radius: 6px;
            /* Set the border radius of the handle */
        }

        /* Handle on hover */
        .select2-container--default .select2-results>.select2-results__options::-webkit-scrollbar-thumb:hover {
            background: #496af1;
            /* Set the color of the scrollbar handle on hover */
        }

        .select2-container--default .select2-results>.select2-results__options {
            margin-right: 10px;
        }

        .select2-container--open .select2-dropdown--below {
            border-top: 1px solid #aaa;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            padding: 5px;
        }

        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background: none;
            color: #496af1;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #151b2d;
            border: 1px solid #aaa;
            border-radius: 4px;
            box-sizing: border-box;
            display: inline-block;
            margin-left: 5px;
            margin-top: 5px;
            padding: 0;
            padding-left: 20px;
            position: relative;
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            background-color: transparent;
            border: none;
            color: #fff;
            cursor: pointer;
            font-size: 1em;
            font-weight: bold;
            padding: 0 4px;
            position: absolute;
            left: 0;
            top: 0;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
            cursor: default;
            padding-left: 2px;
            padding-right: 5px;
            color: #ffff;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover,
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:focus {
            background: none;
            color: #fff;
            outline: none;
        }
        span.select2.select2-container.select2-container--default.select2-container--below.select2-container--focus {
            border: none !important;  
        }
    </style>
@endsection

@section('JS')
    <script>
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });
        $(document).ready(function() {
            $('.mySelect').select2({
                width: '100%',
                dropdownCssClass: 'custom-select2-border'
            });
        });
    </script>
    <script>
        var prev_request = false;
        var xhr;
        var myTimeoutReq;

        var out = document.getElementById("chat-feed"); // outer container of messages
        var c = 0; // used only to make the fake messages different


        function getMessages(user_to, new_message = false) {
            if (prev_request == true) {
                xhr.abort();
            }

            xhr = $.ajax({
                url: '{{ route('frontend.dashboard.getMessages') }}',
                type: 'POST',
                data: {
                    user_to: user_to,
                    new_message: new_message,
                    _token: "{{ csrf_token() }}",
                },
                dataType: 'json',

                beforeSend: function(xhr) {
                    prev_request = true;
                },
                success: function(json) {
                    if (json.success == true) {

                        if (new_message == false) {
                            $('.chat-window .chat-cont-right .chat-body #chat-feed').empty();
                        }

                        $.each(json.data, function(inx, item) {

                            let html = '<li class="media ' + item.received_sent + ' d-flex">';
                            html += '   <div class="avatar flex-shrink-0">';
                            html += '       <img src="' + item.users_profile_photo + '" alt="' + item
                                .users_name + '" class="avatar-img rounded-circle">';
                            html += '   </div>';
                            html += '   <div class="media-body flex-grow-1">';
                            html += '       <div class="msg-box">';
                            html += '           <div>';

                            if (item.files) {
                                // html += '               <div class="row">';
                                $.each(item.files, function(inx, file) {
                                    // html += '                   <div class="col-md-3 mb-3">';
                                    html += '                       <a href="' + file.file +
                                        '" download="' + file.name + '" title="' + file.name +
                                        '" class="mb-2 mr-2" style="display:inline-block; margin: 0 2px;">';
                                    html +=
                                        '                           <div class="requirement-img" style="width:150px;">';
                                    html +=
                                        '                               <img class="img-fluid" alt="" src="{{ asset('frontend/assets/images/require-01.jpg') }}">';
                                    html +=
                                        '                               <div class="file-name">';
                                    html +=
                                        '                               <h4 style="overflow:hidden; height:17px; width:104px;">' +
                                        file.name + '</h4>';
                                    html +=
                                        '                               <h5 class="text-uppercase">' +
                                        file.extension + '</h5>';
                                    html += '                           </div>';
                                    html += '                       </div>';
                                    html += '                   </a>';
                                    // html += '               </div>';
                                });
                                // html += '               </div>';
                            } // if files

                            html += '               <p>' + item.message + '</p>';
                            html += '               <ul class="chat-msg-info">';
                            html += '                   <li>';
                            html += '                       <div class="chat-time">';
                            html += '                           <span>' + item.date + '</span>';
                            html += '                       </div>';
                            html += '                   </li>';
                            html += '               </ul>';
                            html += '           </div>';
                            html += '       </div>';
                            html += '   </div>';
                            html += '</li>';

                            $('.chat-window .chat-cont-right .chat-body #chat-feed').append(html);
                        });

                        $('.chat-window .chat-cont-right .chat-header').removeClass('d-none');
                        $('.chat-window .chat-cont-right .chat-body').removeClass('d-none');
                        $('.chat-window .chat-cont-right .chat-footer').removeClass('d-none');


                        //check current scroll position BEFORE message is appended to the container
                        var isScrolledToBottom = checkIfScrolledBottom();
                        // scroll to bottom if scroll position had been at bottom prior
                        scrollToBottom(isScrolledToBottom);

                        if (new_message == false) {
                            scrollToBottom(true);

                            $('#send_message #message').focus();

                            if (myTimeoutReq) {
                                clearTimeout(myTimeoutReq);
                            }
                        }

                        myTimeoutReq = setTimeout(function() {
                            getMessages(user_to, 1);
                        }, 2000);


                        $(document).trigger('formready');

                    } // if
                },
                complete: function(xhr) {
                    prev_request = false;
                }
            });
        }

        function addMessages(user_to, message, file = [], html = false) {
            $.ajax({
                url: '{{ route('frontend.dashboard.addMessages') }}',
                type: 'POST',
                data: {
                    user_to: user_to,
                    message: message,
                    file: file,
                    html: html,
                    _token: "{{ csrf_token() }}",
                },
                dataType: 'json',
                success: function(json) {
                    if (json.success == true) {

                        let html = '<li class="media ' + json.data.received_sent + ' d-flex">';
                        html += '   <div class="avatar flex-shrink-0">';
                        html += '       <img src="' + json.data.users_profile_photo + '" alt="' + json.data
                            .users_name + '" class="avatar-img rounded-circle">';
                        html += '   </div>';
                        html += '   <div class="media-body flex-grow-1">';
                        html += '       <div class="msg-box">';
                        html += '           <div>';

                        if (json.data.files) {
                            // html += '               <div class="row">';
                            $.each(json.data.files, function(inx, file) {
                                // html += '                   <div class="col-md-3 mb-3">';
                                html += '                       <a href="' + file.file +
                                    '" download="' + file.name + '" title="' + file.name +
                                    '" class="mb-2 mr-2" style="display:inline-block; margin: 0 2px;">';
                                html +=
                                    '                           <div class="requirement-img" style="width:150px;">';
                                html +=
                                    '                               <img class="img-fluid" alt="" src="{{ asset('frontend/assets/images/require-01.jpg') }}">';
                                html += '                               <div class="file-name">';
                                html +=
                                    '                               <h4 style="overflow:hidden; height:17px; width:104px;">' +
                                    file.name + '</h4>';
                                html += '                               <h5 class="text-uppercase">' +
                                    file.extension + '</h5>';
                                html += '                           </div>';
                                html += '                       </div>';
                                html += '                   </a>';
                                // html += '               </div>';
                            });
                            // html += '               </div>';
                        } // if files

                        html += '               <p>' + json.data.message + '</p>';
                        html += '               <ul class="chat-msg-info">';
                        html += '                   <li>';
                        html += '                       <div class="chat-time">';
                        html += '                           <span>' + json.data.date + '</span>';
                        html += '                       </div>';
                        html += '                   </li>';
                        html += '               </ul>';
                        html += '           </div>';
                        html += '       </div>';
                        html += '   </div>';
                        html += '</li>';

                        $('.chat-window .chat-cont-right .chat-body #chat-feed').append(html).fadeIn("slow");

                        $('#send_message').find('#message').prop("disabled", false);
                        $('#send_message').find('#file').prop("disabled", false);
                        $('#send_message').find('#submit_submit').prop("disabled", false);

                        $('#send_message').find('#message').val('');
                        $('#send_message').find('#file').val('');
                        $('#send_message').find('#message').focus();

                        $('#send_message').find('#file_names').empty();
                        $('#send_message').find('#file-queue').empty();

                        //check current scroll position BEFORE message is appended to the container
                        var isScrolledToBottom = checkIfScrolledBottom();

                        // scroll to bottom if scroll position had been at bottom prior
                        scrollToBottom(isScrolledToBottom);


                    } // if
                }
            });
        }

        function checkIfScrolledBottom() {
            // allow for 1px inaccuracy by adding 1
            return out.scrollHeight - out.clientHeight <= out.scrollTop + 160;
        }

        function scrollToBottom(scrollDown) {
            if (scrollDown)
                out.scrollTop = out.scrollHeight - out.clientHeight;
        }

        function checkNewMessages() {

            let user_to = [];

            $('.chat-window .chat-users-list a').each(function(index) {
                user_to[index] = $(this).data('user_id');
            });


            $.ajax({
                url: '{{ route('frontend.dashboard.getCount') }}',
                type: 'POST',
                data: {
                    user_to: user_to,
                    _token: "{{ csrf_token() }}",
                },
                dataType: 'json',

                success: function(json) {
                    if (json.success == true) {

                        let count_total = 0;

                        $.each(json.data, function(inx, item) {

                            count_total = count_total + item
                            .count; // TODO:: Yuxari teze gelen mesaji yigmaga fikirleshdim hele yazmadim.

                            $('.chat-users-list .chat-user_id_' + item.user + ' #total_messages').text(
                                item.count);
                            if (item.count > 0) {
                                $('.chat-users-list .chat-user_id_' + item.user).addClass('read-chat');
                                $('.chat-users-list .chat-user_id_' + item.user).addClass('active');
                                $('.chat-users-list .chat-user_id_' + item.user + ' #total_messages')
                                    .removeClass('d-none');
                            } else {
                                $('.chat-users-list .chat-user_id_' + item.user + ' #total_messages')
                                    .addClass('d-none');
                            }
                        });
                    }

                    setTimeout(function() {
                        checkNewMessages();
                    }, 2000);

                }
            });

        }

        setTimeout(function() {
            checkNewMessages();
        }, 2000);

        $('.chat-window .chat-users-list a').click(function(event) {
            event.preventDefault();

            let user_id = $(this).data('user_id');
            let user_profile_photo = $(this).data('user_profile_photo');
            let user_name = $(this).data('user_name');
            let user_profile_link = $(this).data('user_profile_link');
            let chat_delete_link = $(this).data('chat_delete_link');
            let user_role_id = $(this).data('role_id');
            $('.chat-window .chat-cont-right .chat-header').addClass('d-none');
            $('.chat-window .chat-cont-right .chat-body').addClass('d-none');
            $('.chat-window .chat-cont-right .chat-footer').addClass('d-none');

            $('.chat-window .chat-cont-right .chat-header .avatar-img').attr('src', user_profile_photo);
            $('.chat-window .chat-cont-right .chat-header .avatar-img').attr('alt', user_name);
            $('.chat-window .chat-cont-right .chat-header .user-name').text(user_name);
            // $('.chat-window .chat-cont-right .chat-header .user-status a').attr('href', '/profile/' + user_id);
            if (user_role_id > 2 || user_role_id == 0) {
                $('.chat-window .chat-cont-right .chat-header .user-status a').attr('href', user_profile_link);    
                $('.chat-window .chat-cont-right .chat-header .user-status a').css("display", "block");
            }
            else {
                $('.chat-window .chat-cont-right .chat-header .user-status a').css("display", "none");
            }

            @if ($user->role_id < 3)
                $('.chat-window .chat-cont-right .chat-header .chat-options .dropdown_view_profile').attr('href',
                    user_profile_link);
                $('#chatDeleteModal .chat_delete_url').attr('href', chat_delete_link);
            @endif

            // $('.chat-window .chat-cont-right .chat-footer .avatar-img').attr('src', user_profile_photo);
            // $('.chat-window .chat-cont-right .chat-footer .avatar-img').attr('alt', user_name);
            $('.chat-window .chat-cont-right .chat-footer #user_to').val(user_id);

            $('.chat-window .chat-cont-right .chat-body').removeClass('d-none');
            $('.chat-window .chat-cont-right .chat-body #chat-feed').html('<li>loading...</li>');

            $(this).find('#total_messages').addClass('d-none');
            $(this).removeClass('read-chat');
            $(this).removeClass('active');

            getMessages(user_id, 0);


        });

        $('#send_message').submit(function(event) {
            event.preventDefault();

            var user_to = $(this).find('#user_to').val();
            var message = $(this).find('#message').val();
            let file = [];

            $('#file_names li').each(function(index) {
                file[index] = $(this).text();
            });

            if (message != "" || file.length > 0) {
                addMessages(user_to, message, file);

                $(this).find('#message').prop("disabled", true);
                $(this).find('#file').prop("disabled", true);
                $(this).find('#submit_submit').prop("disabled", true);
            }

        });
    </script>

    <script>
        $.fileup({
            url: '{{ route('frontend.dashboard.fileUpload') }}',
            inputID: 'file',
            queueID: 'file-queue',
            autostart: true,
            extraFields: {
                _token: "{{ csrf_token() }}"
            },
            onSuccess: function(response, file_number, file) {

                $('#send_message').find('#file_names').append('<li class="file_name' + file_number + '">' + file
                    .name + '</li>');

                $('#send_message').find('#message').focus();

            },
            onError: function(event, file, file_number, response) {

                const response_json = JSON.parse(response);

                Snarl.addNotification({
                    title: response_json.message,
                    text: response_json.errors.filedata,
                    icon: '<i class="fa fa-times"></i>',
                });

            },
            onRemove: function(file, total) {
                $.ajax({
                    url: '{{ route('frontend.dashboard.fileDelete') }}',
                    type: 'POST',
                    data: {
                        file: file.file.name,
                        _token: "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    success: function(json) {
                        if (json.success == true) {

                            $('#send_message #file_names').find('.file_name' + file.file_number)
                                .remove();

                        } // if
                    }
                });
            },
        });
    </script>

    @if ($chat_open)
        <script>
            function chatOpen(user_id) {
                
                let user_profile_photo = $('.chat-window .chat-users-list .chat-user_id_' + user_id).data('user_profile_photo');
                let user_name = $('.chat-window .chat-users-list .chat-user_id_' + user_id).data('user_name');
                $('.chat-window .chat-cont-right .chat-header').addClass('d-none');
                $('.chat-window .chat-cont-right .chat-body').addClass('d-none');
                $('.chat-window .chat-cont-right .chat-footer').addClass('d-none');
               
                $('.chat-window .chat-cont-right .chat-header .avatar-img').attr('src', user_profile_photo);
                $('.chat-window .chat-cont-right .chat-header .avatar-img').attr('alt', user_name);
                $('.chat-window .chat-cont-right .chat-header .user-name').text(user_name);

                $('.chat-window .chat-cont-right .chat-footer .avatar-img').attr('src', "{{ $user->profile_photo ? asset('storage/profile/' . $user->profile_photo) : asset('storage/no-photo.jpg') }}");
                $('.chat-window .chat-cont-right .chat-footer .avatar-img').attr('alt', "{{$user->name}}");
                $('.chat-window .chat-cont-right .chat-footer #user_to').val(user_id);

                $('.chat-window .chat-cont-right .chat-body').removeClass('d-none');
                $('.chat-window .chat-cont-right .chat-body #chat-feed').html('<li>loading...</li>');

                $('.chat-window .chat-users-list .chat-user_id_' + user_id).find('#total_messages').addClass('d-none');
                $('.chat-window .chat-users-list .chat-user_id_' + user_id).removeClass('read-chat');
                $('.chat-window .chat-users-list .chat-user_id_' + user_id).removeClass('active');

                getMessages(user_id, 0);
            }

            chatOpen({{ $chat_open }});
        </script>
    @endif


    <script>
        $(document).bind('formready', function() {
            $('.chat-window .chat_hire_project').click(function(event) {


                console.log('lapash_price azad');

                event.preventDefault();

                let lapash_price = $(this).data('price');
                let lapash_hours = $(this).data('hours');
                let lapash_letter = $(this).data('letter');
                let lapash_url = $(this).data('url');

                $('#hire-project .lapash_price span').text(lapash_price);
                $('#hire-project .lapash_hours span').text(lapash_hours);
                $('#hire-project .lapash_letter span').text(lapash_letter);
                $('#hire-project .lapash_url').attr('href', lapash_url);

                console.log('lapash_price', lapash_price);

                $('#hire-project').modal('toggle');


            });
        });
    </script>

    @if (auth()->user()->roles[0]->id == 4)
        <script>
            function getProjectsList(employer_id) {

                $('#payment_url .modal_loader').show(0);
                $('#payment_url .alert-danger').hide(0);
                $('#payment_url_generator_form').hide(0);
                $('#payment_url').find('#project_id').prop("disabled", true);
                $('#payment_url').find('#price').prop("disabled", true);
                $('#payment_url').find('#hours').prop("disabled", true);
                $('#payment_url').find('#letter').prop("disabled", true);
                $('#payment_url').find('#agree').prop("disabled", true);
                $('#payment_url').find('.submit-btn').prop("disabled", true);

                $.ajax({
                    url: '{{ route('frontend.project.ajax-list') }}',
                    type: 'GET',
                    data: {
                        employer_id: employer_id,
                        _token: "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    success: function(json) {
                        $('#payment_url .modal_loader').hide(0);

                        if (json.success == true) {

                            $('#payment_url_generator_form').show(0);
                            $('#payment_url').find('#project_id').prop("disabled", false);
                            $('#payment_url').find('#price').prop("disabled", false);
                            $('#payment_url').find('#hours').prop("disabled", false);
                            $('#payment_url').find('#letter').prop("disabled", false);
                            $('#payment_url').find('#agree').prop("disabled", false);
                            $('#payment_url').find('.submit-btn').prop("disabled", false);

                            let html = '<option value="">{{ language('--Select Projects--') }}</option>';
                            $.each(json.data, function(inx, project) {

                                html += '<option value="' + project.id + '">' + project.name + '</option>';

                            });
                            $('#payment_url #project_id').html(html);

                        } else {
                            $('#payment_url .alert-danger').show(0);
                            $('#payment_url .alert-danger li').text(
                                '{{ language('This user does not have an active project.') }}');
                            $('#payment_url_generator_form').hide(0);
                        } // if
                    }
                });
            }


            $('.chat-window .btn-pay_url').click(function(event) {
                event.preventDefault();

                let employer_id = $('#user_to').val();
                getProjectsList(employer_id);

            });


            $('#payment_url_generator_form').submit(function(event) {
                event.preventDefault();


                let payment_url_generator_form = $("#payment_url_generator_form");
                payment_url_generator_form.validate();

                if (payment_url_generator_form.valid() == true) {

                    let project_id = $('#payment_url').find('#project_id').val();
                    let price = $('#payment_url').find('#price').val();
                    let hours = $('#payment_url').find('#hours').val();
                    let letter = $('#payment_url').find('#letter').val();
                    let agree = $('#payment_url').find('#agree').val();


                    $('#payment_url').find('#project_id').prop("disabled", true);
                    $('#payment_url').find('#price').prop("disabled", true);
                    $('#payment_url').find('#hours').prop("disabled", true);
                    $('#payment_url').find('#letter').prop("disabled", true);
                    $('#payment_url').find('#agree').prop("disabled", true);
                    $('#payment_url').find('.submit-btn').prop("disabled", true);

                    $.ajax({
                        url: '{{ route('frontend.dashboard.freelancer.project-proposals.store.ajax') }}',
                        type: 'POST',
                        data: {
                            project_id: project_id,
                            price: price,
                            hours: hours,
                            letter: letter,
                            agree: agree,
                            _token: "{{ csrf_token() }}",
                        },
                        dataType: 'json',
                        success: function(json) {
                            if (json.success == true) {

                                let user_to = $('#user_to').val();
                                let message =
                                    '{{ language('I sent you a payment link:') }} <a href="#hire-project" class="chat_hire_project" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ language('Click to payment') }}" data-price="' +
                                    price + '" data-hours="' + hours + '" data-letter="' + letter +
                                    '" data-url="' + json.data.project_url + '">' + json.data.project_url +
                                    '</a>';
                                let file = [];

                                addMessages(user_to, message, file, true);


                                $('#payment_url').modal('toggle');


                            } else {


                                $('#payment_url .alert-danger').show(0);
                                $('#payment_url .alert-danger li').text(json.message);

                            } // if
                        }
                    });
                }


            });
        </script>
        <script>
            $('#payment_url #project_id').select2('destroy');

            $('#payment_url_generator_form').validate({
                project_id: {
                    name: "required",
                },

                price: {
                    name: "required",
                },

                hours: {
                    name: "required",
                },

                agree: {
                    name: "required",
                }
            });
        </script>
    @endif
@endsection
