<?php
// Sertakan file koneksi.php untuk terhubung ke database
require_once('koneksi.php');

// Inisialisasi variabel
$nomor_plat = $jenis_kendaraan = '';
$nomor_plat_err = $jenis_kendaraan_err = '';
$success_message = '';

// Proses saat formulir disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi Nomor Plat
    if (empty(trim($_POST["nomor_plat"]))) {
        $nomor_plat_err = "Masukkan nomor plat kendaraan.";
    } else {
        $nomor_plat = trim($_POST["nomor_plat"]);
    }

    // Validasi Jenis Kendaraan
    if (empty(trim($_POST["jenis_kendaraan"]))) {
        $jenis_kendaraan_err = "Pilih jenis kendaraan.";
    } else {
        $jenis_kendaraan = trim($_POST["jenis_kendaraan"]);
    }

    // Jika tidak ada kesalahan validasi, tambahkan data ke database
    if (empty($nomor_plat_err) && empty($jenis_kendaraan_err)) {
        // Query untuk menyimpan data kendaraan ke database
        $sql = "INSERT INTO kendaraan (nomor_plat, jenis_kendaraan, waktu_masuk, status) VALUES (?, ?, NOW(), 'Masuk')";

        if ($stmt = $conn->prepare($sql)) {
            // Bind parameter ke query
            $stmt->bind_param("ss", $param_nomor_plat, $param_jenis_kendaraan);

            // Set parameter
            $param_nomor_plat = $nomor_plat;
            $param_jenis_kendaraan = $jenis_kendaraan;

            // Eksekusi query
            if ($stmt->execute()) {
                // Set pesan sukses
                $success_message = "Data kendaraan berhasil disimpan.";

                // Kosongkan nilai variabel
                $nomor_plat = $jenis_kendaraan = '';
            } else {
                echo "Terjadi kesalahan. Silakan coba lagi.";
            }

            // Tutup statement
            $stmt->close();
        }
    }

    // Tutup koneksi database
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kendaraan Baru</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-group .help-block {
            color: red;
        }

        .form-group .btn-submit {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-group .btn-submit:hover {
            background-color: #45a049;
        }

        .success-message {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>
    <header>
        <h1>Tambah Kendaraan Baru</h1>
    </header>
    <div class="container">
        <?php if (!empty($success_message)) : ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($nomor_plat_err)) ? 'has-error' : ''; ?>">
                <label>Nomor Plat</label>
                <input type="text" name="nomor_plat" value="<?php echo $nomor_plat; ?>">
                <span class="help-block"><?php echo $nomor_plat_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($jenis_kendaraan_err)) ? 'has-error' : ''; ?>">
                <label>Jenis Kendaraan</label>
                <select name="jenis_kendaraan">
                    <option value="">Pilih Jenis Kendaraan</option>
                    <option value="Motor" <?php if ($jenis_kendaraan == 'Motor') echo 'selected'; ?>>Motor</option>
                    <option value="Mobil" <?php if ($jenis_kendaraan == 'Mobil') echo 'selected'; ?>>Mobil</option>
                </select>
                <span class="help-block"><?php echo $jenis_kendaraan_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn-submit" value="Tambah Kendaraan">
            </div>
        </form>
    </div>
</body>
</html>
