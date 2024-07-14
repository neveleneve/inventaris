<div class="row justify-content-center mb-3">
    <div class="col-lg-8">
        <ul class="nav nav-underline justify-content-center">
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('dashboard*') ? 'active' : null }}"
                    href="{{ route('dashboard') }}">
                    <i class="fas fa-gauge"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('item*') ? 'active' : null }}"
                    href="{{ route('item.index') }}">
                    <i class="fas fa-box"></i>
                    Item
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('transaksi*') ? 'active' : null }}"
                    href="{{ route('transaksi.index') }}">
                    <i class="fas fa-right-left"></i>
                    Transaksi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark " href="#">
                    <i class="far fa-file"></i>
                    Report
                </a>
            </li>
        </ul>
    </div>
    <div class="col-lg-8">
        <hr class="m-0">
    </div>
</div>
