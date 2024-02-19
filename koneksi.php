<?php
// Informasi database
$servername = "localhost"; // Ganti dengan nama server database Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$database = "parkir_dishub"; // Ganti dengan nama database Anda

// Mengecek koneksi
$ping = shell_exec("ping -n 1 $servername");
if (strpos($ping, "TTL")) {
    $status_color = "green";
    $status_message = "Online";
} elseif (strpos($ping, "Request timed out")) {
    $status_color = "red";
    $status_message = "Offline";
} else {
    $status_color = "orange";
    $status_message = "Midle";
}

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    echo "<span style='color: red;'>Koneksi gagal: " . $conn->connect_error . "</span>";
} else {
    echo "<span style='color: $status_color;'>$status_message</span>";
}

// Jika Anda ingin menggunakan koneksi ini di file lain, cukup sertakan baris berikut:
// require_once('koneksi.php');
?>
