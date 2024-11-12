<?php
session_start();

// Inisialisasi variabel untuk transaksi
if (!isset($_SESSION['transaksi'])) {
    $_SESSION['transaksi'] = array();
}

// Jika form disubmit, ambil data dari input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = htmlspecialchars($_POST["nama"]);
    $harga = (int)$_POST["harga"];
    $jumlah = (int)$_POST["jumlah"];
    
    // Tambahkan transaksi ke array sesi
    $_SESSION['transaksi'][] = array("nama" => $nama, "harga" => $harga, "jumlah" => $jumlah);
}

// Menghitung total penjualan
$total_penjualan = 0;
foreach ($_SESSION['transaksi'] as $t) {
    $total_penjualan += $t["harga"] * $t["jumlah"];
}

// Menampilkan form input dengan urutan yang dimodifikasi
echo '<h2>Laporan Penjualan</h2>';
echo '<form method="post" action="">';
echo 'Jumlah Terjual: <input type="number" name="jumlah" required><br>';
echo 'Harga Per Produk: <input type="number" name="harga" required><br>';
echo 'Nama Produk: <input type="text" name="nama" required><br>';
echo '<input type="submit" value="Tambah Transaksi">';
echo '</form>';


// Menampilkan laporan penjualan dalam bentuk tabel HTML
if (!empty($_SESSION['transaksi'])) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>Nama</th><th>Harga Per Produk</th><th>Jumlah Terjual</th><th>Total</th></tr>";

    foreach ($_SESSION['transaksi'] as $t) {
        $total_produk = $t["harga"] * $t["jumlah"];
        echo "<tr>";
        echo "<td>" . htmlspecialchars($t["nama"]) . "</td>";
        echo "<td>Rp " . htmlspecialchars(number_format($t["harga"], 0, ',', '.')) . "</td>";
        echo "<td>" . htmlspecialchars($t["jumlah"]) . "</td>";
        echo "<td>Rp " . htmlspecialchars(number_format($total_produk, 0, ',', '.')) . "</td>";
        echo "</tr>";
    }

    echo "<tr><td colspan='3'>Total Penjualan</td><td>Rp " . htmlspecialchars(number_format($total_penjualan, 0, ',', '.')) . "</td></tr>";
    echo "</table>";
}
?>