<?php
include 'validator/validate.php';
include 'config/connectDb.php';

$name_productErr = $price_productErr = "";
$name_product = $price_product = $created_at = $updated_at = "";

// validate
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // call validation
    list($name_product, $name_productErr) = validasiNameProduct($_POST['name_product']);
    list($price_product, $price_productErr) = validasiPriceProduct($_POST['price_product']);
}



// insert
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($name_productErr) && empty($price_productErr)) {
    // $name_product = $_POST['name_product'];
    // $price_product = $_POST['price_product'];
    $created_at = date('Y-m-d H:i:s'); // Menggunakan date() untuk tanggal dan waktu saat ini
    $updated_at = date('Y-m-d H:i:s');
    // sql create
    $sql = $con->prepare("INSERT INTO sistem_pencatatan_penjualan (name_product,price_product,created_at,updated_at) VALUES (?,?,?,?)");
    $sql->bind_param("siss", $name_product, $price_product, $created_at, $updated_at);
    if ($sql->execute()) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql->error;
    }
    $sql->close();
}

//get data
$sql = "SELECT * FROM sistem_pencatatan_penjualan ORDER BY updated_at DESC";
$result = $con->query($sql);

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
        textarea {
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
    <div style="box-shadow: rgba(50, 50, 93,0.25) 5px 5px 5px 5px, rgba(0,0,0,0.3) 0px 1px 3px -1px; display:flex;flex-direction:column;padding:1rem;width:50%;margin:0 auto;justify-content:center;">
        <h1 style="text-align:center;">Laporan Penjualan</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
            Nama: <input type="text" value="<?= $name_product ?>" name="name_product" placeholder="Enter Nama Produk...">
            <div>
                <span style="color:red;"><?php echo $name_productErr; ?></span>
            </div>
            Harga: <input type="text" value="<?= $price_product ?>" name="price_product" placeholder="Enter Harga Produk...">
            <div>
                <span style="color:red;"><?php echo $price_productErr; ?></span>
            </div>
            <div style="margin-top:20px;display:flex;justify-content:center;">
                <input style="padding: 12px 16px; color:white; font-weight:bold; background: #DB7093;border:none; border-radius:9px;" type="submit" value="Tambah">
            </div>
        </form>
    </div>

    <div style="margin-top:20px;box-shadow: rgba(50, 50, 93,0.25) 0px 7px 5px -1px, rgba(0,0,0,0.3) 0px 1px 3px -1px; display:flex;flex-direction:column;padding:1rem;width:50%;margin:0 auto;justify-content:center;">
        <h2 style="text-align:center;">Data Produk</h2>
        <table border="1" style="border-collapse: collapse;">
            <tr>
                <th>Nama Produk</th>
                <th>Harga </th>
                <th>Tambah</th>
                <th>Update</th>
                <th>Aksi</th>
            </tr>
            <?php if ($result->num_rows > 0) : ?>
                <?php $i = 1;
                while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $row['name_product']; ?></td>
                        <td><?= $row['price_product']; ?></td>
                        <td><?= $row['created_at']; ?></td>
                        <td><?= $row['updated_at']; ?></td>
                        <td>
                            <a type="button" class="btn btn-success" href="edit.php?id=<?= $row["id"]; ?>">Edit</a> 
                            <a type="button" class="btn btn-warning" href="delete.php?id=<?= $row["id"]; ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>

                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5" style="color:grey; text-align:center;"> data not found</td>
                </tr>
            <?php endif; ?>
        </table>
        <div style="margin-top:20px;display:flex;justify-content:center;">
            <a href="penjualan.php" style="padding: 12px 16px; color: white; font-weight: bold; background: #DB7093; border: none; text-decoration: none; display: inline-block; border-radius:9px;">
                :: Produk Terjual ::
            </a>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>