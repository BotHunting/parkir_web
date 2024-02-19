<?php
// Sertakan file koneksi.php untuk terhubung ke database
require_once('koneksi.php');

// Query untuk mengambil data kendaraan dari database
$sql_kendaraan = "SELECT * FROM kendaraan";
$result_kendaraan = $conn->query($sql_kendaraan);

// Query untuk mengambil data petugas dari database
$sql_petugas = "SELECT * FROM petugas";
$result_petugas = $conn->query($sql_petugas);

// Fungsi untuk menghitung biaya parkir berdasarkan jenis kendaraan dan waktu parkir
function hitungBiayaParkir($jenis_kendaraan, $durasi) {
    // Anda dapat menyesuaikan tarif parkir sesuai dengan jenis kendaraan dan waktu parkir
    $tarif_motor = 2000; // Tarif parkir per jam untuk motor
    $tarif_mobil = 3000; // Tarif parkir per jam untuk mobil

    if ($jenis_kendaraan == 'Motor') {
        return $tarif_motor * $durasi; // Biaya parkir untuk motor
    } elseif ($jenis_kendaraan == 'Mobil') {
        return $tarif_mobil * $durasi; // Biaya parkir untuk mobil
    } else {
        return 0; // Jika jenis kendaraan tidak dikenali
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Parkir</title>
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

        .form-group select,
        .form-group input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
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

        .form-group .help-block {
            color: red;
        }
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>
    <header>
        <h1>Pembayaran Parkir</h1>
    </header>
    <div class="container">
        <form method="post" action="proses_pembayaran.php">
            <div class="form-group">
                <label for="kendaraan">Pilih Kendaraan:</label>
                <select id="kendaraan" name="kendaraan" required>
                    <option value="">Pilih Kendaraan</option>
                    <?php
                    // Output data dari setiap baris kendaraan
                    while($row_kendaraan = $result_kendaraan->fetch_assoc()) {
                        echo "<option value='" . $row_kendaraan["id"] . "' data-jenis='" . $row_kendaraan["jenis_kendaraan"] . "'>" . $row_kendaraan["nomor_plat"] . " - " . $row_kendaraan["jenis_kendaraan"] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="biaya">Biaya yang Harus Dibayar:</label>
                <input type="text" id="biaya" name="biaya" readonly>
            </div>

            <div class="form-group">
                <label for="petugas">Pilih Petugas:</label>
                <select id="petugas" name="petugas" required>
                    <option value="">Pilih Petugas</option>
                    <?php
                    // Output data dari setiap baris petugas
                    while($row_petugas = $result_petugas->fetch_assoc()) {
                        echo "<option value='" . $row_petugas["id"] . "'>" . $row_petugas["nama"] . " - " . $row_petugas["jabatan"] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <input type="submit" class="btn-submit" value="Proses Pembayaran">
            </div>
        </form>
    </div>

    <script>
        // Mengambil elemen select untuk kendaraan
        const kendaraanSelect = document.getElementById('kendaraan');
        // Mengambil elemen input untuk biaya
        const biayaInput = document.getElementById('biaya');

        // Mendengarkan perubahan pada select kendaraan
        kendaraanSelect.addEventListener('change', function() {
            // Mengambil jenis kendaraan dari atribut data
            const jenisKendaraan = kendaraanSelect.options[kendaraanSelect.selectedIndex].dataset.jenis;
            // Mengatur tarif parkir per jam berdasarkan jenis kendaraan
            let tarif;
            if (jenisKendaraan === 'Motor') {
                tarif = 2000; // Tarif parkir per jam untuk motor
            } else if (jenisKendaraan === 'Mobil') {
                tarif = 3000; // Tarif parkir per jam untuk mobil
            }
            // Menetapkan nilai biaya awal
            biayaInput.value = tarif;
        });
    </script>
</body>
</html>

<?php
// Tutup koneksi database
$conn->close();
?>
