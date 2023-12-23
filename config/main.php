
<?php
$serverName = "HALUR-S-LAPTOP";
$connectionOptions = array(
    "Database" => "final_project",
);

// Membuat koneksi
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Memeriksa koneksi
if (!$conn){
    die(print_r(sqlsrv_errors(), true));
    }

// Menutup koneksi

?>