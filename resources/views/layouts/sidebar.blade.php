<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="#">
            <span class="align-middle">{{ env('APP_NAME') }}</span>
        </a>
        <ul class="sidebar-nav">
            @can('dashboard')
                <li class="sidebar-item {{ Request::is('dashboard*') ? 'active' : null }}">
                    <a class="sidebar-link {{ Request::is('dashboard*') ? 'fw-bold' : null }}"
                        href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer align-middle"></i>
                        <span class="align-middle">Dashboard</span>
                    </a>
                </li>
            @endcan
            @can('aset index')
                <li class="sidebar-item {{ Request::is('aset*') ? 'active' : null }}">
                    <a class="sidebar-link {{ Request::is('aset*') ? 'fw-bold' : null }}" href="{{ route('aset.index') }}">
                        <i class="bi bi-archive align-middle"></i>
                        <span class="align-middle">Aset</span>
                    </a>
                </li>
            @endcan
            @canany(['inventaris index', 'inventaris create'])
                <li class="sidebar-item">
                    <a href="#submenu1" data-bs-toggle="collapse" class="sidebar-link collapsed">
                        <i class="bi bi-journal align-middle"></i>
                        <span class="align-middle">Inventarisasi</span>
                    </a>
                    <ul class="sidebar-dropdown list-unstyled collapse {{ Request::is('inventaris') || Request::is('inventaris/create') ? 'show' : null }}"
                        id="submenu1" data-bs-parent="#sidebar">
                        @can('inventaris index')
                            <li class="sidebar-item {{ Request::is('inventaris') ? 'active' : null }}">
                                <a class="sidebar-link " href="{{ route('inventaris.index') }}">
                                    Data Inventarisasi
                                </a>
                            </li>
                        @endcan
                        @can('inventaris create')
                            <li class="sidebar-item {{ Request::is('inventaris/create') ? 'active' : null }}">
                                <a class="sidebar-link" href="{{ route('inventaris.create') }}">
                                    Aset Masuk/Keluar
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            <li class="sidebar-item {{ Request::is('report*') ? 'active' : null }}">
                <a class="sidebar-link {{ Request::is('report*') ? 'fw-bold' : null }}"
                    href="{{ route('report.index') }}">
                    <i class="bi bi-file-earmark-pdf align-middle"></i>
                    <span class="align-middle">Report</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
