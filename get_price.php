<?php
require_once('config/main.php');
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $query = "SELECT Harga FROM Produk WHERE IDProduk = ?";
    $params = array($product_id);

    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $harga_produk = $row['Harga'];
        echo "Rp. " .  $harga_produk;
    } else {
        echo "Produk tidak ditemukan atau harga tidak tersedia.";
    }

    sqlsrv_free_stmt($stmt);
} else {
    echo "Invalid product ID.";
}
?>