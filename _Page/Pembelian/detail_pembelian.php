<?php
    // Koneksi & Konfigurasi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');
    $now = date('Y-m-d H:i:s');

    // Default Response
    $response = [
        "status" => "Error",
        "message" => "Belum ada proses yang dilakukan pada sistem."
    ];

    // Validasi Sesi Login
    if (empty($SessionIdAkses)) {
        $response = [
            "status" => "Error",
            "message" => "Sesi Akses Sudah Berakhir, Silahkan Login Ulang"
        ];
    } elseif (!isset($_POST['id_transaksi_jual_beli']) || empty($_POST['id_transaksi_jual_beli'])) {
        // Validasi ID Transaksi
        $response = [
            "status" => "Error",
            "message" => "ID Transaksi Tidak Boleh Kosong!"
        ];
    } else {
        // Ambil Data Transaksi
        $id_transaksi_jual_beli = validateAndSanitizeInput($_POST['id_transaksi_jual_beli']);
        
        $Qry = $Conn->prepare("SELECT * FROM transaksi_jual_beli WHERE id_transaksi_jual_beli = ?");
        $Qry->bind_param("s", $id_transaksi_jual_beli);
        
        if (!$Qry->execute()) {
            $response = [
                "status" => "Error",
                "message" => $Conn->error
            ];
        } else {
            $Result = $Qry->get_result();
            $Data = $Result->fetch_assoc();
            $Qry->close();

            if (!$Data) {
                $response = [
                    "status" => "Error",
                    "message" => "Data transaksi tidak ditemukan"
                ];
            } else {
                // Ambil Data Transaksi
                $id_supplier = $Data['id_supplier'];
                $kategori = $Data['kategori'];
                $tanggal = $Data['tanggal'];
                $subtotal = pembulatan_nilai($Data['subtotal']);
                $ppn = pembulatan_nilai($Data['ppn']);
                $diskon = pembulatan_nilai($Data['diskon']);
                $total = pembulatan_nilai($Data['total']);
                $cash = pembulatan_nilai($Data['cash']);
                $kembalian = pembulatan_nilai($Data['kembalian']);
                $status = $Data['status'];

                // Format Rupiah
                $subtotal_rp = "Rp " . number_format($subtotal, 0, ',', '.');
                $ppn_rp = "Rp " . number_format($ppn, 0, ',', '.');
                $diskon_rp = "Rp " . number_format($diskon, 0, ',', '.');
                $total_rp = "Rp " . number_format($total, 0, ',', '.');
                $cash_rp = "Rp " . number_format($cash, 0, ',', '.');
                $kembalian_rp = "Rp " . number_format($kembalian, 0, ',', '.');

                // Ambil Nama Supplier
                $nama_supplier = (!empty($id_supplier)) ? GetDetailData($Conn, 'supplier', 'id_supplier', $id_supplier, 'nama_supplier') : "-";

                // Ambil Rincian Transaksi
                $list_rincian = [];
                $stmt = $Conn->prepare("SELECT * FROM transaksi_jual_beli_rincian WHERE id_transaksi_jual_beli = ?");
                $stmt->bind_param("s", $id_transaksi_jual_beli);
                $stmt->execute();
                $result_rincian = $stmt->get_result();

                while ($data_rincian = $result_rincian->fetch_assoc()) {
                    $list_rincian[] = [
                        "id_transaksi_jual_beli_rincian" => $data_rincian['id_transaksi_jual_beli_rincian'],
                        "id_barang" => $data_rincian['id_barang'],
                        "nama_barang" => $data_rincian['nama_barang'],
                        "satuan" => $data_rincian['satuan'],
                        "qty" => $data_rincian['qty'],
                        "harga" => $data_rincian['harga'],
                        "ppn" => $data_rincian['ppn'],
                        "diskon" => $data_rincian['diskon'],
                        "subtotal" => $data_rincian['subtotal'],
                        "harga_rp" => "" . number_format($data_rincian['harga'], 0, ',', '.'),
                        "ppn_rp" => "" . number_format($data_rincian['ppn'], 0, ',', '.'),
                        "diskon_rp" => "" . number_format($data_rincian['diskon'], 0, ',', '.'),
                        "subtotal_rp" => "" . number_format($data_rincian['subtotal'], 0, ',', '.'),
                    ];
                }

                //Ambil Jurnal Transaksi
                $list_jurnal=[];
                $stmt2 = $Conn->prepare("SELECT * FROM jurnal WHERE id_transaksi_jual_beli = ? ORDER BY d_k ASC");
                $stmt2->bind_param("s", $id_transaksi_jual_beli);
                $stmt2->execute();
                $result_jurnal = $stmt2->get_result();

                while ($data_jurnal = $result_jurnal->fetch_assoc()) {
                    $list_jurnal[] = [
                        "id_jurnal" => $data_jurnal['id_jurnal'],
                        "id_transaksi_jual_beli" => $data_jurnal['id_transaksi_jual_beli'],
                        "tanggal" => $data_jurnal['tanggal'],
                        "kode_perkiraan" => $data_jurnal['kode_perkiraan'],
                        "nama_perkiraan" => $data_jurnal['nama_perkiraan'],
                        "d_k" => $data_jurnal['d_k'],
                        "nilai" => $data_jurnal['nilai'],
                        "nilai_rp" => "" . number_format($data_jurnal['nilai'], 0, ',', '.')
                    ];
                }

                // Data Response
                $dataset = [
                    "id_supplier" => $id_supplier,
                    "nama_supplier" => $nama_supplier,
                    "kategori" => $kategori,
                    "tanggal" => $tanggal,
                    "subtotal" => $subtotal,
                    "subtotal_rp" => $subtotal_rp,
                    "ppn" => $ppn,
                    "ppn_rp" => $ppn_rp,
                    "diskon" => $diskon,
                    "diskon_rp" => $diskon_rp,
                    "total" => $total,
                    "total_rp" => $total_rp,
                    "cash" => $cash,
                    "cash_rp" => $cash_rp,
                    "kembalian" => $kembalian,
                    "kembalian_rp" => $kembalian_rp,
                    "status" => $status,
                ];

                // Response JSON
                $response = [
                    "status" => "Success",
                    "message" => "Data Ditemukan",
                    "dataset" => $dataset,
                    "list_rincian" => $list_rincian,
                    "list_jurnal" => $list_jurnal
                ];
            }
        }
    }

    // Output JSON Response
    header('Content-Type: application/json');
    echo json_encode($response);
?>
