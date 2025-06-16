<?php
// Koneksi ke database
include 'koneksi.php';

// Jika form disubmit
if (isset($_POST['submit'])) {
    // Mendapatkan data dari form
    $nama_menu = $_POST['nama_menu'];
    $harga_menu = $_POST['harga_menu'];

    // Mengambil informasi file gambar
    $gambar_menu = $_FILES['gambar_menu']['name'];
    $gambar_tmp = $_FILES['gambar_menu']['tmp_name'];
    $gambar_size = $_FILES['gambar_menu']['size'];

    // Menentukan folder tujuan dan nama file
    $target_dir = "img/";
    $target_file = $target_dir . basename($gambar_menu);

    // Validasi file (misalnya hanya gambar JPG, PNG, atau JPEG)
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "Hanya file JPG, PNG, dan JPEG yang diperbolehkan.";
        exit();
    }

    // Memindahkan file ke folder 'img/'
    if (move_uploaded_file($gambar_tmp, $target_file)) {
        // Menyimpan data ke database (tanpa PDO)
        $query = "INSERT INTO menu (nama_menu, gambar_menu, harga_menu) 
                  VALUES ('$nama_menu', '$gambar_menu', '$harga_menu')";

        if (mysqli_query($conn, $query)) {
            echo "Menu berhasil ditambahkan!";
        } else {
            echo "Gagal menambahkan menu: " . mysqli_error($conn);
        }
    } else {
        echo "Terjadi kesalahan saat mengunggah gambar.";
    }
}
?>
