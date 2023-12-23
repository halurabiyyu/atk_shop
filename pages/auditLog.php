<?php require_once('config/main.php'); 
    
    require "function/pesan_kilat.php";
?>
<div class="d-flex justify-content-between flex-wrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="fa fa-book"></i> Catatan Audit</h1>
            </div>
            <div class="row">
                <!-- <div class="col-lg-2">
                    <a class="btn btn-success" href="tambah.php?tambah=data_produk">
                        <i class="fa fa-plus"></i> Tambah Produk
                    </a>
                </div> -->
            </div>
            <div class="bg-white">
            <?php
            // echo $resultTambahTransaksi
            
            ?>
            </div>
            <div class="table-responsive small">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Tanggal Berubah</th>
                            <th scope="col">Nama Tabel</th>
                            <th scope="col">Log ID</th>
                            <th scope="col">Item Berubah</th>
                            <th scope="col">Tipe Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sql = "SELECT * FROM AuditLog ORDER by LogID DESC";
                        $query = sqlsrv_query($conn, $sql);

                        if ($query === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }

                        // Periksa apakah $query adalah sumber daya yang valid sebelum menggunakan sqlsrv_fetch_array
                        if ($query) {
                            while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <th scope='row'><?= $no++; ?></th>
                            <td><?= $row['ModifiedAt']->format('d-m-Y'); ?></td>
                            <td><?=$row['TableName'];?></td>
                            <td><?=$row['LogID'];?></td>
                            <td><?=$row['NewValue'];?></td>
                            <td><?=$row['ActionType'];?></td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>