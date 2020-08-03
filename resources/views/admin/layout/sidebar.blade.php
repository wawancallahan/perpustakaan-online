<!-- Left Panel -->

<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                </li>
                <li class="{{ request()->is('admin/book') || request()->is('admin/book/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.book.index') }}"> <i class="menu-icon fa fa-book"></i>Buku </a>
                </li>
                <li class="{{ request()->is('admin/transaction') || request()->is('admin/transaction/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.transaction.index') }}"> <i class="menu-icon fa fa-th"></i>Peminjaman </a>
                </li>
                <li class="{{ request()->is('admin/siswa') || request()->is('admin/siswa/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.siswa.index') }}"> <i class="menu-icon fa fa-users"></i>Siswa </a>
                </li>
                <li class="{{ request()->is('admin/user') || request()->is('admin/user/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.user.index') }}"> <i class="menu-icon fa fa-user"></i>User </a>
                </li>
                <li class="{{ request()->is('admin/config') || request()->is('admin/config/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.config.index') }}"> <i class="menu-icon fa fa-cogs"></i>Konfig </a>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside><!-- /#left-panel -->

<!-- Left Panel -->