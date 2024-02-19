<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <style>
        /* CSS untuk styling navbar */
        nav {
            background-color: #333;
            overflow: hidden;
        }

        nav a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        nav a:hover {
            background-color: #ddd;
            color: black;
        }
    </style>
</head>
<body>
    <nav>
        <a href="index.php">Halaman Utama</a>
        <a href="daftar_kendaraan.php">Daftar Kendaraan</a>
        <a href="tambah_kendaraan.php">Tambah Kendaraan</a>
        <a href="daftar_petugas.php">Daftar Petugas</a>
        <a href="tambah_petugas.php">Tambah Petugas</a>
        <a href="pembayaran.php">Pembayaran</a>
        <a href="laporan.php">Laporan</a>
    </nav>
</body>
</html>
