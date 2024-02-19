<!DOCTYPE html>
<html lang="en">
<head>
<?php
// Sertakan file koneksi.php untuk terhubung ke database
require_once('koneksi.php');

// Inisialisasi variabel
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

// Query untuk mengambil data laporan berdasarkan bulan dan tahun
$sql = "SELECT * FROM laporan WHERE bulan_laporan = $bulan AND tahun_laporan = $tahun ORDER BY waktu_keluar DESC";
$result = $conn->query($sql);
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Bulanan</title>
    <style>
        /* Style untuk tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
            text-align: center;
        }

        th, td {
            padding: 10px;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Style untuk tombol cetak */
        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .button-container button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .button-container button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <h1>Laporan Bulanan</h1>
        <h3>Bulan: <?php echo date('F', mktime(0, 0, 0, $bulan, 1)) . " " . $tahun; ?></h3>
    </header>
    <table>
        <tr>
            <th>Nomor Plat</th>
            <th>Jenis Kendaraan</th>
            <th>Waktu Masuk</th>
            <th>Waktu Keluar</th>
            <th>Biaya Parkir</th>
            <th>Status</th>
        </tr>
        <?php
        // Periksa apakah ada baris data yang diambil dari database
        if ($result->num_rows > 0) {
            // Output data dari setiap baris
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["nomor_plat"] . "</td>";
                echo "<td>" . $row["jenis_kendaraan"] . "</td>";
                echo "<td>" . $row["waktu_masuk"] . "</td>";
                echo "<td>" . $row["waktu_keluar"] . "</td>";
                echo "<td>" . $row["biaya_parkir"] . "</td>";
                echo "<td>" . $row["status"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Tidak ada data laporan</td></tr>";
        }
        ?>
    </table>
    <!-- Tombol untuk mencetak laporan -->
    <div class="button-container">
        <button onclick="cetakLaporan()">Cetak Laporan</button>
    </div>

    <!-- Script untuk menutup halaman setelah mencetak -->
    <script>
        function cetakLaporan() {
            window.print(); // Mencetak laporan
            setTimeout(function(){
                window.close(); // Menutup halaman setelah mencetak
            }, 1000); // Mengatur waktu penutupan setelah 1 detik
        }
    </script>
</body>
</html>

<?php
// Tutup koneksi database
$conn->close();
?>
