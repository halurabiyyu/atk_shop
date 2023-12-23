<?php
session_start();
    require "../config/main.php";
    require "../function/pesan_kilat.php";
    require "../function/anti_injection.php";

    if (!empty($_GET["jabatan"])) {
        $jabatan = antiinjection($conn, $_POST['jabatan']);
        $keterangan = antiinjection($conn, $_POST['keterangan']);
        $query = "INSERT INTO jabatan(jabatan, keterangan) VALUES('$jabatan', '$keterangan')";
        if (mysqli_query($koneksi, $query)) {
            pesan('success', "Jabatan Baru Ditambahkan.");
        } else {
            pesan('danger', "Menambahkan Jabatan Karena: " . mysqli_error($koneksi));
        }
        header("Location: ../index.php?page=jabatan");
    }

    else if(!empty($_GET['data_produk'])) {
        $id = antiinjection($conn, $_GET['id']);
        
    
        // Peroleh nilai yang sesuai dari $_POST atau $_GET (sesuaikan dengan metode yang digunakan pada form)
        $NamaProduk = antiinjection($conn, $_POST['NamaProduk']);
        $Deskripsi = antiinjection($conn, $_POST['Deskripsi']);
        $Harga = antiinjection($conn, $_POST['Harga']);
        $JumlahStok = antiinjection($conn, $_POST['JumlahStok']);
    
        // Query UPDATE dengan menggunakan prepared statement
        $query = "INSERT INTO Produk VALUES ('$NamaProduk', '$Deskripsi', '$Harga', '$JumlahStok') WHERE IDProduk = '$id'";
        
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