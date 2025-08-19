# Koperasi Simpan-Pinjam (Lite)
Aplikasi Koperasi (Versi Lita) merupakan sebuah sistem manajemen koperasi simpan pinjam yang dirancang khusus untuk mendukung proses bisnis terkait simpanan dan pinjaman anggota. Dibangun dengan pendekatan yang sederhana dan fokus, aplikasi ini menyediakan fitur-fitur inti yang dibutuhkan oleh koperasi simpan pinjam, tanpa kompleksitas yang tidak diperlukan.

Tujuan pengembangan aplikasi ini adalah untuk mempermudah pengelolaan simpanan dan pinjaman, sehingga pengurus koperasi dapat bekerja lebih efisien. Dengan antarmuka yang ringkas dan fungsionalitas yang terarah, proses pencatatan data menjadi lebih cepat, akurat, dan minim kesalahan.

Pada versi ini, aplikasi juga meningkatkan interaksi antara anggota dan koperasi melalui fitur-fitur digital, seperti:
  - Pendaftaran anggota secara mandiri
  - Pembayaran simpanan yang dapat dilakukan langsung oleh anggota
  - Pengajuan pinjaman online
  - Penarikan dana simpanan secara fleksibel

## Entitas Akses
Secara umum, aplikasi Koperasi (Versi Lita) ini memiliki 4 (empat) entitas akses yang terdiri dari sekretaris, bendahara, ketua dan anggota. Khusus untuk anggota, entitas tersebut memiliki kelompok data yang berbeda dengan entitas lainnya. 
  - Sekretaris
  - Bendahara
  - Ketua Koperasi
  - Anggota

## Fitur Aplikasi
1. Sekretaris  
2. Bendahara
3. Ketua Koperasi
4. Anggota

## Spesifikasi Minimum
### Perangkat Lunak
- PHP 7.4 atau lebih baru
- MySQL 5.7 / MariaDB 10.3 atau lebih baru
- Web Server : Wampserver, Xampp
- Browser : Mozila firefox / Google Chrome
- OS : Win 10 64 Bit

### Perangkat Keras
- CPU : 1,5 GHz
- RAM : 2 GB
- Storage : SSD 256 GB
- Internet : 1 Mbps

## Tahapan Instalasi
- Instal webserver (Xampp, Wamp) terlebih dulu kemudian jalankan.
- Simpan folder aplikasi pada directory htdoc (untuk pengguna xampp) atau www (untuk pengguna wamp).
- Masuk ke database mnggunakan phpmyadmin dengan cara ketik localhost/phpmyadmin
- Buat database baru dengan nama apapun (Misalnya : koperasi_lite)
- Import database aplikasi (database standar aplikasi ini disimpan pada folder db).
- Atur variabel koneksi database aplikasi pada file _Config/Connection.php
- Ubah nama database sesuai nama database yang tadi di buat (Misalnya : koperasi_lite).
- Buka aplikasi dengan cara ketik localhost/{nama_folder_aplikasi}
- Lakukan login untuk pertama kali dengan memasukan email : dhiforester@gmail.com dan password : dhiforester
## Referensi Komponen
- Nice Admin (https://bootstrapmade.com/demo/NiceAdmin/)
- Boxicons (https://boxicons.com/)
- Remixicon (https://remixicon.com/)
- Bootstrap Icon (https://icons.getbootstrap.com/)
- Bootstrap v5.3.3 (https://getbootstrap.com/)
- JQuery (https://jquery.com/)
- Material Design (https://mdbootstrap.com/)
- Marked (https://marked.js.org/)
- Signature Pad (https://github.com/szimek/signature_pad)
- Apexcharts (https://www.apexcharts.com/)





