<?php
// Sertakan file koneksi.php untuk terhubung ke database
require_once('koneksi.php');

// Inisialisasi variabel
$nama = $jabatan = $email = $telepon = '';
$nama_err = $jabatan_err = $email_err = $telepon_err = '';
$success_message = '';

// Proses saat formulir disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi nama
    if (empty(trim($_POST["nama"]))) {
        $nama_err = "Masukkan nama petugas.";
    } else {
        $nama = trim($_POST["nama"]);
    }

    // Validasi jabatan
    if (empty(trim($_POST["jabatan"]))) {
        $jabatan_err = "Masukkan jabatan petugas.";
    } else {
        $jabatan = trim($_POST["jabatan"]);
    }

    // Validasi email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Masukkan alamat email petugas.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validasi telepon
    if (empty(trim($_POST["telepon"]))) {
        $telepon_err = "Masukkan nomor telepon petugas.";
    } else {
        $telepon = trim($_POST["telepon"]);
    }

    // Jika tidak ada kesalahan validasi, tambahkan data ke database
    if (empty($nama_err) && empty($jabatan_err) && empty($email_err) && empty($telepon_err)) {
        // Query untuk menyimpan data petugas ke database
        $sql = "INSERT INTO petugas (nama, jabatan, email, telepon) VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind parameter ke query
            $stmt->bind_param("ssss", $param_nama, $param_jabatan, $param_email, $param_telepon);

            // Set parameter
            $param_nama = $nama;
            $param_jabatan = $jabatan;
            $param_email = $email;
            $param_telepon = $telepon;

            // Eksekusi query
            if ($stmt->execute()) {
                // Set pesan sukses
                $success_message = "Data petugas berhasil disimpan.";

                // Kosongkan nilai variabel
                $nama = $jabatan = $email = $telepon = '';
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
    <title>Tambah Petugas Baru</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            margin: 0 auto;
            width: 50%;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="email"] {
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
        <h1>Tambah Petugas Baru</h1>
    </header>
    <div class="container">
        <?php if (!empty($success_message)) : ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($nama_err)) ? 'has-error' : ''; ?>">
                <label>Nama Petugas</label>
                <input type="text" name="nama" value="<?php echo $nama; ?>">
                <span class="help-block"><?php echo $nama_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($jabatan_err)) ? 'has-error' : ''; ?>">
                <label>Jabatan Petugas</label>
                <input type="text" name="jabatan" value="<?php echo $jabatan; ?>">
                <span class="help-block"><?php echo $jabatan_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email Petugas</label>
                <input type="email" name="email" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($telepon_err)) ? 'has-error' : ''; ?>">
                <label>Telepon Petugas</label>
                <input type="text" name="telepon" value="<?php echo $telepon; ?>">
                <span class="help-block"><?php echo $telepon_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn-submit" value="Tambah Petugas">
            </div>
        </form>
    </div>
</body>
</html>
