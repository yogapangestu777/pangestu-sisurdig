<div class="nk-header nk-header-fixed is-light">
    <div class="container-fluid">
        <div class="nk-header-wrap">
            <div class="nk-menu-trigger d-xl-none ms-n1">
                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em
                        class="icon ni ni-menu"></em></a>
            </div>
            <div class="nk-header-brand d-xl-none">
                <img class="logo-dark logo-img" src="{{ asset('assets/admin/images/logo/logo-sm.png') }}"
                    alt="logo-dark">
                </a>
            </div><!-- .nk-header-brand -->
            <div class="nk-header-tools">
                <ul class="nk-quick-nav">
                    <li class="dropdown notification-dropdown">
                        <a href="{{ route('homepage') }}" class="nk-quick-nav-icon">
                            <em class="icon ni ni-monitor"></em>
                        </a>
                    </li>
                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                            <div class="user-toggle">
                                <div class="user-avatar sm">
                                    <img src="{{ Auth::user()->attachment ? Storage::disk('s3')->temporaryUrl('avatars/' . Auth::user()->attachment->formatted_attachment, now()->addMinutes(5)) : '' }}"
                                        alt="image">
                                </div>
                                <div class="user-info d-none d-md-block">
                                    <div class="user-status">{{ Auth::user()->role->name }}</div>
                                    <div class="user-name dropdown-indicator">
                                        {{ Str::limit(Auth::user()->full_name, 13) }}
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1">
                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                <div class="user-card">
                                    <div class="user-info">
                                        <span class="lead-text">{{ Auth::user()->full_name }}</span>
                                        <span class="sub-text">{{ Auth::user()->localGovernmentAgency->name }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li>
                                        <a href="{{ route('setting.account') }}">
                                            <em class="icon ni ni-user-alt"></em>
                                            <span>Akun</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li>
                                        <a href="{{ route('logout') }}">
                                            <em class="icon ni ni-signout"></em>
                                            <span>Keluar</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li><!-- .dropdown -->
                </ul><!-- .nk-quick-nav -->
            </div><!-- .nk-header-tools -->
        </div><!-- .nk-header-wrap -->
    </div><!-- .container-fliud -->
</div>
