<?php
require "config/main.php";

$user 	= $_POST['tUser'];
$pwd   	= $_POST['tPwd'];

$query = "SELECT * FROM pengguna WHERE username='$user' AND password = '$pwd'";
$result = sqlsrv_query($conn, $query);
if (sqlsrv_has_rows($result)) {
	$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

	// Verifikasi kata sandi
	if (isset($pwd)) {
		// Login berhasil, simpan informasi pengguna ke sesi
		$_SESSION['user_id'] = $row['Id'];
		$_SESSION['username'] = $row['Username'];

		// Redirect ke halaman utama atau halaman setelah login
		header("Location: index.php");
		exit();
	} else {
		header("Location: login.php");
		$error = "Pengguna tidak ditemukan";
	}
} else {
	header("Location: login.php");
	$error = "Pengguna tidak ditemukan";
}
// $hasil  = mysql_query("SELECT * FROM admin WHERE username='$user' AND
// 						password='$pwd'");
// $hitung = mysql_num_rows($hasil);
// $data   = mysql_fetch_array($hasil);

// if ($hitung > 0){
// 	session_start();
// 	$_SESSION['username'] = $data['username'];
// 	$_SESSION['password'] = $data['password'];
// 	$_SESSION['nama'] = $data['nama'];
	
// 	header('Location:index.php');
// }else{
//    echo "<script>alert('GAGAL..!!!!!, Silakan Ulangi Lagi'); window.location = 'login.php'</script>";
// }
?>