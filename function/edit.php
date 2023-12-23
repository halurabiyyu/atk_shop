<?php
session_start();
require '../config/main.php';
require '../function/pesan_kilat.php';
require '../function/anti_injection.php';
if (!empty($_GET['data_produk'])) {
    // Menggunakan 'data_produk' sebagai kunci yang sesuai dengan URL
    $id = antiinjection($conn, $_POST['id']);
    
    // Peroleh nilai yang sesuai dari $_POST atau $_GET (sesuaikan dengan metode yang digunakan pada form)
    $NamaProduk = antiinjection($conn, $_POST['NamaProduk']);
    $Deskripsi = antiinjection($conn, $_POST['Deskripsi']);
    $Harga = antiinjection($conn, $_POST['Harga']);
    $JumlahStok = antiinjection($conn, $_POST['JumlahStok']);

    // Query UPDATE dengan menggunakan prepared statement
    $query = "UPDATE Produk SET NamaProduk = '$NamaProduk', Deskripsi = '$Deskripsi', Harga = '$Harga', JumlahStok = '$JumlahStok' WHERE IDProduk = '$id'";
    
    // Prepare the statement
    $stmt = sqlsrv_prepare($conn, $query);

    // Execute the statement
    if (sqlsrv_execute($stmt)) {
        pesan('success', "Produk Telah Diubah.");
    } else {
        pesan('danger', 'Produk Tidak Terubah Karena: ' . print_r(sqlsrv_errors(), true));
    }

    header('Location: ../index.php?page=data_produk');
}
?>