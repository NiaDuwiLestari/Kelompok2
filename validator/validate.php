<?php
function validasiNameProduct($value)
{
    $name_productErr = "";
    $name_product = "";
    if (empty($value)) {
        $name_productErr = "Name Product Required";
    } else {
        $name_product = htmlspecialchars($value);
    }
    return [$name_product, $name_productErr];
}

function validasiPriceProduct($value)
{
    $price_productErr = "";
    $price_product = "";
    if (empty($value)) {
        $price_productErr = "Price Product Required";
    } else if (!is_numeric($value)) {
        $price_productErr = "Price Product must be number";
    } else {
        $price_product = htmlspecialchars($value);
    }
    return [$price_product, $price_productErr];
}
function validasiProductId($value)
{
    $product_idErr = "";
    $product_id = "";
    if (empty($value)) {
        $product_idErr = "Product Required";
    } else if (!is_numeric($value)) {
        $product_idErr = "Product must be number";
    } else {
        $product_id = htmlspecialchars($value);
    }
    return [$product_id, $product_idErr];
}
function validasiAmount($value)
{
    $amountErr = "";
    $amount = "";
    if (empty($value)) {
        $amountErr = "amount Product Required";
    } else if (!is_numeric($value)) {
        $amountErr = "Product must be number";
    } else {
        $amount = htmlspecialchars($value);
    }
    return [$amount, $amountErr];
}
