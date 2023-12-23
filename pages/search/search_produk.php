<?php require_once('config/main.php');

?>
<div class="d-flex justify-content-between flex-wrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="fa fa-th-large" aria-hidden="true" ></i> Data Produk</h1>
            </div>
            <br>
            <form method="post" action="search.php" role="form">
                <input type="text" name="keyword" class="form-control mb-1" value="<?= $_POST['keyword']?>" required>
                <button type="submit" class="btn btn-primary" >Cari</button>
            </form>
            <br>
            <div class="row">
                <div class="col-lg-2">
                    <a class="btn btn-success" href="tambah.php?tambah=data_produk">
                        <i class="fa fa-plus"></i> Tambah Produk
                    </a>
                </div>
            </div>
            <div class="bg-white">
            <?php
            if (isset($_SESSION['_flashdata'])) {
                echo "<br>";
                foreach ($_SESSION["_flashdata"] as $key => $val) {
                    echo get_flashdata($key);
                }
            }
            ?>
            </div>
            <div class="table-responsive small">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Jumlah Stok</th>
                            <th scope="col">Supplier</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        
                        $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
                        // Query untuk mencari produk berdasarkan nama, harga, atau kategori
                        $query = "SELECT pr.*, p.NamaPemasok
                                    FROM Produk pr
                                    INNER JOIN Pemasok p ON pr.IDPemasok = p.IDPemasok
                                    WHERE pr.NamaProduk LIKE '%' + ? + '%'
                                        OR pr.Harga LIKE '%' + ? + '%'
                                        OR pr.Deskripsi LIKE '%' + ? + '%'";
                        $params = array($keyword, $keyword, $keyword);

                        $result1 = sqlsrv_query($conn, $query, $params);

                        if ($result1) {
                            while ($row = sqlsrv_fetch_array($result1, SQLSRV_FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <th scope='row'><?= $no++; ?></th>
                            <td><?=$row['NamaProduk'];?></td>
                            <td><?=$row['Deskripsi'];?></td>
                            <td><?=$row['Harga'];?></td>
                            <td><?=$row['JumlahStok'];?></td>
                            <td>
                                <?php
                                // Query untuk mengambil NamaPemasok dari tabel pemasok berdasarkan IDPemasok pada tabel produk
                                $query1 = "SELECT p.NamaPemasok
                                        FROM Produk pr
                                        INNER JOIN Pemasok p ON pr.IDPemasok = p.IDPemasok
                                        WHERE pr.IDPemasok = " . $row['IDPemasok'];

                                // Eksekusi query
                                $result = sqlsrv_query($conn, $query1);

                            
                                    // Ambil data hasil query
                                $pemasok = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

                                    // Tampilkan NamaPemasok
                                    echo $pemasok['NamaPemasok'];
                                ?>
                            </td>
                            <td>
                                <a class="btn btn-warning btn-xs" href="edit.php?edit=data_produk&id=<?php echo $row['IDProduk']; ?>">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    Edit
                                </a>
                                <a href="hapus.php?hapus=data_produk&id=<?php echo $row['IDProduk'];?>" onclick="javascript:return confirm('Hapus Data Produk Ini ?');" class="btn btn-danger btn-xs">
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