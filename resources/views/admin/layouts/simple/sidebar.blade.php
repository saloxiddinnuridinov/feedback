<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper"><a href="#">
                <img class="img-fluid for-light"
                     src="{{asset('vendor_admin/images/logo/logo-en.png')}}"
                     alt="">
                <img class="img-fluid for-dark"
                     src="{{asset('vendor_admin/images/logo/logo-en.png')}}"
                     alt=""></a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
        </div>
        <div class="logo-icon-wrapper"><a href="#"><img class="img-fluid"
                                                        src="{{'vendor_admin/images/logo/photo.png'}}"
                                                        alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="#"><img class="img-fluid"
                                                          src="{{asset('vendor_admin/images/logo/photo.png')}}"
                                                          alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                                                              aria-hidden="true"></i></div>
                    </li>

                    @if(auth()->user()->role == 'admin')
                        <li class='sidebar-list'>
                            <label class='badge badge-light-info'></label><a class='sidebar-link sidebar-title'
                                                                             href='{{route('users.index')}}'>
                                <i class="fa fa-users"></i>
                                <span>Users</span></a>
                        </li>
                    @endif

                    <li class='sidebar-list'>
                        <label class='badge badge-light-info'></label><a class='sidebar-link sidebar-title'
                                                                         href='{{route('admin.messages.index')}}'>
                            <i class="fa fa-newspaper-o"></i>
                            <span>Messages</span></a>
                    </li>
{{--                    <li class='sidebar-list'>--}}
{{--                        <label class='badge badge-light-info'></label><a class='sidebar-link sidebar-title'--}}
{{--                                                                         href='{{route('admin.messages.answers')}}'>--}}
{{--                            <i class="fa fa-newspaper-o"></i>--}}
{{--                            <span>Answers</span></a>--}}
{{--                    </li>--}}

                    <!-- ADD_ITEM -->
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
