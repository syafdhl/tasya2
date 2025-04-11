<?php
session_start();

$barang = [
    ['nama' => 'Sleeping Beauty', 'harga' => 100000],
    ['nama' => 'The Secret Garden', 'harga' => 120000],
    ['nama' => 'The Paris Apartment', 'harga' => 110000],
    ['nama' => 'A Little Princess', 'harga' => 130000]
];

// Hapus riwayat jika tombol diklik
if (isset($_POST['hapus_riwayat'])) {
    unset($_SESSION['riwayat']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['index'])) {
    $i = $_POST['index'];
    $jumlah = (int)$_POST['jumlah'];
    $diskon = (int)$_POST['diskon'];

    $item = $barang[$i];
    $total = $item['harga'] * $jumlah * (1 - $diskon / 100);

    $hasil = [
        'nama' => $item['nama'],
        'harga' => $item['harga'],
        'jumlah' => $jumlah,
        'diskon' => $diskon,
        'total' => $total
    ];

    $_SESSION['riwayat'][] = $hasil;
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Katalog Buku</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Katalog Buku</h2>
    <div class="grid">
        <?php foreach ($barang as $i => $b) : ?>
            <div class="item">
                <h4><?= $b['nama']; ?></h4>
                <p>Rp <?= number_format($b['harga'], 0, ',', '.'); ?></p>
                <form method="post">
                    <input type="hidden" name="index" value="<?= $i; ?>">
                    <input type="number" name="jumlah" value="1" min="1" placeholder="Jumlah">
                    <input type="number" name="diskon" value="0" min="0" max="100" placeholder="Diskon %">
                    <button type="submit">Hitung</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (!empty($_SESSION['riwayat'])): ?>
    <div class="riwayat-container">
        <h3>Riwayat Transaksi</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th>Diskon (%)</th>
                    <th>Total Bayar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['riwayat'] as $r): ?>
                    <tr>
                        <td><?= $r['nama'] ?></td>
                        <td>Rp <?= number_format($r['harga'], 0, ',', '.') ?></td>
                        <td><?= $r['jumlah'] ?></td>
                        <td><?= $r['diskon'] ?>%</td>
                        <td>Rp <?= number_format($r['total'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <form method="post" style="margin-top: 15px;">
            <button type="submit" name="hapus_riwayat" onclick="return confirm('Yakin ingin menghapus semua riwayat?')">
                Hapus Riwayat
            </button>
        </form>
    </div>
    <?php endif; ?>
</div>
</body>
</html>
