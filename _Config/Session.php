<?php
    //Menangkap seasson kemudian menampilkannya
    session_start();
    date_default_timezone_set('Asia/Jakarta');
    if(empty($_SESSION["id_akses"])){
        $SessionIdAkses="";
        $SessionModeAkses="";
        $SessionLoginToken="";
    }else{
        if(empty($_SESSION["login_token"])){
            $SessionIdAkses="";
            $SessionModeAkses="";
            $SessionLoginToken="";
        }else{
            $SessionIdAkses=$_SESSION ["id_akses"];
            $SessionLoginToken=$_SESSION ["login_token"];
                
            //Membersihkan Variabel
            $SessionIdAkses=validateAndSanitizeInput($SessionIdAkses);
            $SessionLoginToken=validateAndSanitizeInput($SessionLoginToken);

            //Validasi Token Akses
            $QryAksesLogin = mysqli_query($Conn,"SELECT * FROM akses_login WHERE id_akses='$SessionIdAkses' AND token='$SessionLoginToken'")or die(mysqli_error($Conn));
            $DataAksesLogin = mysqli_fetch_array($QryAksesLogin);
            //Apabila Tidak Ada
            if(empty($DataAksesLogin['id_akses'])){
                $SessionIdAkses="";
                $SessionLoginToken="";
            }else{
                //Apabila Ada
                $SessionDateCreat=$DataAksesLogin['date_creat'];
                //Validasi Apakah Token Masih Berlaku Atau Tidak
                $SessionDateExpired=$DataAksesLogin['date_expired'];
                $DateSekarang=date('Y-m-d H:i:s');
                if($SessionDateExpired<$DateSekarang){
                    $SessionIdAkses="";
                    $SessionLoginToken="";
                }else{
                    $SessionIdAkses=$DataAksesLogin['id_akses'];
                    $expired_milisecond=1000*60*60;
                    $now=date('Y-m-d H:i:s');
                    $date_expired_new=calculateExpirationTimeFromDateTime($now, $expired_milisecond);
                    
                    //Update Token Yang Ada
                    $UpdateToken = mysqli_query($Conn,"UPDATE akses_login SET 
                        date_expired='$date_expired_new'
                    WHERE id_akses='$SessionIdAkses'") or die(mysqli_error($Conn)); 
                    if($UpdateToken){
                        $SessionIdAkses=$DataAksesLogin['id_akses'];
                        $SessionLoginToken=$DataAksesLogin['token'];
                    }else{
                        $SessionIdAkses="";
                        $SessionLoginToken="";
                    }
                }
            }
        }
    }
?>
