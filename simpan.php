<?php 

require "config/main.php";
require "get_price.php";
$type = trim($_POST['type']);
$cmd = trim($_POST['cmd']);

switch ($type) {
	case 'data_produk':
		if ($cmd=="tambah") {
			if (isset($_POST['IDPemasok'])){
				$queryTambahProduk = "INSERT INTO Produk (NamaProduk, Deskripsi, Harga, JumlahStok, IDPemasok)
									  VALUES (?, ?, ?, ?, ?)";
			
				$params = array($_POST['NamaProduk'], $_POST['Deskripsi'], $_POST['Harga'], $_POST['JumlahStok'], $_POST['IDPemasok']);
			
				$result = sqlsrv_query($conn, $queryTambahProduk, $params);
				
				if ($result === false) {
					die(print_r(sqlsrv_errors(), true)); // Print errors for debugging purposes
				} else {
					$queryAudit = "INSERT INTO AuditLog (TableName, RecordID, ActionType, OldValue, NewValue, ModifiedBy, ModifiedAt)
									VALUES ('Produk', ?, 'INSERT', ?, ?, ?, GETDATE())";
					$paramsAudit = array($recordID, $oldValue, $_POST['NamaProduk'], $modifiedBy);

					$resultAudit = sqlsrv_query($conn, $queryAudit, $paramsAudit);
				}
			} else {
				echo "Pilih Pemasok tidak valid. Produk tidak dapat ditambahkan.";
			}
		}
		elseif($cmd=="edit") {
				$queryEditProduk = "UPDATE Produk SET NamaProduk=?, Deskripsi=?, Harga=?, JumlahStok=?, IDPemasok=?
									WHERE IDProduk=?";
				$params2 = array($_POST['NamaProduk'], $_POST['Deskripsi'], $_POST['Harga'], $_POST['JumlahStok'],$_POST['IDPemasok'], $_POST['id']);
				$result2 = sqlsrv_query($conn, $queryEditProduk, $params2);

				if (!$result2) {
					die(print_r(sqlsrv_errors(), true));
				}else{
					$queryAudit = "INSERT INTO AuditLog (TableName, RecordID, ActionType, OldValue, NewValue, ModifiedBy, ModifiedAt)
									VALUES ('Produk', ?, 'UPDATE', ?, ?, ?, GETDATE())";
					$paramsAudit = array($recordID, $oldValue, $_POST['NamaProduk'], $modifiedBy);

					$resultAudit = sqlsrv_query($conn, $queryAudit, $paramsAudit);
				}
		}
		else {
			die(); //jika bukan tambah atau edit, lalu apa ? die aja lah :p
		}
		header('Location:index.php?page=data_produk');
		break;
	case 'data_pemasok':
		if ($cmd=="tambah") {
			$queryTambahPemasok = "INSERT INTO Pemasok (NamaPemasok, Alamat, NomorTelepon, Email)
          	VALUES (?, ?, ?, ?)";

			$params = array($_POST['NamaPemasok'], $_POST['Alamat'], $_POST['NomorTelepon'], $_POST['Email']);

			$result = sqlsrv_query($conn, $queryTambahPemasok, $params);
			if ($result === false) {
				die(print_r(sqlsrv_errors(), true)); // Print errors for debugging purposes
			} else {
				$queryAudit = "INSERT INTO AuditLog (TableName, RecordID, ActionType, OldValue, NewValue, ModifiedBy, ModifiedAt)
									VALUES ('Pemasok', ?, 'INSERT', ?, ?, ?, GETDATE())";
				$paramsAudit = array($recordID, $oldValue, $_POST['NamaPemasok'], $modifiedBy);

				$resultAudit = sqlsrv_query($conn, $queryAudit, $paramsAudit);
			}
		}
		elseif($cmd=="edit") {
			$queryEditPemasok = "UPDATE Pemasok SET NamaPemasok=?, Alamat=?, NomorTelepon=?, Email=? 
                  				WHERE IDPemasok=?";
        	$params = array($_POST['NamaPemasok'], $_POST['Alamat'], $_POST['NomorTelepon'], $_POST['Email'], $_POST['id']);
        	$result = sqlsrv_query($conn, $queryEditPemasok, $params);

			if (!$result) {
				die(print_r(sqlsrv_errors(), true));
			}else {
				$queryAudit = "INSERT INTO AuditLog (TableName, RecordID, ActionType, OldValue, NewValue, ModifiedBy, ModifiedAt)
									VALUES ('Pemasok', ?, 'UPDATE', ?, ?, ?, GETDATE())";
					$paramsAudit = array($recordID, $oldValue, $_POST['NamaPemasok'], $modifiedBy);
					$resultAudit = sqlsrv_query($conn, $queryAudit, $paramsAudit);
			}
		}
		else {
			die(); //jika bukan tambah atau edit, lalu apa ? die aja lah :p
		}
		header('Location:index.php?page=data_pemasok');
		break;
	case 'transaksi':
		if ($cmd=="tambah") {
			$namaPembeli = $_POST['NamaPembeli'];
			$productID = $_POST['product_id'];
			$jumlahBarang = $_POST['JumlahBarang'];

			// Query untuk mendapatkan harga dan stok dari tabel Produk
			$queryProdukInfo = "SELECT Harga, JumlahStok FROM Produk WHERE IDProduk = ?";
			$paramsProdukInfo = array($productID);
			$resultProdukInfo = sqlsrv_query($conn, $queryProdukInfo, $paramsProdukInfo);

			if ($resultProdukInfo) {
				$rowProdukInfo = sqlsrv_fetch_array($resultProdukInfo, SQLSRV_FETCH_ASSOC);
				$hargaProduk = $rowProdukInfo['Harga'];
				$stokProduk = $rowProdukInfo['JumlahStok'];

				// Verifikasi apakah stok mencukupi
				if ($jumlahBarang <= $stokProduk) {
					// Kurangi stok pada tabel Produk
					$stokBaru = $stokProduk - $jumlahBarang;

					// Update stok pada tabel Produk
					$queryUpdateStok = "UPDATE Produk SET JumlahStok = ? WHERE IDProduk = ?";
					$paramsUpdateStok = array($stokBaru, $productID);
					$resultUpdateStok = sqlsrv_query($conn, $queryUpdateStok, $paramsUpdateStok);

					if ($resultUpdateStok) {
						// Query untuk menambahkan transaksi
						$queryTambahTransaksi = "INSERT INTO Transaksi (IDProduk, Harga, Jumlah, NamaPembeli)
												VALUES (?, ?, ?, ?)";
						$paramsTambahTransaksi = array($productID, $hargaProduk, $jumlahBarang, $namaPembeli);
						$resultTambahTransaksi = sqlsrv_query($conn, $queryTambahTransaksi, $paramsTambahTransaksi);

						if ($resultTambahTransaksi) {
							// Mendapatkan IDTransaksi yang baru saja dimasukkan
							$idTransaksi = sqlsrv_query($conn, "SELECT SCOPE_IDENTITY() AS IDTransaksi");
							$rowTransaksi = sqlsrv_fetch_array($idTransaksi, SQLSRV_FETCH_ASSOC);
							$idTransaksiBaru = $rowTransaksi['IDTransaksi'];
			
							// Memasukkan NamaPembeli ke dalam tabel Pembeli
							$queryTambahPembeli = "INSERT INTO Pembeli (IDTransaksi, NamaPembeli) VALUES (?, ?)";
							$paramsTambahPembeli = array($idTransaksiBaru, $namaPembeli);
							$resultTambahPembeli = sqlsrv_query($conn, $queryTambahPembeli, $paramsTambahPembeli);
			
							if ($resultTambahPembeli) {
								$queryAudit = "INSERT INTO AuditLog (TableName, RecordID, ActionType, OldValue, NewValue, ModifiedBy, ModifiedAt)
											VALUES ('Transaksi', ?, 'INSERT', ?, ?, ?, GETDATE())";
								$paramsAudit = array($recordID, $oldValue, $newValue, $modifiedBy);

								$resultAudit = sqlsrv_query($conn, $queryAudit, $paramsAudit);
							} else {
								echo "Error adding buyer: " . print_r(sqlsrv_errors(), true);
							}
						} else {
							echo "Error: " . print_r(sqlsrv_errors(), true);
						}
					} else {
						echo "Error updating stock: " . print_r(sqlsrv_errors(), true);
					}
				} else {
					echo "Stok tidak mencukupi untuk transaksi ini.";
				}
			} else {
				echo "Error: " . print_r(sqlsrv_errors(), true);
			}
			// } else {
			// 	echo "Error: " . print_r(sqlsrv_errors(), true);
			// }
			// }
		}
		elseif($cmd=="edit") {
			// mysql_query("UPDATE teknisi1 SET nama='$_POST[nama]'
			// WHERE id='$_POST[id]'");
		}
		else {
			die(); //jika bukan tambah atau edit, lalu apa ? die aja lah :p
		}
		header('Location:index.php?page=riwayat_penjualan');
		break;
	case 'spk':
		if ($cmd=="tambah") {
			mysql_query("INSERT INTO teknisi(nama,pelanggan,alamat,kontak,telp,tgl,jam,ket)
			VALUES('$_POST[nama]',
			'$_POST[pelanggan]',
			'$_POST[alamat]',
			'$_POST[kontak]',
			'$_POST[telepon]',
			'$_POST[tanggal]',
			'$_POST[jam]',
			'$_POST[ket]')");
		}
		elseif($cmd=="edit") {
			mysql_query("UPDATE teknisi SET nama='$_POST[nama]',
				pelanggan='$_POST[pelanggan]',
				alamat='$_POST[alamat]',
				kontak='$_POST[kontak]',
				telp='$_POST[telepon]',
				tgl='$_POST[tanggal]',
				jam='$_POST[jam]'
				WHERE id='$_POST[id]'");
		}
		else {
			die(); //jika bukan tambah atau edit, lalu apa ? die aja lah :p
		}
		header('Location:index.php?page=spk');
		break;
	case 'admin':
		if ($cmd=="tambah") {
			mysql_query("INSERT INTO admin(nama,username,password)
			VALUES('$_POST[nama]',
			'$_POST[username]',
			'$_POST[password]')");
		}
		elseif($cmd=="edit") {
			mysql_query("UPDATE admin SET nama='$_POST[nama]',
				username='$_POST[username]',
				password='$_POST[password]'
				WHERE id=".$_POST[id]);
			
		}
		else {
			die(); //jika bukan tambah atau edit, lalu apa ? die aja lah :p
		}
		header('Location:index.php?page=admin');
		break;
	
	default:
		require_once("pages/404.php");
		break;
}

 ?>