<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">


                <a href="{{ route('admin.index') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo1.png') }}" alt="" height="50">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo1.png') }}" alt="" height="50" >
                    </span>
                </a>
            </div>
            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect float-right" id="vertical-menu-btn">
                <i class="mdi mdi-menu"></i>
            </button>
            <div class="d-none d-lg-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" data-target="#search-wrap">
                    <a class="header-item" href="#">
                        <i class="mdi mdi-tumblr-reblog mr-2 font-size-16"></i>Panel Logları 
                    </a>
                </button>
            </div>
        </div>

        <div class="dropdown d-inline-block">
            <a href="/" target="_blank" class="btn btn-light   btn-rounded ml-1">
                <i class="fas fa-eye"></i>
            </a>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="mdi mdi-bell-outline"></i>
                <span class="badge badge-danger badge-pill" style="margin-left: -20px;">+99</span>
            </button>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
            aria-labelledby="page-header-notifications-dropdown">
            <div class="p-3">
               <h6 class="m-0">Notifications (258) </h6>
           </div>

           <div data-simplebar style="max-height: 230px;">
            <a href="" class="text-reset notification-item">
                <div class="media">
                    <div class="avatar-xs mr-3">
                        <span class="avatar-title bg-primary rounded-circle font-size-16">
                            <i class="mdi mdi-cart-outline"></i>
                        </span>
                    </div>
                    <div class="media-body">
                        <h6 class="mt-0 mb-1 font-size-15">Your order is placed</h6>
                        <div class="text-muted">
                            <p class="mb-1 font-size-12">Dummy text of the printing and typesetting industry.</p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="" class="text-reset notification-item">
                <div class="media">
                    <div class="avatar-xs mr-3">
                        <span class="avatar-title bg-warning rounded-circle font-size-16">
                            <i class="mdi mdi-message"></i>
                        </span>
                    </div>
                    <div class="media-body">
                        <h6 class="mt-0 mb-1 font-size-15">New Message received</h6>
                        <div class="text-muted">
                            <p class="mb-1 font-size-12">You have 87 unread messages</p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="" class="text-reset notification-item">
                <div class="media">
                    <div class="avatar-xs mr-3">
                        <span class="avatar-title bg-info rounded-circle font-size-16">
                            <i class="mdi mdi-help"></i>
                        </span>
                    </div>
                    <div class="media-body">
                        <h6 class="mt-0 mb-1 font-size-15">Your order is placed</h6>
                        <div class="text-muted">
                            <p class="mb-1 font-size-12">It is a long established fact that a reader will</p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="" class="text-reset notification-item">
                <div class="media">
                    <div class="avatar-xs mr-3">
                        <span class="avatar-title bg-primary rounded-circle font-size-16">
                            <i class="mdi mdi-cart-outline"></i>
                        </span>
                    </div>
                    <div class="media-body">
                        <h6 class="mt-0 mb-1 font-size-15">Your order is placed</h6>
                        <div class="text-muted">
                            <p class="mb-1 font-size-12">Dummy text of the printing and typesetting industry.</p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="" class="text-reset notification-item">
                <div class="media">
                    <div class="avatar-xs mr-3">
                        <span class="avatar-title bg-danger rounded-circle font-size-16">
                            <i class="mdi mdi-cart-outline"></i>
                        </span>
                    </div>
                    <div class="media-body">
                        <h6 class="mt-0 mb-1 font-size-15">Your order is placed</h6>
                        <div class="text-muted">
                            <p class="mb-1 font-size-12">Dummy text of the printing and typesetting industry.</p>
                        </div>
                    </div>
                </div>
            </a>

        </div>
        <div class="p-2 border-top">
            <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="javascript:void(0)">
                <i class="mdi mdi-arrow-right-circle mr-1"></i> View all
            </a>
        </div>
    </div>
</div>
<a href="{{ route('admin.oturumkapat') }}"> 

    <span class="d-xl-inline-block ml-1 btn btn-warning">Çıkış</span>
</a>
</div>

</header>