<?php

include 'validator/validate.php';
include 'config/connectDb.php';
$name_productErr = $price_productErr = "";
$name_product = $price_product = $created_at = $updated_at = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // call validation
    list($name_product, $name_productErr) = validasiNameProduct($_POST['name_product']);
    list($price_product, $price_productErr) = validasiPriceProduct($_POST['price_product']);
}
// sql update first
if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $id = $_GET["id"];
    // var_dump($id);
    $sql = $con->prepare("SELECT * FROM sistem_pencatatan_penjualan WHERE id=?");
    $sql->bind_param("i", $id);
    $sql->execute();
    $result = $sql->get_result();
    $row = $result->fetch_assoc();
    // var_dump($row);
    $name_product = $row["name_product"];
    $price_product = $row["price_product"];
    $sql->close();

    // update
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_GET['id'];
        $name_product = $_POST['name_product'];
        $price_product = $_POST['price_product'];
        $updated_at = date('Y-m-d H:i:s');
        // var_dump($_POST);
        $sqls = $con->prepare("UPDATE sistem_pencatatan_penjualan SET name_product=?,price_product=?,updated_at=? WHERE id=?");
        $sqls->bind_param("sisi", $name_product, $price_product, $updated_at, $id);

        if ($sqls->execute()) {
            header("Location: index.php");
        } else {
            echo "Error: " . $sql->error;
        }
    }
}
// sql update end


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contoh post</title>
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
            background: #4CAF50;
            color: white;
        }
    </style>
</head>

<body>
    <div style="box-shadow: rgba(50, 50, 93,0.25) 0px 2px 5px -1px, rgba(0,0,0,0.3) 0px 1px 3px -1px; display:flex;flex-direction:column;padding:1rem;width:50%;margin:0 auto;justify-content:center;">
        <h1 style="text-align:center;">Edit Produk</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id ?>" method="POST">
            Nama Produk: <input type="text" name="name_product" value="<?= htmlspecialchars($name_product) ?>">
            <div>
                <span style="color:red;"><?php echo $name_productErr; ?></span>
            </div>
            Harga Produk: <input type="text" name="price_product" value="<?= htmlspecialchars($price_product) ?>">
            <div>
                <span style="color:red;"><?php echo $price_productErr; ?></span>
            </div>
            <div style="margin-top:20px;display:flex;justify-content:center;">
                <input style="padding: 12px 16px; color:white; font-weight:bold; background: #DB7093;border:none; border-radius:9px;" type="submit" value="Update">
            </div>
        </form>
    </div>


</body>

</html>