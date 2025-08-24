<aside id="sidebar" class="sidebar menu_background">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link <?php if($PageMenu==""){echo "";}else{echo "collapsed";} ?>" href="index.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link <?php if($PageMenu=="Laporan"){echo "";}else{echo "collapsed";} ?>" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="javascript:void(0);">
                <i class="bi bi-bar-chart"></i><span>Laporan</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="charts-nav" class="nav-content collapse <?php if($PageMenu=="Laporan"){echo "show";} ?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="index.php?Page=Laporan&Sub=Anggota" class="<?php if($PageMenu=="Laporan"&&$SubMenu=="Anggota"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Anggota</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?Page=Laporan&Sub=Simpanan" class="<?php if($PageMenu=="Laporan"&&$SubMenu=="Simpanan"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Simpanan</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?Page=Laporan&Sub=Pinjaman" class="<?php if($PageMenu=="Laporan"&&$SubMenu=="Pinjaman"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Pinjaman</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?Page=Laporan&Sub=Angsuran" class="<?php if($PageMenu=="Laporan"&&$SubMenu=="Angsuran"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Angsuran</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($PageMenu!=="Help"){echo "collapsed";} ?>" href="index.php?Page=Help&Sub=HelpData">
                <i class="bi bi-question"></i>
                <span>Tentang Aplikasi</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalLogout">
                <i class="bi bi-box-arrow-in-left"></i>
                <span>Keluar</span>
            </a>
        </li>
    </ul>
</aside> 