<?php
// Sertakan file koneksi.php untuk terhubung ke database
require_once('koneksi.php');

// Query untuk mengambil data petugas dari database
$sql = "SELECT * FROM petugas";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Petugas</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            text-align: center;
        }

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
        <h1>Daftar Petugas</h1>
    </header>
    <div class="container">
        <table>
            <tr>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Email</th>
                <th>Telepon</th>
            </tr>
            <?php
            // Periksa apakah ada baris data yang diambil dari database
            if ($result->num_rows > 0) {
                // Output data dari setiap baris
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["nama"] . "</td>";
                    echo "<td>" . $row["jabatan"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["telepon"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Tidak ada data petugas</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
// Tutup koneksi database
$conn->close();
?>
