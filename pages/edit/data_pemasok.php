<?php
require_once "config/main.php";
    $id = $_GET['id'];
    $query = "SELECT * FROM Pemasok WHERE IDPemasok = '$id'";
    $result = sqlsrv_query($conn, $query);
    $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Pemasok</h1>
            </div>
            <div class="card col-md-6">
                <div class="card-header">
                    Form Edit Pemasok
                </div>
                <div class="card-body">
                    <form action="simpan.php" method="post">
                        <input type="hidden" value='<?php echo $row['IDPemasok'];?>' name = 'id'>
                        <input type="hidden" name="type" value="data_pemasok">
	                    <input type="hidden" name="cmd" value="edit">
                        <div class="mb-3">
                            <label for="NamaPemasok" class="form-label">Nama Pemasok</label>
                            <input type="text" class = "form-control" name="NamaPemasok" value="<?= $row['NamaPemasok']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="Alamat" class="form-label">Alamat</label>
                            <textarea class = "form-control" name="Alamat" value="<?= $row['Alamat']; ?>"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="NomorTelepon" class="form-label">Nomor Telepon</label>
                            <input type="number" class = "form-control" name="NomorTelepon" value="<?= $row['NomorTelepon']; ?>"></input>
                        </div>
                        <div class="mb-3">
                            <label for="Email" class="form-label">Email</label>
                            <input type="email" class = "form-control" name="Email" value="<?= $row['Email']; ?>"></input>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i>
                            Ubah
                        </button>
                        <a href="index.php?page=data_pemasok" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i>Batal</a>
                    </form>
                </div>
            </div>