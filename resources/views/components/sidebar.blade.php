<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('beranda.index') }}">Dashboard</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('beranda.index') }}">DB</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item dropdown {{ $type_menu === 'beranda' ? 'active' : '' }}">
                <a href="{{ route('beranda.index') }}" class="nav-link ha"><i
                        class="fas fa-home"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">Master Data</li>
            <li class="nav-item dropdown {{ $type_menu === 'gedung' ? 'active' : '' }}">
                <a href="{{ route('gedung.index') }}" class="nav-link ha"><i
                        class="fas fa-building"></i><span>Gedung</span></a>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'pemesanan' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-calendar-alt"></i><span>Peminjaman</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('pemesanan') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('pemesanan.index') }}">Data Peminjaman</a>
                    </li>
                    <li class="{{ Request::is('peminjaman/terima') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('peminjaman/terima') }}">Data Peminjaman Diterima</a>
                    </li>
                    <li class="{{ Request::is('peminjaman/proses') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('peminjaman/proses') }}">Data Peminjaman Diproses</a>
                    </li>
                    <li class="{{ Request::is('peminjaman/input') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('peminjaman/input') }}">Peminjaman</a>
                    </li>
                    <li class="{{ Request::is('peminjaman/riwayat') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('peminjaman/riwayat') }}">Riwayat Peminjaman</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'ruangan' ? 'active' : '' }}">
                <a href="{{ route('ruangan.index') }}" class="nav-link ha"><i
                        class="fas fa-door-open"></i><span>Ruangan</span></a>

            </li>
            <li class="nav-item dropdown {{ $type_menu === 'ukm' ? 'active' : '' }}">
                <a href="{{ route('ukm.index') }}" class="nav-link ha"><i
                        class="fas fa-user-friends"></i><span>UKM</span></a>

            </li>
            <li class="nav-item dropdown {{ $type_menu === 'user' ? 'active' : '' }}">
                <a href="{{ route('user.index') }}" class="nav-link ha"><i
                        class="fas fa-users"></i><span>Users</span></a>

            </li>
        </ul>
    </aside>
</div>
