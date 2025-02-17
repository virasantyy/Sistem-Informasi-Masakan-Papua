<?php
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $alamat = $_POST['alamat'];
    $bahan_utama = $_POST['bahan_utama'];
    $pendamping = $_POST['pendamping'];
    $kategori = $_POST['kategori'];

    // Memeriksa apakah ada file yang diunggah
    if (isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != '') {
        // Cek apakah file diunggah tanpa error
        if ($_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
            echo "Error saat mengunggah file: " . $_FILES['foto']['error'];
            exit; // Hentikan eksekusi jika ada error
        }

        $foto = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_path = '../../uploads/' . $foto;

        // Pindahkan file ke folder tujuan
        if (move_uploaded_file($foto_tmp, $foto_path)) {
            // File berhasil dipindahkan
        } else {
            echo "Gagal mengunggah file.";
            exit;
        }
    } else {
        // Jika tidak ada file baru, gunakan foto lama dari database
        $query = "SELECT foto FROM makanan WHERE id = '$id'";
        $result = $connect->query($query);
        $row = $result->fetch_assoc();
        $foto = $row['foto'];
    }

    // Update data di database
    $sql = "UPDATE makanan 
            SET nama='$nama', 
                deskripsi='$deskripsi', 
                alamat='$alamat', 
                bahan_utama='$bahan_utama', 
                pendamping='$pendamping', 
                kategori='$kategori', 
                foto='$foto' 
            WHERE id='$id'";

    if ($connect->query($sql) === TRUE) {
        header("Location: ../pages/makanan.php?status=success");
    } else {
        echo "Error: " . $connect->error;
    }
}
