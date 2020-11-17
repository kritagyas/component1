<?php


namespace awe;


class JsonUtility
{
    public static function makeProductArray(string $file) {
        $string = file_get_contents($file);

        $productsJson = json_decode($string, true);

        $products = [];
        foreach ($productsJson as $product) {
            switch($product['type']) {
                case "cd":
                    $cdproduct = new \awe\CdProduct($product['id'],$product['title'], $product['firstname'],
                        $product['mainname'],$product['price'], $product['playlength']);
                    $products[] = $cdproduct;
                    break;
                case "book":
                    $bookproduct = new \awe\BookProduct($product['id'],$product['title'], $product['firstname'],
                        $product['mainname'],$product['price'], $product['numpages']);
                    $products[]=$bookproduct;
                    break;
                case "game":
                    $gameproduct = new \awe\GameProduct($product['id'],$product['title'], $product['firstname'],
                        $product['mainname'],$product['price'], $product['pegi']);
                    $products[]=$gameproduct;
                    break;
            }
        }
        return $products;
    }

    public static function deleteProductWithId(string $file, int $id) {
        $string = file_get_contents($file);

        $productsJson = json_decode($string, true);

        $products = [];
        foreach ($productsJson as $product) {
            if($product['id'] != $id) {
                $products[] = $product;
            }
        }
        $json = json_encode($products);
        file_put_contents($file, $json);
    }

    public static function addNewProduct(string $file, string $producttype, string $fname, string $sname, string $title, int $pages, float $price)
    {
        $string = file_get_contents($file);

        $productsJson = json_decode($string, true);

        $ids = [];
        foreach ($productsJson as $product) {
             $ids[] = $product['id'];
        }
        rsort($ids);
        $newId = $ids[0] + 1;

        $products = [];
        foreach ($productsJson as $product) {
            $products[] = $product;
        }

        $newProduct = [];
        $newProduct['id'] = $newId;
        $newProduct['type'] = $producttype;
        $newProduct['title'] = $title;
        $newProduct['firstname'] = $fname;
        $newProduct['mainname'] = $sname;
        $newProduct['price'] = $price;

        if($producttype=='cd') $newProduct['playlength'] = $pages;
        if($producttype=='book') $newProduct['numpages'] = $pages;
        if($producttype=='game') $newProduct['pegi'] = $pages;

        $products[] = $newProduct;

        $json = json_encode($products);
        file_put_contents($file, $json);
    }
}