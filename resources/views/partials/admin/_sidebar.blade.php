<div class="nk-sidebar nk-sidebar-fixed " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand d-flex justify-content-center align-items-center gap-2">
            <a href="{{ route('admin.overview') }}" class="logo-link nk-sidebar-logo">
                <img class="logo-dark logo-img" src="{{ asset('assets/images/logo.png') }}" alt="logo">
            </a>
            <b>
                Arsip Surat SMI 1-3 Al-Muhajirin <br>Purwakarta
            </b>
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
                        @can('overview.read')
                            <li class="nk-menu-heading">
                                <h6 class="overline-title text-primary-alt">Ringkasan</h6>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('admin.overview') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-home-alt"></em></span>
                                    <span class="nk-menu-text">Ikhtisar</span>
                                </a>
                            </li>
                        @endcan

                        @canany(['categories.read', 'parties.read'])
                            <li class="nk-menu-heading">
                                <h6 class="overline-title text-primary-alt">Master</h6>
                            </li>
                            @can('categories.read')
                                <li class="nk-menu-item">
                                    <a href="{{ route('admin.master.categories.index') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-list"></em></span>
                                        <span class="nk-menu-text">Kategori</span>
                                    </a>
                                </li>
                            @endcan
                            @can('parties.read')
                                <li class="nk-menu-item">
                                    <a href="{{ route('admin.master.parties.index') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                                        <span class="nk-menu-text">Pihak Terkait</span>
                                    </a>
                                </li>
                            @endcan
                        @endcanany

                        @canany(['users.read', 'incoming_letters.read', 'outgoing_letters.read'])
                            <li class="nk-menu-heading">
                                <h6 class="overline-title text-primary-alt">Kelola</h6>
                            </li>
                            @can('users.read')
                                <li class="nk-menu-item">
                                    <a href="{{ route('admin.manage.users.index') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-user-check"></em></span>
                                        <span class="nk-menu-text">Pengguna</span>
                                    </a>
                                </li>
                            @endcan
                            @can('incoming_letters.read')
                                <li class="nk-menu-item">
                                    <a href="{{ route('admin.manage.incomingLetters.index') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-inbox-in"></em></span>
                                        <span class="nk-menu-text">Surat Masuk</span>
                                    </a>
                                </li>
                            @endcan
                            @can('outgoing_letters.read')
                                <li class="nk-menu-item">
                                    <a href="{{ route('admin.manage.outgoingLetters.index') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-inbox-out"></em></span>
                                        <span class="nk-menu-text">Surat Keluar</span>
                                    </a>
                                </li>
                            @endcan
                        @endcanany

                        @hasrole('Admin')
                            <li class="nk-menu-heading">
                                <h6 class="overline-title text-primary-alt">Pengaturan</h6>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('admin.setting.rolePermissions.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-opt-dot-alt"></em></span>
                                    <span class="nk-menu-text">Role & Hak Akses</span>
                                </a>
                            </li>
                        @endhasrole
                    </ul>
                </div><!-- .nk-sidebar-footer -->
            </div><!-- .nk-sidebar-content -->
        </div><!-- .nk-sidebar-body -->
    </div><!-- .nk-sidebar-element -->
</div>
