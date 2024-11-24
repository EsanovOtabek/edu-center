<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('index') }}" class="brand-link">
        <img src="{{ asset('images/logo.png') }}" alt="Edu-Center" class="brand-image img-circle elevation-3 bg-white"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Edu-Center</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block">
                    @auth
                        {{ auth()->user()->fio }}
                    @endauth
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
                {{-- <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Bosh sahifa
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Active Page</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Inactive Page</p>
                            </a>
                        </li>
                    </ul>
                </li> --}}

                <li class="nav-item">
                    <a href="{{ route('admin.index') }}" class="nav-link active">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Bosh sahifa</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.subjects.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Fanlar</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.rooms.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-building"></i>
                        <p>Xonalar</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>
                            O'qituvchilar
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.teachers.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>O'qituvchilar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.teachers.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>O'qituvchi qo'shish</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Guruhlar
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.groups.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Guruhlar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.groups.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Guruh qo'shish</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Talabalar
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.students.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Talabalar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.students.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Talaba qo'shish</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.schedule.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>Dars jadvali</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link">
                        <i class="nav-icon fa fa-sign-out-alt"></i>
                        <p>
                            Chiqish
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
