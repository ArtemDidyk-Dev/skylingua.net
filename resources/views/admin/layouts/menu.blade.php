<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
    <!--begin::Brand-->
    <div class="brand flex-column-auto" id="kt_brand">
        <!--begin::Logo-->
        <a href="{{ route('admin.index') }}" class="brand-logo">
            <img alt="Logo" src="/images/admin-logo.png" />
        </a>
        <!--end::Logo-->
        <!--begin::Toggle-->
        <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
            <span class="svg-icon svg-icon svg-icon-xl">
                <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                    height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <path
                            d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z"
                            fill="#000000" fill-rule="nonzero"
                            transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
                        <path
                            d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z"
                            fill="#000000" fill-rule="nonzero" opacity="0.3"
                            transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>
        </button>
        <!--end::Toolbar-->
    </div>
    <!--end::Brand-->
    <!--begin::Aside Menu-->
    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
        <!--begin::Menu Container-->
        <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
            data-menu-dropdown-timeout="500">
            <!--begin::Menu Nav-->
            <ul class="menu-nav">

                <!--  DASHBOARD  -->
                <li class="menu-item {{ Route::is('admin.index') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                    <a href="{{ route('admin.index') }}" class="menu-link">
                        <span class="svg-icon menu-icon">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24" />
                                    <path
                                        d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                        fill="#000000" fill-rule="nonzero" />
                                    <path
                                        d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                        fill="#000000" opacity="0.3" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>

                <!--  CUSTOM SOZ  -->
                <li class="menu-section">
                    <h4 class="menu-text">Navigation</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>


                <!--  Projects  -->
                <li class="menu-item menu-item-submenu {{ Route::is(['admin.project.index', 'admin.project.add', 'admin.project.edit', 'admin.project.search'])
                    ? 'menu-item-open'
                    : '' }}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">

                        <span
                            class="svg-icon menu-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Design/Substract.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M6,9 L6,15 C6,16.6568542 7.34314575,18 9,18 L15,18 L15,18.8181818 C15,20.2324881 14.2324881,21 12.8181818,21 L5.18181818,21 C3.76751186,21 3,20.2324881 3,18.8181818 L3,11.1818182 C3,9.76751186 3.76751186,9 5.18181818,9 L6,9 Z"
                                        fill="#000000" fill-rule="nonzero" />
                                    <path
                                        d="M10.1818182,4 L17.8181818,4 C19.2324881,4 20,4.76751186 20,6.18181818 L20,13.8181818 C20,15.2324881 19.2324881,16 17.8181818,16 L10.1818182,16 C8.76751186,16 8,15.2324881 8,13.8181818 L8,6.18181818 C8,4.76751186 8.76751186,4 10.1818182,4 Z"
                                        fill="#000000" opacity="0.3" />
                                </g>
                            </svg><!--end::Svg Icon--></span>



                        <span class="menu-text">Projects</span>
                        <i class="menu-arrow"></i>
                    </a>

                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">

                            <!--  PAGES  -->
                            <li class="menu-item {{ Route::is(['admin.project.index']) ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('admin.project.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Projects</span>
                                </a>
                            </li>

                            <!--  Add Page  -->
                            <li class="menu-item {{ Route::is(['admin.project.add']) ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('admin.project.add') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Add project</span>
                                </a>
                            </li>


                        </ul>
                    </div>

                </li>




                <!--  Pages  -->
                <li class="menu-item menu-item-submenu {{ Route::is(['admin.page.index', 'admin.page.add', 'admin.page.edit']) ? 'menu-item-open' : '' }}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">

                        <span
                            class="svg-icon menu-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Design/Substract.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M6,9 L6,15 C6,16.6568542 7.34314575,18 9,18 L15,18 L15,18.8181818 C15,20.2324881 14.2324881,21 12.8181818,21 L5.18181818,21 C3.76751186,21 3,20.2324881 3,18.8181818 L3,11.1818182 C3,9.76751186 3.76751186,9 5.18181818,9 L6,9 Z"
                                        fill="#000000" fill-rule="nonzero" />
                                    <path
                                        d="M10.1818182,4 L17.8181818,4 C19.2324881,4 20,4.76751186 20,6.18181818 L20,13.8181818 C20,15.2324881 19.2324881,16 17.8181818,16 L10.1818182,16 C8.76751186,16 8,15.2324881 8,13.8181818 L8,6.18181818 C8,4.76751186 8.76751186,4 10.1818182,4 Z"
                                        fill="#000000" opacity="0.3" />
                                </g>
                            </svg><!--end::Svg Icon--></span>



                        <span class="menu-text">Pages</span>
                        <i class="menu-arrow"></i>
                    </a>

                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">

                            <!--  PAGES  -->
                            <li class="menu-item {{ Route::is(['admin.page.index']) ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('admin.page.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Pages</span>
                                </a>
                            </li>

                            <!--  Add Page  -->
                            <li class="menu-item {{ Route::is(['admin.page.add']) ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('admin.page.add') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Add page</span>
                                </a>
                            </li>


                        </ul>
                    </div>

                </li>






                <!--  Blogs  -->
                <li class="menu-item menu-item-submenu {{ Route::is(['admin.blog.index', 'admin.blog.add', 'admin.blog.edit']) ? 'menu-item-open' : '' }}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">

                        <span
                            class="svg-icon menu-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Design/Substract.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M6,9 L6,15 C6,16.6568542 7.34314575,18 9,18 L15,18 L15,18.8181818 C15,20.2324881 14.2324881,21 12.8181818,21 L5.18181818,21 C3.76751186,21 3,20.2324881 3,18.8181818 L3,11.1818182 C3,9.76751186 3.76751186,9 5.18181818,9 L6,9 Z"
                                        fill="#000000" fill-rule="nonzero" />
                                    <path
                                        d="M10.1818182,4 L17.8181818,4 C19.2324881,4 20,4.76751186 20,6.18181818 L20,13.8181818 C20,15.2324881 19.2324881,16 17.8181818,16 L10.1818182,16 C8.76751186,16 8,15.2324881 8,13.8181818 L8,6.18181818 C8,4.76751186 8.76751186,4 10.1818182,4 Z"
                                        fill="#000000" opacity="0.3" />
                                </g>
                            </svg><!--end::Svg Icon--></span>



                        <span class="menu-text">Blogs</span>
                        <i class="menu-arrow"></i>
                    </a>

                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">

                            <!--  PAGES  -->
                            <li class="menu-item {{ Route::is(['admin.blog.index']) ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('admin.blog.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Blogs</span>
                                </a>
                            </li>

                            <!--  Add Blog  -->
                            <li class="menu-item {{ Route::is(['admin.blog.add']) ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('admin.blog.add') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Add Blog</span>
                                </a>
                            </li>


                        </ul>
                    </div>

                </li>





                <!--  Reviews  -->
                <li class="menu-item menu-item-submenu {{ Route::is(['admin.review.index', 'admin.review.add', 'admin.review.edit']) ? 'menu-item-open' : '' }}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">

                        <span
                            class="svg-icon menu-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Design/Substract.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M6,9 L6,15 C6,16.6568542 7.34314575,18 9,18 L15,18 L15,18.8181818 C15,20.2324881 14.2324881,21 12.8181818,21 L5.18181818,21 C3.76751186,21 3,20.2324881 3,18.8181818 L3,11.1818182 C3,9.76751186 3.76751186,9 5.18181818,9 L6,9 Z"
                                        fill="#000000" fill-rule="nonzero" />
                                    <path
                                        d="M10.1818182,4 L17.8181818,4 C19.2324881,4 20,4.76751186 20,6.18181818 L20,13.8181818 C20,15.2324881 19.2324881,16 17.8181818,16 L10.1818182,16 C8.76751186,16 8,15.2324881 8,13.8181818 L8,6.18181818 C8,4.76751186 8.76751186,4 10.1818182,4 Z"
                                        fill="#000000" opacity="0.3" />
                                </g>
                            </svg><!--end::Svg Icon--></span>



                        <span class="menu-text">Reviews</span>
                        <i class="menu-arrow"></i>
                    </a>

                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">

                            <!--  PAGES  -->
                            <li class="menu-item {{ Route::is(['admin.review.index']) ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('admin.review.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Reviews</span>
                                </a>
                            </li>

                            <!--  Add Review  -->
                            <li class="menu-item {{ Route::is(['admin.review.add']) ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('admin.review.add') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Add Review</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                </li>




                <!--  File Manager  -->
                <li class="menu-item {{ Route::is('admin.FileManager.index') ? 'menu-item-active' : '' }}"
                    aria-haspopup="true">
                    <a href="{{ route('admin.FileManager.index') }}" class="menu-link">

                        <span
                            class="svg-icon menu-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Files/Group-folders.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M4.5,21 L21.5,21 C22.3284271,21 23,20.3284271 23,19.5 L23,8.5 C23,7.67157288 22.3284271,7 21.5,7 L11,7 L8.43933983,4.43933983 C8.15803526,4.15803526 7.77650439,4 7.37867966,4 L4.5,4 C3.67157288,4 3,4.67157288 3,5.5 L3,19.5 C3,20.3284271 3.67157288,21 4.5,21 Z"
                                        fill="#000000" opacity="0.3" />
                                    <path
                                        d="M2.5,19 L19.5,19 C20.3284271,19 21,18.3284271 21,17.5 L21,6.5 C21,5.67157288 20.3284271,5 19.5,5 L9,5 L6.43933983,2.43933983 C6.15803526,2.15803526 5.77650439,2 5.37867966,2 L2.5,2 C1.67157288,2 1,2.67157288 1,3.5 L1,17.5 C1,18.3284271 1.67157288,19 2.5,19 Z"
                                        fill="#000000" />
                                </g>
                            </svg><!--end::Svg Icon--></span>


                        <span class="menu-text">File Manager</span>
                    </a>
                </li>



                <!--  Menus  -->
                <li class="menu-item menu-item-submenu {{ Route::is(['admin.menu.index', 'admin.menu.edit', 'admin.menu.add']) ? 'menu-item-open' : '' }}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">

                        <span
                            class="svg-icon menu-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Text/Menu.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <rect fill="#000000" x="4" y="5" width="16" height="3" rx="1.5" />
                                    <path
                                        d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L18.5,10 C19.3284271,10 20,10.6715729 20,11.5 C20,12.3284271 19.3284271,13 18.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z"
                                        fill="#000000" opacity="0.3" />
                                </g>
                            </svg><!--end::Svg Icon--></span>

                        <span class="menu-text">Menu</span>
                        <i class="menu-arrow"></i>
                    </a>

                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">

                            <!--  Menu  -->
                            <li class="menu-item {{ Route::is(['admin.menu.index', 'admin.menu.edit']) ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('admin.menu.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Menu</span>
                                </a>
                            </li>


                        </ul>
                    </div>

                </li>


                {{--                <!--  Slides  --> --}}
                {{--                <li class="menu-item menu-item-submenu {{Route::is( --}}
                {{--                                                        [ --}}
                {{--                                                        'admin.slide.index', --}}
                {{--                                                        'admin.slide.add', --}}
                {{--                                                        'admin.slide.edit', --}}
                {{--                                                        ] --}}
                {{--                                                        )? "menu-item-open":""}}" aria-haspopup="true" --}}
                {{--                    data-menu-toggle="hover"> --}}
                {{--                    <a href="javascript:;" class="menu-link menu-toggle"> --}}


                {{--       <span class="svg-icon menu-icon"> --}}
                {{--                                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Design/Image.svg--> --}}
                {{--                                            <svg --}}
                {{--                                                xmlns="http://www.w3.org/2000/svg" --}}
                {{--                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" --}}
                {{--                                                viewBox="0 0 24 24" version="1.1"> --}}
                {{--    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> --}}
                {{--        <polygon points="0 0 24 0 24 24 0 24"/> --}}
                {{--        <path --}}
                {{--            d="M6,5 L18,5 C19.6568542,5 21,6.34314575 21,8 L21,17 C21,18.6568542 19.6568542,20 18,20 L6,20 C4.34314575,20 3,18.6568542 3,17 L3,8 C3,6.34314575 4.34314575,5 6,5 Z M5,17 L14,17 L9.5,11 L5,17 Z M16,14 C17.6568542,14 19,12.6568542 19,11 C19,9.34314575 17.6568542,8 16,8 C14.3431458,8 13,9.34314575 13,11 C13,12.6568542 14.3431458,14 16,14 Z" --}}
                {{--            fill="#000000"/> --}}
                {{--    </g> --}}
                {{-- </svg><!--end::Svg Icon--></span> --}}

                {{--                        <span class="menu-text">Slides</span> --}}
                {{--                        <i class="menu-arrow"></i> --}}
                {{--                    </a> --}}

                {{--                    <div class="menu-submenu"> --}}
                {{--                        <i class="menu-arrow"></i> --}}
                {{--                        <ul class="menu-subnav"> --}}

                {{--                            <!--  Slides  --> --}}
                {{--                            <li class="menu-item {{Route::is([ --}}
                {{--                                                     'admin.slide.index', --}}
                {{--                                                    ])? "menu-item-active":""}}" aria-haspopup="true"> --}}
                {{--                                <a href="{{ route('admin.slide.index') }}" class="menu-link"> --}}
                {{--                                    <i class="menu-bullet menu-bullet-dot"> --}}
                {{--                                        <span></span> --}}
                {{--                                    </i> --}}
                {{--                                    <span class="menu-text">Slides</span> --}}
                {{--                                </a> --}}
                {{--                            </li> --}}

                {{--                            <!--  Add Slide  --> --}}
                {{--                            <li class="menu-item {{Route::is([ --}}
                {{--                                                     'admin.slide.add', --}}
                {{--                                                    ])? "menu-item-active":""}}" aria-haspopup="true"> --}}
                {{--                                <a href="{{ route('admin.slide.add') }}" class="menu-link"> --}}
                {{--                                    <i class="menu-bullet menu-bullet-dot"> --}}
                {{--                                        <span></span> --}}
                {{--                                    </i> --}}
                {{--                                    <span class="menu-text">Add Slide</span> --}}
                {{--                                </a> --}}
                {{--                            </li> --}}


                {{--                        </ul> --}}
                {{--                    </div> --}}

                {{--                </li> --}}





                <!--  Istifadechiler  -->
                <li class="menu-item menu-item-submenu {{ Route::is(['admin.user.index', 'admin.user.add', 'admin.user.edit']) ? 'menu-item-open' : '' }}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">



                        <span
                            class="svg-icon menu-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Address-card.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M6,2 L18,2 C19.6568542,2 21,3.34314575 21,5 L21,19 C21,20.6568542 19.6568542,22 18,22 L6,22 C4.34314575,22 3,20.6568542 3,19 L3,5 C3,3.34314575 4.34314575,2 6,2 Z M12,11 C13.1045695,11 14,10.1045695 14,9 C14,7.8954305 13.1045695,7 12,7 C10.8954305,7 10,7.8954305 10,9 C10,10.1045695 10.8954305,11 12,11 Z M7.00036205,16.4995035 C6.98863236,16.6619875 7.26484009,17 7.4041679,17 C11.463736,17 14.5228466,17 16.5815,17 C16.9988413,17 17.0053266,16.6221713 16.9988413,16.5 C16.8360465,13.4332455 14.6506758,12 11.9907452,12 C9.36772908,12 7.21569918,13.5165724 7.00036205,16.4995035 Z"
                                        fill="#000000" />
                                </g>
                            </svg><!--end::Svg Icon--></span>

                        <span class="menu-text">Users</span>
                        <i class="menu-arrow"></i>
                    </a>

                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">

                            <!--  Users  -->
                            <li class="menu-item {{ Route::is(['admin.user.index']) ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('admin.user.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Users</span>
                                </a>
                            </li>

                            <!--  Add User  -->
                            <li class="menu-item {{ Route::is(['admin.user.add']) ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('admin.user.add') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Add User</span>
                                </a>
                            </li>


                        </ul>
                    </div>

                </li>




                <!--  User Portfolio  -->
                <li class="menu-item menu-item-submenu {{ Route::is(['admin.portfolio.index', 'admin.portfolio.add', 'admin.portfolio.edit']) ? 'menu-item-open' : '' }}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">



                        <span
                            class="svg-icon menu-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Address-card.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M6,2 L18,2 C19.6568542,2 21,3.34314575 21,5 L21,19 C21,20.6568542 19.6568542,22 18,22 L6,22 C4.34314575,22 3,20.6568542 3,19 L3,5 C3,3.34314575 4.34314575,2 6,2 Z M12,11 C13.1045695,11 14,10.1045695 14,9 C14,7.8954305 13.1045695,7 12,7 C10.8954305,7 10,7.8954305 10,9 C10,10.1045695 10.8954305,11 12,11 Z M7.00036205,16.4995035 C6.98863236,16.6619875 7.26484009,17 7.4041679,17 C11.463736,17 14.5228466,17 16.5815,17 C16.9988413,17 17.0053266,16.6221713 16.9988413,16.5 C16.8360465,13.4332455 14.6506758,12 11.9907452,12 C9.36772908,12 7.21569918,13.5165724 7.00036205,16.4995035 Z"
                                        fill="#000000" />
                                </g>
                            </svg><!--end::Svg Icon--></span>

                        <span class="menu-text">Users portfolios</span>
                        <i class="menu-arrow"></i>
                    </a>

                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">

                            <!--  Portfolios  -->
                            <li class="menu-item {{ Route::is(['admin.portfolio.index']) ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('admin.portfolio.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Portfolios</span>
                                </a>
                            </li>

                            {{--                            <!--  Add Portfolio  --> --}}
                            {{--                            <li class="menu-item {{Route::is([ --}}
                            {{--                                                     'admin.portfolio.add', --}}
                            {{--                                                    ])? "menu-item-active":""}}" aria-haspopup="true"> --}}
                            {{--                                <a href="{{ route('admin.portfolio.add') }}" class="menu-link"> --}}
                            {{--                                    <i class="menu-bullet menu-bullet-dot"> --}}
                            {{--                                        <span></span> --}}
                            {{--                                    </i> --}}
                            {{--                                    <span class="menu-text">Add portfolio</span> --}}
                            {{--                                </a> --}}
                            {{--                            </li> --}}


                        </ul>
                    </div>

                </li>

                <li class="menu-item menu-item-submenu {{ Route::is(['admin.notification.index']) ? 'menu-item-open' : '' }}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span
                            class="svg-icon menu-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Address-card.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M6,2 L18,2 C19.6568542,2 21,3.34314575 21,5 L21,19 C21,20.6568542 19.6568542,22 18,22 L6,22 C4.34314575,22 3,20.6568542 3,19 L3,5 C3,3.34314575 4.34314575,2 6,2 Z M12,11 C13.1045695,11 14,10.1045695 14,9 C14,7.8954305 13.1045695,7 12,7 C10.8954305,7 10,7.8954305 10,9 C10,10.1045695 10.8954305,11 12,11 Z M7.00036205,16.4995035 C6.98863236,16.6619875 7.26484009,17 7.4041679,17 C11.463736,17 14.5228466,17 16.5815,17 C16.9988413,17 17.0053266,16.6221713 16.9988413,16.5 C16.8360465,13.4332455 14.6506758,12 11.9907452,12 C9.36772908,12 7.21569918,13.5165724 7.00036205,16.4995035 Z"
                                        fill="#000000" />
                                </g>
                            </svg><!--end::Svg Icon--></span>

                        <span class="menu-text">Notifications</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <!--  Users  -->
                            <li class="menu-item {{ Route::is(['admin.notification.index']) ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('admin.notification.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Notifications</span>
                                </a>
                            </li>

                        </ul>
                    </div>

                </li>







                <!--  Pays  -->
                <li class="menu-item menu-item-submenu {{ Route::is([
                    'admin.pay.index',
                    'admin.pay.search',
                    'admin.pay.searchID',
                    'admin.payout.index',
                    'admin.payout.search',
                    'admin.payout.searchID',
                ])
                    ? 'menu-item-open'
                    : '' }}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">



                        <span
                            class="svg-icon menu-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Address-card.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M6,2 L18,2 C19.6568542,2 21,3.34314575 21,5 L21,19 C21,20.6568542 19.6568542,22 18,22 L6,22 C4.34314575,22 3,20.6568542 3,19 L3,5 C3,3.34314575 4.34314575,2 6,2 Z M12,11 C13.1045695,11 14,10.1045695 14,9 C14,7.8954305 13.1045695,7 12,7 C10.8954305,7 10,7.8954305 10,9 C10,10.1045695 10.8954305,11 12,11 Z M7.00036205,16.4995035 C6.98863236,16.6619875 7.26484009,17 7.4041679,17 C11.463736,17 14.5228466,17 16.5815,17 C16.9988413,17 17.0053266,16.6221713 16.9988413,16.5 C16.8360465,13.4332455 14.6506758,12 11.9907452,12 C9.36772908,12 7.21569918,13.5165724 7.00036205,16.4995035 Z"
                                        fill="#000000" />
                                </g>
                            </svg><!--end::Svg Icon--></span>

                        <span class="menu-text">Pays</span>
                        <i class="menu-arrow"></i>
                    </a>

                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">

                            <!--  Pay  -->
                            <li class="menu-item {{ Route::is(['admin.pay.index', 'admin.pay.search', 'admin.pay.searchID']) ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('admin.pay.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Pays</span>
                                </a>
                            </li>

                            <!--  Pay Out -->
                            <li class="menu-item {{ Route::is(['admin.payout.index', 'admin.payout.search', 'admin.payout.searchID']) ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('admin.payout.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Pay Outs</span>
                                </a>
                            </li>


                        </ul>
                    </div>

                </li>






                <!--  User Categories  -->
                <li class="menu-item menu-item-submenu {{ Route::is(['admin.user_category.index', 'admin.user_category.add', 'admin.user_category.edit'])
                    ? 'menu-item-open'
                    : '' }}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">

                        <span
                            class="svg-icon menu-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Design/Substract.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M6,9 L6,15 C6,16.6568542 7.34314575,18 9,18 L15,18 L15,18.8181818 C15,20.2324881 14.2324881,21 12.8181818,21 L5.18181818,21 C3.76751186,21 3,20.2324881 3,18.8181818 L3,11.1818182 C3,9.76751186 3.76751186,9 5.18181818,9 L6,9 Z"
                                        fill="#000000" fill-rule="nonzero" />
                                    <path
                                        d="M10.1818182,4 L17.8181818,4 C19.2324881,4 20,4.76751186 20,6.18181818 L20,13.8181818 C20,15.2324881 19.2324881,16 17.8181818,16 L10.1818182,16 C8.76751186,16 8,15.2324881 8,13.8181818 L8,6.18181818 C8,4.76751186 8.76751186,4 10.1818182,4 Z"
                                        fill="#000000" opacity="0.3" />
                                </g>
                            </svg><!--end::Svg Icon--></span>



                        <span class="menu-text">User Categories</span>
                        <i class="menu-arrow"></i>
                    </a>

                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">

                            <!--  PAGES  -->
                            <li class="menu-item {{ Route::is(['admin.user_category.index']) ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('admin.user_category.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">User Categories</span>
                                </a>
                            </li>

                            <!--  Add User Category  -->
                            <li class="menu-item {{ Route::is(['admin.user_category.add']) ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('admin.user_category.add') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Add User Category</span>
                                </a>
                            </li>


                        </ul>
                    </div>

                </li>





                <!--  Countries  -->
                <li class="menu-item menu-item-submenu {{ Route::is(['admin.country.index', 'admin.country.add', 'admin.country.edit']) ? 'menu-item-open' : '' }}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">

                        <span
                            class="svg-icon menu-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Design/Substract.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M6,9 L6,15 C6,16.6568542 7.34314575,18 9,18 L15,18 L15,18.8181818 C15,20.2324881 14.2324881,21 12.8181818,21 L5.18181818,21 C3.76751186,21 3,20.2324881 3,18.8181818 L3,11.1818182 C3,9.76751186 3.76751186,9 5.18181818,9 L6,9 Z"
                                        fill="#000000" fill-rule="nonzero" />
                                    <path
                                        d="M10.1818182,4 L17.8181818,4 C19.2324881,4 20,4.76751186 20,6.18181818 L20,13.8181818 C20,15.2324881 19.2324881,16 17.8181818,16 L10.1818182,16 C8.76751186,16 8,15.2324881 8,13.8181818 L8,6.18181818 C8,4.76751186 8.76751186,4 10.1818182,4 Z"
                                        fill="#000000" opacity="0.3" />
                                </g>
                            </svg><!--end::Svg Icon--></span>



                        <span class="menu-text">Countries</span>
                        <i class="menu-arrow"></i>
                    </a>

                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">

                            <!--  PAGES  -->
                            <li class="menu-item {{ Route::is(['admin.country.index']) ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('admin.country.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Countries</span>
                                </a>
                            </li>

                            <!--  Add Country   -->
                            <li class="menu-item {{ Route::is(['admin.country.add']) ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('admin.country.add') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Add Country</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


                <!--  AYARLAR  -->
                <li class="menu-item menu-item-submenu {{ Route::is(['admin.logs', 'admin.setting.index']) ? 'menu-item-open' : '' }} "
                    aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <span class="svg-icon menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z"
                                        fill="#000000" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-text">Settings</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            {{--                            <li class="menu-item {{Route::is('admin.logs')? "menu-item-active":""}}" --}}
                            {{--                                aria-haspopup="true"> --}}
                            {{--                                <a href="{{ route('admin.logs') }}" class="menu-link"> --}}
                            {{--                                    <i class="menu-bullet menu-bullet-dot"> --}}
                            {{--                                        <span></span> --}}
                            {{--                                    </i> --}}
                            {{--                                    <span class="menu-text">Loglar</span> --}}
                            {{--                                </a> --}}
                            {{--                            </li> --}}
                            <li class="menu-item {{ Route::is('admin.setting.index') ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('admin.setting.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Settings</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <!--  DILLER  -->
                <li class="menu-item menu-item-submenu {{ Route::is([
                    'admin.language.index',
                    'admin.language.search',
                    'admin.languageGroup.index',
                    'admin.languageGroup.search',
                    'admin.languageGroup.groupDetailSearch',
                    'admin.languageGroup.detail',
                    'admin.languagePhrase.index',
                    'admin.languagePhrase.search',
                ])
                    ? 'menu-item-open'
                    : '' }}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M3.5,3 L5,3 L5,19.5 C5,20.3284271 4.32842712,21 3.5,21 L3.5,21 C2.67157288,21 2,20.3284271 2,19.5 L2,4.5 C2,3.67157288 2.67157288,3 3.5,3 Z"
                                        fill="#000000" />
                                    <path
                                        d="M6.99987583,2.99995344 L19.754647,2.99999303 C20.3069317,2.99999474 20.7546456,3.44771138 20.7546439,3.99999613 C20.7546431,4.24703684 20.6631995,4.48533385 20.497938,4.66895776 L17.5,8 L20.4979317,11.3310353 C20.8673908,11.7415453 20.8341123,12.3738351 20.4236023,12.7432941 C20.2399776,12.9085564 20.0016794,13 19.7546376,13 L6.99987583,13 L6.99987583,2.99995344 Z"
                                        fill="#000000" opacity="0.3" />
                                </g>
                            </svg><!--end::Svg Icon-->
                        </span>
                        <span class="menu-text">Languages</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <!--  Languages  -->

                            <li class="menu-item {{ Route::is(['admin.language.index', 'admin.language.search']) ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('admin.language.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Languages</span>
                                </a>
                            </li>
                            <!--  Dil Qrupları  -->
                            <li class="menu-item {{ Route::is([
                                'admin.languageGroup.index',
                                'admin.languageGroup.search',
                                'admin.languageGroup.groupDetailSearch',
                                'admin.languageGroup.detail',
                            ])
                                ? 'menu-item-active'
                                : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('admin.languageGroup.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Language groups</span>
                                </a>
                            </li>
                            <!--  Ifadələr  -->
                            <li class="menu-item {{ Route::is(['admin.languagePhrase.index', 'admin.languagePhrase.search']) ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('admin.languagePhrase.index') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Phrases</span>
                                </a>
                            </li>

                        </ul>
                    </div>

                </li>


            </ul>
            <!--end::Menu Nav-->
        </div>
        <!--end::Menu Container-->
    </div>
    <!--end::Aside Menu-->
</div>
