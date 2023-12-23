<?php
require_once('config/main.php');
require "function/pesan_kilat.php";


?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Tambah Produk</h1>
            </div>
            <div class="card col-md-6">
                <div class="card-header">
                    Form Tambah Produk
                </div>
                <div class="card-body">
                    <form action="simpan.php" method="post" role="form">
                        <input type="hidden" name="type" value="data_produk">
                        <input type="hidden" name="cmd" value="tambah">
                        <div class="mb-3">
                            <label for="NamaProduk" class="form-label">Nama Produk</label>
                            <input type="text" class = "form-control" name="NamaProduk" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <input class = "form-control" name="Deskripsi" required></input>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class = "form-control" name="Harga" require></input>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">Jumlah Stok</label>
                            <input type="number" class = "form-control" name="JumlahStok" required></input>
                        </div>
                        <div class="mb-3">
                            <label for="NamaPemasok" class="form-label">Nama Pemasok</label>
                            <select class="form-select" name="IDPemasok" id="IDPemasok" name aria-label="Default select example" required>
                                <option disabled selected>Pilih Pemasok</option>
                                <?php
                                    $query = "SELECT * FROM Pemasok order by IDPemasok asc";
                                    $result = sqlsrv_query($conn, $query);
                                    
                                    // while () {
                                    while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                ?>
                                <option value="<?= $row['IDPemasok']; ?>"><?= $row['NamaPemasok']; ?></option>    
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i>
                            Tambah
                        </button>
                        <a href="index.php?pages=data_produk" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i>Batal</a>
                    </form>
                </div>
            </div>