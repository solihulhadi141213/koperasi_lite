<?php
    if(empty($_GET['Page'])){
        $Page="";
    }else{
        $Page=$_GET['Page'];
    }
    if(empty($_GET['Sub'])){
        $Sub="";
    }else{
        $Sub=$_GET['Sub'];
    }
?>
<aside id="sidebar" class="sidebar menu_background">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link <?php if($Page==""){echo "";}else{echo "collapsed";} ?>" href="index.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($Page!=="SimpananAnggota"){echo "collapsed";} ?>" href="index.php?Page=SimpananAnggota">
                <i class="bi bi-bank"></i>
                <span>Simpanan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($Page!=="PenarikanAnggota"){echo "collapsed";} ?>" href="index.php?Page=PenarikanAnggota">
                <i class="bi bi-coin"></i>
                <span>Penarikan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($Page!=="PinjamanAnggota"){echo "collapsed";} ?>" href="index.php?Page=PinjamanAnggota">
                <i class="bi bi-send-arrow-down"></i>
                <span>Pinjaman</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($Sub!=="Angsuran"){echo "collapsed";} ?>" href="index.php?Page=RiwayatAnggota&Sub=Angsuran">
                <i class="bi bi-circle"></i>
                <span>Angsuran</span>
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