<?php 

if (isset($_GET['page'])) {
	switch ($_GET['page']) {
		case 'transaksi':
			$title = "Transaksi";
			break;
		case 'data_produk':
			$title = "Data Produk";
			break;
		case 'data_pemasok':
			$title = "Data Pemasok";
			break;
		case 'riwayat':
			$title = "Riwayat Penjualan";
			break;
		
		default:
			$title = "Halaman Tidak Ditemukan";
			break;
	}
	echo $title;
}
else {
	echo "Halaman Utama";
}

 ?>