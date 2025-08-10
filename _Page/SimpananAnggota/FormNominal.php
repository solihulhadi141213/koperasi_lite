<?php
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    if(empty($_POST['id_simpanan_jenis'])){
        echo '
            <small>
                <b>Nominal Simpanan</b>
            </small>
            <input type="text" name="nominal_simpanan_sukarela" id="nominal_simpanan_sukarela" class="form-control">
        ';
    }else{
        $id_simpanan_jenis=$_POST['id_simpanan_jenis'];
        $nominal=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'nominal');
        if(empty($nominal)){
            $nominal=0;
        }
        echo '
             <small>
                <b>Nominal Simpanan</b>
            </small>
            <input type="text" name="nominal_simpanan_sukarela" id="nominal_simpanan_sukarela" class="form-control" value="'.$nominal.'">
        ';
    }
?>