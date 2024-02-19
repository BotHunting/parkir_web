<?php
// Sertakan file koneksi.php untuk terhubung ke database
require_once('koneksi.php');

// Periksa apakah metode pengiriman adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Peroleh nilai yang dikirim dari formulir
    $id_kendaraan = $_POST["kendaraan"];
    $id_petugas = $_POST["petugas"];

    // Query untuk mendapatkan informasi kendaraan yang dipilih
    $sql_kendaraan = "SELECT * FROM kendaraan WHERE id = '$id_kendaraan'";
    $result_kendaraan = $conn->query($sql_kendaraan);

    // Periksa apakah ada hasil dari query
    if ($result_kendaraan->num_rows > 0) {
        // Ambil data kendaraan
        $row_kendaraan = $result_kendaraan->fetch_assoc();
        $nomor_plat = $row_kendaraan["nomor_plat"];
        $jenis_kendaraan = $row_kendaraan["jenis_kendaraan"];
        $waktu_masuk = $row_kendaraan["waktu_masuk"];

        // Hitung biaya parkir berdasarkan jenis kendaraan
        $tarif_motor = 2000;
        $tarif_mobil = 3000;
        $biaya_parkir = ($jenis_kendaraan == 'Motor') ? $tarif_motor : $tarif_mobil;

        // Query untuk memperbarui data kendaraan dengan biaya parkir dan status keluar
        $waktu_keluar = date("Y-m-d H:i:s"); // Waktu keluar adalah waktu saat ini
        $sql_update_kendaraan = "UPDATE kendaraan SET waktu_keluar = '$waktu_keluar', biaya_parkir = '$biaya_parkir', status = 'Keluar' WHERE id = '$id_kendaraan'";
        if ($conn->query($sql_update_kendaraan) === TRUE) {
            // Hapus data kendaraan setelah pembayaran
            $sql_delete_kendaraan = "DELETE FROM kendaraan WHERE id = '$id_kendaraan'";
            if ($conn->query($sql_delete_kendaraan) !== TRUE) {
                echo "Error: " . $sql_delete_kendaraan . "<br>" . $conn->error;
            } else {
                echo "<script>alert('Pembayaran parkir berhasil. Biaya parkir Anda adalah Rp. " . number_format($biaya_parkir, 0, ',', '.') . "');</script>";
                echo "<script>window.location.href = 'pembayaran.php';</script>";
            }
        } else {
            echo "Error: " . $sql_update_kendaraan . "<br>" . $conn->error;
        }

        // Simpan informasi pembayaran ke dalam tabel laporan
        $bulan_laporan = date("n"); // Ambil bulan saat ini (1-12)
        $tahun_laporan = date("Y"); // Ambil tahun saat ini
        $sql_insert_laporan = "INSERT INTO laporan (id_kendaraan, nomor_plat, jenis_kendaraan, waktu_masuk, waktu_keluar, biaya_parkir, status, bulan_laporan, tahun_laporan) VALUES ('$id_kendaraan', '$nomor_plat', '$jenis_kendaraan', '$waktu_masuk', '$waktu_keluar', '$biaya_parkir', 'Keluar', '$bulan_laporan', '$tahun_laporan')";
        if ($conn->query($sql_insert_laporan) !== TRUE) {
            echo "Error: " . $sql_insert_laporan . "<br>" . $conn->error;
        }
    } else {
        echo "Data kendaraan tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Pembayaran</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Proses Pembayaran</h1>
    </header>
    <nav>
        <a href="index.php">Kembali ke Halaman Utama</a>
    </nav>
    <div class="container">
        <!-- Pesan hasil pembayaran akan ditampilkan di sini -->
    </div>

</body>
</html>

<?php
// Tutup koneksi database
$conn->close();
?>
