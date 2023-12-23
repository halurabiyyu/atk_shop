<?php require_once('config/main.php');
?>
<style>
    #myDiv {
    display: none;
    width: 200px;
    height: 200px;
    background-color: lightblue;
    margin-top: 20px;
    padding: 10px;
    box-sizing: border-box; /* Menjamin bahwa padding tidak menambahkan ukuran total */
}

#myInput {
    width: 100%;
    margin-top: 10px;
}
</style>

  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Transaksi</h1>
            </div>
            <div class="card col-md-6">
                <div class="card-header">
                    Selamat Datang di ATK SHOP, berbagai alat tulis ada disini!!!
                    
                </div>
                <br>
                <div class="card-body">
                    <form action="simpan.php" role="form" method="post">
                        <input type="hidden" name="type" value="transaksi">
                        <input type="hidden" name="cmd" value="tambah">
                        <div class="mb-3">
                            <label for="NamaPembeli" class="form-label">Nama Pembeli</label>
                            <input type="text" class = "form-control" name="NamaPembeli" required></input>
                        </div>
                        <br>
                        <div class="mb-3">
                            <label for="NamaProduk" class="form-label">Nama Produk</label>
                            <select class="form-select" name="product_id" id="product_id" name aria-label="Default select example" required>
                                <option disabled selected>Pilih Produk</option>
                                <?php
                                    $query = "SELECT * FROM Produk order by IDProduk asc";
                                    $result = sqlsrv_query($conn, $query);
                                    
                                    // while () {
                                    while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                ?>
                                <option name="product_id" value="<?= $row['IDProduk']; ?>"><?= $row['NamaProduk']; ?></option>    
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="Harga" class="form-label">Harga Satuan: </label>
                            <div name="Harga" id="harga_produk_display"></div>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class = "form-control" name="JumlahBarang" onsubmit="return validateForm()" required></input>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-money" aria-hidden="true"></i>
                            Checkout
                        </button>
                        <a href="index.php" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Batal</a>
                    </form>
                    <br>
                    <!-- <button class="btn btn-primary" onclick="toggleDiv()"><i class="fa fa-cart-plus" aria-hidden="true"></i> Tambah Produk yang ingin dibeli</button>
                        <div id="myDiv" class="hidden">
                            <label for="myInput">Input:</label>
                            <input type="text" id="myInput" placeholder="Masukkan sesuatu...">
                        </div> -->
                </div>
            </div>

  <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <!-- JavaScript to handle the price update -->
  <script>
    // When the product selection changes
    $('#product_id').change(function () {
    // Get the selected product ID
    var product_id = $(this).val();

    // Make an AJAX request to get the price for the selected product
    $.ajax({
    url: 'get_price.php', // Replace with the actual PHP file handling the query
    type: 'GET',
    data: { product_id: product_id },
    success: function (response) {
    // Update the display area with the retrieved price
        $('#harga_produk_display').html(response);
    },
        error: function (error) {
            console.log(error);
        }
    });
    });
    </script>
    <script>
        function toggleDiv() {
            var div = document.getElementById('myDiv');
            div.style.display = (div.style.display === 'none' || div.style.display === '') ? 'block' : 'none';
        }
    </script>

<script>
function validateForm() {
    // Mengambil nilai dari input
    var jumlahInput = document.getElementById("jumlahInput").value;

    // Mengonversi nilai ke bilangan bulat
    var jumlah = parseInt(jumlahInput);

    // Memeriksa apakah nilai adalah angka non-negatif
    if (jumlah < 0 || isNaN(jumlah)) {
        alert("Jumlah harus merupakan angka non-negatif.");
        return false; // Mencegah formulir dikirim jika validasi gagal
    }

    // Lanjutkan dengan tindakan formulir lainnya atau kirimkan data ke server
    // ...

    return true; // Izinkan formulir dikirim
}
</script>

<script>
    // Ambil nilai dari span dan tetapkan ke input
    var hargaSpan = document.getElementById("harga_produk_display");
    var inputHarga = document.getElementById("inputHarga");

    // Pastikan hargaSpan dan inputHarga ditemukan sebelum mencoba mendapatkan nilai
    if (hargaSpan && inputHarga) {
        inputHarga.value = hargaSpan.innerText;
    }
</script>
    