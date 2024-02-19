<?php
// Sertakan file koneksi.php untuk terhubung ke database
require_once('koneksi.php');

// Inisialisasi variabel
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

// Query untuk mengambil data laporan berdasarkan bulan dan tahun, diurutkan berdasarkan waktu keluar secara descending
$sql = "SELECT * FROM laporan WHERE bulan_laporan = $bulan AND tahun_laporan = $tahun ORDER BY waktu_keluar DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bulanan</title>
    <link rel="stylesheet" href="style.css">
    <style>
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

        form {
            margin-bottom: 20px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
        }

        form select, form input[type="submit"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>
    <header>
        <h1>Laporan Bulanan</h1>
    </header>
    <div class="container">
        <form action="" method="get">
            <label for="bulan">Pilih Bulan:</label>
            <select name="bulan" id="bulan">
                <?php
                // Generate dropdown untuk pilihan bulan
                for ($i = 1; $i <= 12; $i++) {
                    $selected = ($i == $bulan) ? "selected" : "";
                    echo "<option value='$i' $selected>" . date('F', mktime(0, 0, 0, $i, 1)) . "</option>";
                }
                ?>
            </select>
            <label for="tahun">Pilih Tahun:</label>
            <select name="tahun" id="tahun">
                <?php
                // Generate dropdown untuk pilihan tahun (dari tahun 2020 hingga tahun sekarang)
                $tahun_sekarang = date('Y');
                for ($i = 2020; $i <= $tahun_sekarang; $i++) {
                    $selected = ($i == $tahun) ? "selected" : "";
                    echo "<option value='$i' $selected>$i</option>";
                }
                ?>
            </select>
            <input type="submit" value="Tampilkan Laporan">
        </form>
        
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
        <form action="cetak_laporan.php" method="get" target="_blank">
            <input type="hidden" name="bulan" value="<?php echo $bulan; ?>">
            <input type="hidden" name="tahun" value="<?php echo $tahun; ?>">
            <input type="submit" value="Cetak Laporan">
        </form>
    </div>
</body>
</html>

<?php
// Tutup koneksi database
$conn->close();
?>
