<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo p-2">
                <img width="40" src="/admin/img/logo.jpg" alt="Web Logo" class="img-fluid">
            </span>
            <span
                class="app-brand-text demo menu-text text-base fw-bolder ms-2 text-uppercase">{{ __('Student Manager') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboard"> {{ __('Dashboard') }} </div>
            </a>
        </li>

        @canany(['list_student','create_student'])
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle no-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="menu-icon  bx bx-layout">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>
                    </svg>
                    <div data-i18n="Student"> {{ __('Student Manager') }} </div>
                </a>
                <ul class="menu-sub">
                    @can('list_student')
                        <li class="menu-item">
                            <a href="{{ route('students.index') }}" class="menu-link">
                                <div data-i18n="Danh sách khách hàng">{{ __('Student List') }}</div>
                            </a>
                        </li>
                    @endcan
                    @can('create_student')
                        <li class="menu-item">
                            <a href="{{ route('students.create') }}" class="menu-link">
                                <div data-i18n="Tạo khách hàng mới"> {{ __('Create Student') }} </div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany
        @canany(['list_department','create_department'])
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle no-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" stroke-width="1.5"
                         fill="currentColor" class="bi bi-buildings menu-icon  bx bx-layout" viewBox="0 0 16 16">
                        <path
                            d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022M6 8.694 1 10.36V15h5zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5z"/>
                        <path
                            d="M2 11h1v1H2zm2 0h1v1H4zm-2 2h1v1H2zm2 0h1v1H4zm4-4h1v1H8zm2 0h1v1h-1zm-2 2h1v1H8zm2 0h1v1h-1zm2-2h1v1h-1zm0 2h1v1h-1zM8 7h1v1H8zm2 0h1v1h-1zm2 0h1v1h-1zM8 5h1v1H8zm2 0h1v1h-1zm2 0h1v1h-1zm0-2h1v1h-1z"/>
                    </svg>
                    <div data-i18n="Department"> {{ __('Department Manager') }} </div>
                </a>
                <ul class="menu-sub">
                    @can('list_department')
                        <li class="menu-item">
                            <a href="{{ route('departments.index') }}" class="menu-link">
                                <div data-i18n="Danh sách khách hàng">{{ __('Department List') }}</div>
                            </a>
                        </li>
                    @endcan
                    @can('create_department')
                        <li class="menu-item">
                            <a href="{{ route('departments.create') }}" class="menu-link">
                                <div data-i18n="Tạo khách hàng mới"> {{ __('Create Department') }} </div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany
        @canany(['list_subject','create_subject'])
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle no-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" stroke-width="1.5"
                         fill="currentColor" class="bi bi-card-list menu-icon  bx bx-layout" viewBox="0 0 16 16">
                        <path
                            d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
                        <path
                            d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8m0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0M4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0"/>
                    </svg>
                    <div data-i18n="Department"> {{ __('Subject Manager') }} </div>
                </a>
                <ul class="menu-sub">
                    @can('list_subject')
                        <li class="menu-item">
                            <a href="{{ route('subjects.index') }}" class="menu-link">
                                <div data-i18n="Danh sách khách hàng">{{ __('Subject List') }}</div>
                            </a>
                        </li>
                    @endcan
                    @can('create_student')
                        <li class="menu-item">
                            <a href="{{ route('subjects.create') }}" class="menu-link">
                                <div data-i18n="Tạo khách hàng mới"> {{ __('Create Subject') }} </div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany
        @canany(['list_role','create_role'])
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle no-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" stroke-width="1.5"
                         fill="currentColor" class="bi bi-person-gear menu-icon  bx bx-layout" viewBox="0 0 16 16">
                        <path
                            d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.256 7a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"/>
                    </svg>
                    <div data-i18n="Department"> {{ __('Role Manager') }} </div>
                </a>
                <ul class="menu-sub">
                    @can('list_role')
                        <li class="menu-item">
                            <a href="{{ route('roles.index') }}" class="menu-link">
                                <div data-i18n="Danh sách khách hàng">{{ __('Role List') }}</div>
                            </a>
                        </li>
                    @endcan
                    @can('create_role')
                        <li class="menu-item">
                            <a href="{{ route('roles.create') }}" class="menu-link">
                                <div data-i18n="Tạo khách hàng mới"> {{ __('Create Role') }} </div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany
        @can('self_manager_profile')
            <li class="menu-item">
                <a href="{{ route('profile.edit') }}" class="menu-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" stroke-width="1.5"
                         fill="currentColor" class="bi bi-person-circle  menu-icon  bx bx-layout" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                        <path fill-rule="evenodd"
                              d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                    </svg>
                    <div data-i18n="Tạo khách hàng mới"> {{ __('Profile Manager') }} </div>
                </a>
            </li>
        @endcan
    </ul>
</aside>
