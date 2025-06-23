<?php
    if(empty($_POST['mode'])){
        $mode='Harian';
    }else{
        $mode=$_POST['mode'];
    }
    if(empty($_POST['tahun'])){
        $year=date('Y');
    }else{
        $year=$_POST['tahun'];
    }
    if(empty($_POST['bulan'])){
        $month=date('m');
    }else{
        $month=$_POST['bulan'];
    }
?>
<div class="row mb-3">
    <div class="col col-md-4">Mode</div>
    <div class="col col-md-8">
        <input type="text" readonly class="form-control" name="mode" value="<?php echo $mode; ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col col-md-4">Tahun</div>
    <div class="col col-md-8">
        <input type="text" readonly class="form-control" name="tahun" value="<?php echo $year; ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col col-md-4">Bulan</div>
    <div class="col col-md-8">
        <input type="text" readonly class="form-control" name="bulan" value="<?php echo $month; ?>">
    </div>
</div>