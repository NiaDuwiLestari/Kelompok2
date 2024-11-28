<?php
include 'validator/validate.php';
include 'config/connectDb.php';

$product_idErr = $amountErr = "";
$product_id = $amount = $total_price = "";

// validate
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // call validation
    list($product_id, $product_idErr) = validasiProductId($_POST['product_id']);
    list($amount, $amountErr) = validasiAmount($_POST['amount']);
}



// insert
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($product_idErr) && empty($amountErr)) {

    $id_transaction = "Tr_" . "BrG" . "-" . date('Y-m-d H:i:s'); // Menggunakan date() untuk tanggal dan waktu saat ini
    $tgl_transaction = date('Y-m-d H:i:s');
    $total_price = $_POST['total_price'];

    // sql create
    $sql = $con->prepare("INSERT INTO tr_penjualan (id_transaction,tgl_transaction,product_id,amount,total_price) VALUES (?,?,?,?,?)");
    $sql->bind_param("ssiii", $id_transaction, $tgl_transaction, $product_id, $amount, $total_price);
    if ($sql->execute()) {
        header("Location: penjualan.php");
    } else {
        echo "Error: " . $sql->error;
    }
    $sql->close();
}
$get_product = $con->query("SELECT * FROM sistem_pencatatan_penjualan");
//get data
$sql = "SELECT * FROM tr_penjualan LEFT JOIN sistem_pencatatan_penjualan ON tr_penjualan.product_id = sistem_pencatatan_penjualan.id ORDER BY tr_penjualan.tgl_transaction DESC";
$result = $con->query($sql);
$result_total = $con->query("SELECT SUM(amount) AS amount, SUM(total_price) AS total
FROM tr_penjualan;");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        input[type=text],
        textarea,
        select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: none;
            border-radius: 10px;
            background-color: snow;
            color: black;
        }

        th,
        td {
            padding: 10px;
        }

        th {
            background: #DB7093;
            color: white;
        }
    </style>
</head>

<body>
    <div style="box-shadow: rgba(50, 50, 93,0.25) 0px 2px 5px -1px, rgba(0,0,0,0.3) 5px 5px 5px 5px; display:flex;flex-direction:column;padding:4rem;width:50%;margin:0 auto;justify-content:center;">
        <h1 style="text-align:center;">Produk Terjual</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
            <!-- Nama: <input type="text" value="" name="name_product" placeholder="Enter Name Product..."> -->
            Produk
            <select name="product_id" id="product-select">
                <option value="">::. pilih .::</option>
                <?php
                while ($row = $get_product->fetch_assoc()) : ?>
                    <option value="<?= $row['id']; ?>" data-price="<?= $row['price_product']; ?>"><?= $row['name_product']; ?></option>
                <?php endwhile; ?>
            </select>
            <div>
                <span style="color:red;"><?= $product_idErr; ?></span>
            </div>
            Harga: <input type="text" readonly value="" id="price-product" name="price_product">
            Jumlah: <input type="text" value="" id="product-amount" name="amount" placeholder="Enter jumlah produk...">
            <div>
                <span style="color:red;"><?= $amountErr; ?></span>
            </div>
            Total Harga: <input type="text" readonly value="" id="total-price" name="total_price">
            <div style="margin-top:20px;display:flex;justify-content:center;">
                <input style="padding: 12px 16px; color:white; font-weight:bold; background: #DB7093;border:none; border-radius:9px;" type="submit" value="Terjual">
            </div>
        </form>
    </div>

    <div style="margin-top:20px;box-shadow: rgba(50, 50, 93,0.25) 0px 7px 5px -1px, rgba(0,0,0,0.3) 0px 1px 3px -1px; display:flex;flex-direction:column;padding:1rem;width:50%;margin:0 auto;justify-content:center;">
        <h2 style="text-align:center;">Data Transaksi</h2>
        <table border="1" style="border-collapse: collapse; ">
            <tr>
                <th>Transaksi</th>
                <th>Tanggal Transaksi</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
            <?php if ($result->num_rows > 0) : ?>
                <?php $i = 1;
                while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $row['id_transaction']; ?></td>
                        <td><?= $row['tgl_transaction']; ?></td>
                        <td><?= $row['name_product']; ?></td>
                        <td><?= $row['amount']; ?></td>
                        <td><?= $row['price_product']; ?></td>
                        <td><?= $row['total_price']; ?></td>
                        <td>
                            <a type="button" class="btn btn-warning" href="delete_transaction.php?id=<?= $row["id_transaction"]; ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7" style="color:grey; text-align:center;"> data not found</td>
                </tr>
            <?php endif ?>
        </table>
        <div>
            <div>
                <?php
                if ($result_total->num_rows > 0) {
                    $row = $result_total->fetch_assoc();
                    echo '<h2 style="text-align:center;">Total Jumlah:</h2>' . '<h2 style="text-align:center;">' . $row['amount'] . '</h2>';
                    echo '<h2 style="text-align:center;">Total Harga:</h2>' . '<h2 style="text-align:center;">' . $row['total'] . '</h2>';
                } else {
                    echo "No results.";
                }
                ?>
            </div>
            <div style="margin-top:20px;display:flex;justify-content:center;">
                <a href="index.php" style="padding: 12px 16px; color: white; font-weight: bold; background: #DB7093; border: none; text-decoration: none; display: inline-block; border-radius:9px;">
                    :: Laporan Penjualan ::
                </a>

            </div>
        </div>
    </div>

    <script>
        // Tangkap elemen select dan input harga
        const productSelect = document.getElementById('product-select');
        const productPrice = document.getElementById('price-product');
        const productAmount = document.getElementById('product-amount');
        const totalPrice = document.getElementById('total-price');
        // Event listener untuk ketika produk dipilih
        productSelect.addEventListener('change', function() {
            // Ambil harga produk dari atribut data-price
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const price = selectedOption.getAttribute('data-price');

            // Set nilai harga produk pada input harga
            productPrice.value = price ? price : '';

            // Perbarui total harga
            calculateTotalPrice();
        });

        // Event listener untuk ketika jumlah produk diubah
        productAmount.addEventListener('input', function() {
            // Perbarui total harga
            calculateTotalPrice();
        });

        // Fungsi untuk menghitung total harga
        function calculateTotalPrice() {
            // Ambil nilai harga dan jumlah
            const price = parseFloat(productPrice.value);
            const amount = parseInt(productAmount.value);

            // Pastikan harga dan jumlah adalah angka yang valid
            if (!isNaN(price) && !isNaN(amount)) {
                // Hitung total harga
                totalPrice.value = price * amount;
            } else {
                totalPrice.value = ''; // Kosongkan jika tidak valid
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>