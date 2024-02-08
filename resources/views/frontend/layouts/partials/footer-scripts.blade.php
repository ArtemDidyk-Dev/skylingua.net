        <!-- jQuery -->
		<script src="{{ asset('frontend/assets/js/jquery-3.6.0.min.js')}}"></script>
        <script src="/js/nouislider.min.js"></script>
		<!-- Bootstrap Bundle JS -->
		<script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js')}}"></script>


        <!-- Global -->
        <script src="{{ asset('frontend/assets/plugins/global/plugins.bundle.js')}}"></script>

		<!-- Select2 JS -->
		<script src="{{ asset('frontend/assets/plugins/select2/js/select2.min.js')}}"></script>

		<!-- Datatables JS -->
		<script src="{{ asset('frontend/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
		<script src="{{ asset('frontend/assets/plugins/datatables/datatables.min.js')}}"></script>

        @if(Route::is(['frontend.dashboard.employer','frontend.dashboard.freelancer']))
		<!-- Chart JS -->
		<script src="{{ asset('frontend/assets/plugins/apexchart/apexcharts.min.js')}}"></script>
		<script src="{{ asset('frontend/assets/plugins/apexchart/chart-data.js')}}"></script>
		@endif

		<!-- Sticky Sidebar JS -->
        <script src="{{ asset('frontend/assets/plugins/theia-sticky-sidebar/ResizeSensor.js')}}"></script>
        <script src="{{ asset('frontend/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js')}}"></script>

        <!-- Fancybox JS -->
        <script src="{{ asset('frontend/assets/plugins/fancybox/jquery.fancybox.min.js')}}"></script>

        <!-- Query Validation -->
        <script src="{{ asset('frontend/assets/plugins/jquery-validation/dist/jquery.validate.min.js')}}"></script>
        <script src="{{ asset('frontend/assets/plugins/jquery-validation/dist/additional-methods.min.js')}}"></script>

        <!-- Datetimepicker JS -->
		<script src="{{ asset('frontend/assets/js/moment.min.js')}}"></script>
		<script src="{{ asset('frontend/assets/js/bootstrap-datetimepicker.min.js')}}"></script>

		<!-- Owl Carousel -->
		<script src="{{ asset('frontend/assets/js/owl.carousel.min.js')}}"></script>

		<!-- Select2 JS -->
		<script src="{{ asset('frontend/assets/plugins/select2/js/select2.min.js')}}"></script>

{{--		<!-- Range JS -->--}}
{{--		@if(Route::is(['developer','project']))--}}
{{--		<script src="{{ asset('frontend/assets/js/range.js')}}"></script>--}}
{{--		@endif--}}

		<!-- Slick JS -->
		<script src="{{ asset('frontend/assets/js/slick.js')}}"></script>

		<!-- Bootstrap Tagsinput JS -->
		<script src="{{ asset('frontend/assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js')}}"></script>

		<!-- Summernote JS -->
		<script src="{{ asset('frontend/assets/plugins/summernote/dist/summernote-lite.min.js')}}"></script>
		<!-- Aos -->
		<script src="{{ asset('frontend/assets/plugins/aos/aos.js')}}"></script>
		<!-- Custom JS -->
{{--		@if(Route::is(['user-account-details']))--}}
{{--		<script src="{{ asset('frontend/assets/js/chart.js')}}"></script>--}}
{{--		<script src="{{ asset('frontend/assets/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>--}}
{{--		@endif--}}
		<script src="{{ asset('frontend/assets/js/profile-settings.js')}}"></script>
		<script src="{{ asset('frontend/assets/js/script.js')}}"></script>

        @if(Route::is(['frontend.dashboard.chats']) || Route::is(['frontend.dashboard.employer.employerProjectAdd']) || Route::is(['frontend.dashboard.employer.employerProjectEdit']))
            <!-- FileUp -->
            <script src="{{ asset('frontend/assets/plugins/fileup/fileup.min.js')}}"></script>
        @endif

        <!-- Snarl -->
        <script src="{{ asset('frontend/assets/plugins/snarl/snarl.min.js')}}"></script>

        <!-- Jquery Cookie -->
        <script src="{{ asset('frontend/assets/plugins/jquery-cookie/jquery.cookie.js')}}"></script>

        <!--  CONTACT AJAX  -->
        <script src="{{ asset('frontend/assets/js/ajax-form.js') }}"></script>

        <!-- Toasty -->
        <script src="{{ asset('frontend/assets/plugins/toasty/js/toasty.min.js')}}"></script>
        <script>
            var toastOptions = {
                classname: "toast",
                autoClose: true,
                progressBar: true,
                enableSounds: true,
                sounds: {
                    info: "{{ asset('frontend/assets/plugins/toasty/sound/info/1.mp3')}}",
                    success: "{{ asset('frontend/assets/plugins/toasty/sound/success/3.mp3')}}",
                    warning: "{{ asset('frontend/assets/plugins/toasty/sound/warning/1.mp3')}}",
                    error: "{{ asset('frontend/assets/plugins/toasty/sound/error/1.mp3')}}",
                },
            };

            var toast = new Toasty(toastOptions);
            toast.configure(toastOptions);
        </script>

        @yield('JS')


        @if(auth()->check())
        <script>
            function  checkCountMessages() {

                $.ajax({
                    url: '{{ route('frontend.dashboard.getCountNewMessageAjax') }}',
                    type: 'POST',
                    data: {
                        user_to: {{ auth()->id() }},
                        _token: "{{ csrf_token() }}",
                    },
                    dataType: 'json',

                    success: function(json) {
                        if (json.success == true) {

                            $('.message-header span').text(json.data);
                            $('.message-sidebar').text(json.data);
                            if(json.data == 0) {
                                $('.message-header span').addClass('bg-grey');
                                $('.message-sidebar').hide();
                            } else {
                                let new_message = $.cookie('new_message');
                                if(new_message != json.data) {
                                    toast.success('You have a new message');
                                    console.log(json.data);
                                    $.cookie('new_message', json.data);
                                }
                                $('.message-header span').removeClass('bg-grey');
                                $('.message-sidebar').show();
                            }
                        }

                        setTimeout( function() {
                            checkCountMessages();
                        }, 2000);

                    }
                });

            }

            setTimeout( function() {
                checkCountMessages();
            }, 2000);
        </script>
        @endif


        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-NZWT83Q');</script>
        <!-- End Google Tag Manager -->

        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NZWT83Q" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
