<?php require_once('config/main.php'); 
    
    require "function/pesan_kilat.php";
?>
<div class="d-flex justify-content-between flex-wrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="fa fa-history"></i> Riwayat Penjualan</h1>
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
                            <th scope="col">Tangal</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Total Harga</th>
                            <th scope="col">Nama Pembeli</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sql = "SELECT * FROM Transaksi ORDER by IDTransaksi DESC";
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
                            <td><?= $row['TanggalTransaksi']->format('d-m-Y'); ?></td>
                            <td>
                                <?php
                                    // Query untuk mengambil NamaPemasok dari tabel pemasok berdasarkan IDPemasok pada tabel produk
                                    $queryNamaProduk = "SELECT p.NamaProduk
                                                        FROM Transaksi tr
                                                        INNER JOIN Produk p ON tr.IDProduk = p.IDProduk
                                                        WHERE tr.IDProduk = ?";

                                    $paramsNamaProduk = array($row['IDProduk']);
                                    $resultNamaProduk = sqlsrv_query($conn, $queryNamaProduk, $paramsNamaProduk);

                                    if ($resultNamaProduk) {
                                        $rowNamaProduk = sqlsrv_fetch_array($resultNamaProduk, SQLSRV_FETCH_ASSOC);
                                        $namaProduk = $rowNamaProduk['NamaProduk'];

                                        // Gunakan $namaProduk sesuai kebutuhan Anda
                                        echo $namaProduk;
                                    } else {
                                        echo "Error: " . print_r(sqlsrv_errors(), true);
                                    }
                                ?>
                            </td>
                            <td><?=$row['Harga'];?></td>
                            <td><?=$row['Jumlah'];?></td>
                            <td><?=$row['TotalHarga'];?></td>
                            <td><?=$row['NamaPembeli'];?></td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>