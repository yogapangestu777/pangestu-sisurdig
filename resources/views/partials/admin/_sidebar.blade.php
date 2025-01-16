<div class="nk-sidebar nk-sidebar-fixed " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="html/index.html" class="logo-link nk-sidebar-logo">
                <img class="logo-dark logo-img" src="{{ setting()->logo }}" alt="logo">
            </a>
        </div>
        <div class="nk-menu-trigger me-n2">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em
                    class="icon ni ni-arrow-left"></em></a>
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element">
        <div class="nk-sidebar-body" data-simplebar>
            <div class="nk-sidebar-content">
                <div class="nk-sidebar-menu">
                    <ul class="nk-menu">
                        <li class="nk-menu-heading">
                            <h6 class="overline-title text-primary-alt">Ringkasan</h6>
                        </li><!-- .nk-menu-item -->
                        <li class="nk-menu-item">
                            <a href="{{ route('admin.overview') }}" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-home-alt"></em></span>
                                <span class="nk-menu-text">Ikhtisar</span>
                            </a>
                        </li><!-- .nk-menu-item -->
                        @if (Auth::user()->role_id == 1)
                            <li class="nk-menu-heading">
                                <h6 class="overline-title text-primary-alt">Master</h6>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="{{ route('master.users') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                                    <span class="nk-menu-text">Pengguna</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="{{ route('master.topics') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-list"></em></span>
                                    <span class="nk-menu-text">Topik</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="{{ route('master.units') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-layers"></em></span>
                                    <span class="nk-menu-text">Satuan</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="{{ route('master.localGovernmentAgencies') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-building"></em></span>
                                    <span class="nk-menu-text">OPD</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                        @endif
                        <li class="nk-menu-heading">
                            <h6 class="overline-title text-primary-alt">Kelola</h6>
                        </li><!-- .nk-menu-item -->
                        @if (Auth::user()->role_id == 1)
                            <li class="nk-menu-item">
                                <a href="{{ route('manage.profiles') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-notes"></em></span>
                                    <span class="nk-menu-text">Profil</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                        @endif
                        <li class="nk-menu-item">
                            <a href="{{ Auth::user()->role_id == 1 ? route('manage.datasets') : route('manage.dataset.dataByLocalGovernmentAgency', Auth::user()->localGovernmentAgency->slug) }}"
                                class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-db"></em></span>
                                <span class="nk-menu-text">Dataset</span>
                            </a>
                        </li><!-- .nk-menu-item -->
                        @if (Auth::user()->role_id == 1)
                            <li class="nk-menu-heading">
                                <h6 class="overline-title text-primary-alt">Pengaturan</h6>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="{{ route('setting.application') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-setting"></em></span>
                                    <span class="nk-menu-text">Aplikasi</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                        @endif
                    </ul><!-- .nk-footer-menu -->
                </div><!-- .nk-sidebar-footer -->
            </div><!-- .nk-sidebar-content -->
        </div><!-- .nk-sidebar-body -->
    </div><!-- .nk-sidebar-element -->
</div>
