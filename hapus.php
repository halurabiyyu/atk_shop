<?php 
if (isset($_GET['hapus'])) {
	require "config/main.php";
	switch ($_GET['hapus']) {
		case 'data_produk':
			
			$query1 = "DELETE FROM Produk WHERE IDProduk =" . $_GET['id'];
			$result1 = sqlsrv_query($conn, $query1);

			if ($result1 === false) {
				die(print_r(sqlsrv_errors(), true));
			}else {
				$queryAudit = "INSERT INTO AuditLog (TableName, RecordID, ActionType, OldValue, NewValue, ModifiedBy, ModifiedAt)
									VALUES ('Produk', ?, 'DELETE', ?, ?, ?, GETDATE())";
					$paramsAudit = array($recordID, $oldValue, $_POST['NamaProduk'], $modifiedBy);

					$resultAudit = sqlsrv_query($conn, $queryAudit, $paramsAudit);
			}
			header('Location:index.php?page=data_produk');
			break;
		case 'data_pemasok':
			$query2 = "DELETE FROM Pemasok WHERE IDPemasok =" . $_GET['id'];
			$result2 = sqlsrv_query($conn, $query2);

			if ($result2 === false) {
				die(print_r(sqlsrv_errors(), true));
			}else {
				$queryAudit = "INSERT INTO AuditLog (TableName, RecordID, ActionType, OldValue, NewValue, ModifiedBy, ModifiedAt)
									VALUES ('Pemasok', ?, 'DELETE', ?, ?, ?, GETDATE())";
					$paramsAudit = array($recordID, $oldValue, $_POST['NamaPemasok '], $modifiedBy);

					$resultAudit = sqlsrv_query($conn, $queryAudit, $paramsAudit);
			}
			header('Location:index.php?page=data_pemasok');
			break;
		default:
			require_once("pages/404.php");
			break;
	}
}
else {
	require_once("pages/home.php");
}
 ?>