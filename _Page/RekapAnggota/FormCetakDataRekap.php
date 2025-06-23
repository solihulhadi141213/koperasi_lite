<?php
    //Menangkap Data
    if(empty($_POST['periode'])){
        $periode="";
    }else{
        $periode=$_POST['periode'];
    }
    if(empty($_POST['bulan'])){
        $bulan="";
    }else{
        $bulan=$_POST['bulan'];
    }
    if(empty($_POST['tahun'])){
        $tahun="";
    }else{
        $tahun=$_POST['tahun'];
    }
?>
<div class="row mb-3">
    <div class="col col-md-4"><label for="periode">Periode Data</label></div>
    <div class="col col-md-8">
        <input type="text" readonly name="periode" id="periode" class="form-control" value="<?php echo $periode; ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col col-md-4"><label for="tahun">Tahun</label></div>
    <div class="col col-md-8">
        <input type="text" readonly name="tahun" id="tahun" class="form-control" value="<?php echo $tahun; ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col col-md-4"><label for="bulan">Tahun</label></div>
    <div class="col col-md-8">
        <input type="text" readonly name="bulan" id="bulan" class="form-control" value="<?php echo $bulan; ?>">
    </div>
</div>