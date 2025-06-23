<?php
    if(empty($_POST['mode_periode'])){
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-4"><label for="tahun">Tahun</label></div>';
        echo '  <div class="col col-md-8">';
        echo '      <input type="number" min="2000" max="'.date('Y').'" name="tahun" id="tahun" class="form-control" value="'.date('Y').'">';
        echo '  </div>';
        echo '</div>';
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-4"><label for="semester">Semester</label></div>';
        echo '  <div class="col col-md-8">';
        echo '      <select name="semester" id="semester" class="form-control">';
        echo '          <option value="1">Semester 1</option>';
        echo '          <option selected value="2">Semester 2</option>';
        echo '      </select>';
        echo '  </div>';
        echo '</div>';
    }else{
        $mode_periode=$_POST['mode_periode'];
        if($mode_periode=="Bulanan"){
            echo '<div class="row mb-3">';
            echo '  <div class="col col-md-4"><label for="tahun">Tahun</label></div>';
            echo '  <div class="col col-md-8">';
            echo '      <input type="number" min="2000" max="'.date('Y').'" name="tahun" id="tahun" class="form-control" value="'.date('Y').'">';
            echo '  </div>';
            echo '</div>';
            echo '<div class="row mb-3">';
            echo '  <div class="col col-md-4"><label for="semester">Semester</label></div>';
            echo '  <div class="col col-md-8">';
            echo '      <select name="semester" id="semester" class="form-control">';
            echo '          <option value="1">Semester 1</option>';
            echo '          <option selected value="2">Semester 2</option>';
            echo '      </select>';
            echo '  </div>';
            echo '</div>';
        }else{
            echo '<div class="row mb-3">';
            echo '  <div class="col col-md-4"><label for="tahun_awal">Tahun Awal</label></div>';
            echo '  <div class="col col-md-8">';
            echo '      <input type="number" min="2000" max="'.date('Y').'" name="tahun_awal" id="tahun_awal" class="form-control">';
            echo '  </div>';
            echo '</div>';
            echo '<div class="row mb-3">';
            echo '  <div class="col col-md-4"><label for="tahun_akhir">Tahun Akhir</label></div>';
            echo '  <div class="col col-md-8">';
            echo '      <input type="number" min="2000" max="'.date('Y').'" name="tahun_akhir" id="tahun_akhir" class="form-control">';
            echo '  </div>';
            echo '</div>';
        }
    }
?>