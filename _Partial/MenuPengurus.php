<aside id="sidebar" class="sidebar menu_background">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link <?php if($PageMenu==""){echo "";}else{echo "collapsed";} ?>" href="index.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($PageMenu=="Akses"){echo "";}else{echo "collapsed";} ?>" href="index.php?Page=Akses">
                <i class="bi bi-person"></i>
                <span>Akses</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($PageMenu=="Anggota"){echo "";}else{echo "collapsed";} ?>" href="index.php?Page=Anggota">
                <i class="bi bi-people"></i>
                <span>Anggota</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($PageMenu=="JenisSimpanan"||$PageMenu=="SimpananWajib"||$PageMenu=="Tabungan"||$PageMenu=="RekapSimpanan"){echo "";}else{echo "collapsed";} ?>" data-bs-target="#simpanan-nav" data-bs-toggle="collapse" href="javascript:void(0);">
                <i class="bi bi-wallet"></i>
                <span>Simpanan</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="simpanan-nav" class="nav-content collapse <?php if($PageMenu=="JenisSimpanan"||$PageMenu=="SimpananWajib"||$PageMenu=="Tabungan"||$PageMenu=="RekapSimpanan"){echo "show";} ?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="index.php?Page=JenisSimpanan" class="<?php if($PageMenu=="JenisSimpanan"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Jenis Simpanan</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?Page=Tabungan" class="<?php if($PageMenu=="Tabungan"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Simpanan & Penarikan</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($PageMenu=="JenisPinjaman"||$PageMenu=="Pinjaman"||$PageMenu=="Tagihan"||$PageMenu=="RekapPinjaman"||$PageMenu=="PotonganAnggota"){echo "";}else{echo "collapsed";} ?>" data-bs-target="#pinjaman-nav" data-bs-toggle="collapse" href="javascript:void(0);">
                <i class="bi bi-bank"></i>
                <span>Pinjaman</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="pinjaman-nav" class="nav-content collapse <?php if($PageMenu=="JenisPinjaman"||$PageMenu=="Pinjaman"||$PageMenu=="Tagihan"||$PageMenu=="RekapPinjaman"||$PageMenu=="PotonganAnggota"){echo "show";} ?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="index.php?Page=JenisPinjaman" class="<?php if($PageMenu=="JenisPinjaman"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Jenis Pinjaman</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?Page=Pinjaman" class="<?php if($PageMenu=="Pinjaman"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Sesi Pinjaman</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?Page=Tagihan" class="<?php if($PageMenu=="Tagihan"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Tagihan/Tunggakan</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?Page=RekapPinjaman" class="<?php if($PageMenu=="RekapPinjaman"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Rekap Pinjaman</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?Page=PotonganAnggota" class="<?php if($PageMenu=="PotonganAnggota"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Potongan Anggota</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($PageMenu=="SimpanPinjam"||$PageMenu=="RekapAnggota"||$PageMenu=="AnggotaKeluarMasuk"||$PageMenu=="LabaRugi"||$PageMenu=="RiwayatSimpanPinjam"){echo "";}else{echo "collapsed";} ?>" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="javascript:void(0);">
                <i class="bi bi-bar-chart"></i><span>Laporan</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="charts-nav" class="nav-content collapse <?php if($PageMenu=="SimpanPinjam"||$PageMenu=="RekapAnggota"||$PageMenu=="AnggotaKeluarMasuk"||$PageMenu=="LabaRugi"||$PageMenu=="RiwayatSimpanPinjam"){echo "show";} ?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="index.php?Page=SimpanPinjam" class="<?php if($PageMenu=="SimpanPinjam"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Simpan-Pinjam</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?Page=AnggotaKeluarMasuk" class="<?php if($PageMenu=="AnggotaKeluarMasuk"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Keluar & Masuk</span>
                    </a>
                </li>
                <a href="index.php?Page=RekapAnggota" class="<?php if($PageMenu=="RekapAnggota"){echo "active";} ?>">
                    <i class="bi bi-circle"></i><span>Rekap Anggota</span>
                </a>
                <li>
                    <a href="index.php?Page=RiwayatSimpanPinjam" class="<?php if($PageMenu=="RiwayatSimpanPinjam"){echo "active";} ?>">
                    <i class="bi bi-circle"></i><span>Riwayat Anggota</span>
                    </a>
                </li>
                 <li>
                    <a href="index.php?Page=RekapSimpanan" class="<?php if($PageMenu=="RekapSimpanan"){echo "active";} ?>">
                        <i class="bi bi-circle"></i><span>Rekap Simpanan</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($PageMenu=="SettingGeneral"){echo "";}else{echo "collapsed";} ?>" href="index.php?Page=SettingGeneral">
                <i class="bi bi-gear"></i>
                <span>Pengaturan</span>
            </a>
        </li>
        <li class="nav-heading">Fitur Lainnya</li>
        <li class="nav-item">
            <a class="nav-link <?php if($PageMenu!=="Aktivitas"){echo "collapsed";} ?>" href="index.php?Page=Aktivitas&Sub=AktivitasUmum">
                <i class="bi bi-circle"></i>
                <span>Log Aktivitas</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($PageMenu!=="Help"){echo "collapsed";} ?>" href="index.php?Page=Help&Sub=HelpData">
                <i class="bi bi-question"></i>
                <span>Dokumentasi</span>
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