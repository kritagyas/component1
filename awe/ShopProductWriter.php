<?php


namespace awe;


abstract class ShopProductWriter
{
    protected $products = [];
    public function addProduct(ShopProduct $shopProduct)
    {
        $this->products[] = $shopProduct;
    }

    public function setProducts($products){
        $this->products=$products;
    }

    abstract public function write();

}