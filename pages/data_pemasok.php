<?php require_once('config/main.php'); ?>
<div class="d-flex justify-content-between flex-wrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="fa fa-group"></i> Data Pemasok</h1>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <a class="btn btn-success" href="tambah.php?tambah=data_pemasok">
                        <i class="fa fa-plus"></i> Tambah Pemasok
                    </a>
                </div>
            </div>
            <?php
            if (isset($_SESSION['_flashdata'])) {
                echo "<br>";
                foreach ($_SESSION["_flashdata"] as $key => $val) {
                    // echo get_flashdata($key);
                }
            }
            ?>
            <div class="table-responsive small">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">No. Telepon</th>
                            <th scope="col">Email</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sql = "SELECT * FROM Pemasok ORDER by IDPemasok";
                        $query = sqlsrv_query($conn, $sql);

                        if ($query === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }

                        // Periksa apakah $query adalah sumber daya yang valid sebelum menggunakan sqlsrv_fetch_array
                        if ($query) {
                            while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                        // $query = "SELECT * FROM Produk order by id desc";
                        // $result = sqlsrv_query($conn, $query);
                        // while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <th scope='row'><?= $no++; ?></th>
                            <td><?=$row['NamaPemasok'];?></td>
                            <td><?=$row['Alamat'];?></td>
                            <td><?=$row['NomorTelepon'];?></td>
                            <td><?=$row['Email'];?></td>
                            <td>
                                <a href="edit.php?edit=data_pemasok&id=<?php echo $row['IDPemasok']; ?>" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    Edit
                                </a>
                                <a href="hapus.php?hapus=data_pemasok&id=<?php echo $row['IDPemasok']; ?>" onclick="javascript:return confirm('Hapus Data Produk Ini ?');" class="btn btn-danger btn-xs">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    Hapus
                                </a>
                            </td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>