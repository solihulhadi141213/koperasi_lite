<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-graph-down-arrow"></i> Riwayat Anggota</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active"> Riwayat Anggota</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-md-12">
        <?php
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
            echo '  <small>';
            echo '      Berikut ini adalah halaman riwayat transaksi yang pernah anda lakukan.<br>';
            echo '      Anda bisa menggunakan tab menu untuk beralih jenis transaksi yang ingin anda tampilkan.<br>';
            echo '      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo '  </small>';
            echo '</div>';
        ?>
    </div>
</div>
<?php
    if(empty($_GET['Sub'])){
        include "_Page/RiwayatAnggota/Pembelian.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="Penarikan"){
            include "_Page/RiwayatAnggota/Penarikan.php";
        }else{
            if($Sub=="Simpanan"){
                include "_Page/RiwayatAnggota/Simpanan.php";
            }else{
                if($Sub=="Pinjaman"){
                    include "_Page/RiwayatAnggota/Pinjaman.php";
                }else{
                    if($Sub=="Angsuran"){
                        include "_Page/RiwayatAnggota/Angsuran.php";
                    }else{
                        if($Sub=="DetailPembelian"){
                            include "_Page/RiwayatAnggota/DetailPembelian.php";
                        }else{
                            if($Sub=="DetailPinjaman"){
                                include "_Page/RiwayatAnggota/DetailPinjaman.php";
                            }else{
                                include "_Page/RiwayatAnggota/Pembelian.php";
                            }
                        }
                    }
                }
            }
        }
    }
?>