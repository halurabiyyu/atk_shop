<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Tambah Pemasok</h1>
            </div>
            <div class="card col-md-6">
                <div class="card-header">
                    Form Tambah Pemasok
                </div>
                <div class="card-body">
                    <form action="simpan.php" role="form" method="post">
                        <input type="hidden" name="type" value="data_pemasok">
                        <input type="hidden" name="cmd" value="tambah">
                        <div class="mb-3">
                            <label for="NamaPemasok" class="form-label">Nama</label>
                            <input type="text" class = "form-control" name="NamaPemasok">
                        </div>
                        <div class="mb-3">
                            <label for="Alamat" class="form-label">Alamat</label>
                            <textarea class ="form-control" name="Alamat"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="NomorTelepon" class="form-label">Nomor Telepon</label>
                            <input type="number" class ="form-control" name="NomorTelepon"></input>
                        </div>
                        <div class="mb-3">
                            <label for="Email" class="form-label">Email</label>
                            <input type="email" class = "form-control" name="Email" ></input>
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