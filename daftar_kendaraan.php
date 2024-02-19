<?php
// sertakan file koneksi.php untuk terhubung ke database
require_once('koneksi.php');

// query untuk mengambil data kendaraan dari database
$sql = "select * from kendaraan";
$result = $conn->query($sql);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>daftar kendaraan</title>
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
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>
    <header>
        <h1>daftar kendaraan</h1>
    </header>
    <div class="container">
        <table>
            <tr>
                <th>nomor plat</th>
                <th>jenis kendaraan</th>
                <th>waktu masuk</th>
                <th>status</th>
                <th>biaya</th>
            </tr>
            <?php
            // periksa apakah ada baris data yang diambil dari database
            if ($result->num_rows > 0) {
                // output data dari setiap baris
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["nomor_plat"] . "</td>";
                    echo "<td>" . $row["jenis_kendaraan"] . "</td>";
                    echo "<td>" . $row["waktu_masuk"] . "</td>";
                    echo "<td>" . $row["status"] . "</td>";
                    // hitung biaya parkir berdasarkan jenis kendaraan
                    $biaya = hitungbiayaparkir($row["jenis_kendaraan"]);
                    echo "<td>" . $biaya . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>tidak ada data kendaraan</td></tr>";
            }

            // fungsi untuk menghitung biaya parkir berdasarkan jenis kendaraan
            function hitungbiayaparkir($jenis_kendaraan) {
                // anda dapat menyesuaikan tarif parkir sesuai dengan jenis kendaraan
                if ($jenis_kendaraan == 'motor') {
                    return 2000; // contoh tarif parkir untuk motor
                } elseif ($jenis_kendaraan == 'mobil') {
                    return 3000; // contoh tarif parkir untuk mobil
                } else {
                    return 0; // jika jenis kendaraan tidak dikenali
                }
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
// tutup koneksi database
$conn->close();
?>
