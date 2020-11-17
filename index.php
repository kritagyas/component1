<?php

set_include_path(get_include_path().PATH_SEPARATOR.'./'); //add current directory as to include path

spl_autoload_register(function ($class_name) {
    $class_name=str_replace('\\', '/',  $class_name); //Issue on AET Eclipse Che on file paths
    include $class_name . '.php';
});


$api_call=false;

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['delete'])) {
        \awe\JsonUtility::deleteProductWithId("products.json", $_GET['delete']);
    }
    if (isset($_GET['api'])) {
        $api_call=$_GET['api'];
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['producttype'])) {
        $producttype = $_POST['producttype'];
    }
    if (isset($_POST['fname'])) {
        $fname = $_POST['fname'];
    }
    if (isset($_POST['sname'])) {
        $sname = $_POST['sname'];
    }
    if (isset($_POST['title'])) {
        $title = $_POST['title'];
    }
    if (isset($_POST['pages'])) {
        $pages = (is_numeric($_POST['pages']) ? (int)$_POST['pages'] : 0);
    }
    if (isset($_POST['price'])) {
        $price = (is_numeric($_POST['price']) ? (float)$_POST['price'] : 0);
    }
    \awe\JsonUtility::addNewProduct("products.json", $producttype, $fname, $sname, $title, $pages, $price);
}

if($api_call)   $products = new \awe\JsonProductWriter();
else            $products = new \awe\HtmlProductWriter();

$productArray = \awe\JsonUtility::makeProductArray("products.json");
$products->setProducts($productArray);



$products->write();



