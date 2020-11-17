<?php


namespace awe;


class JsonProductWriter extends ShopProductWriter
{
    public function write()
    {
        $json_str = '[';
        foreach ($this->products as $product) {
          $json_str .= $this->addEachProductAsJSON($product).',';
        }
        $json_str = rtrim($json_str, ","); //remove final ',' from outputted json string

        $json_str .= "]";
        echo $json_str;
    }

    private function addEachProductAsJSON($product){
        $json_product = [];
        $json_product['id'] = $product->getId();
        $json_product['title'] = $product->getTitle();
        $json_product['firstname'] = $product->getFirstName();
        $json_product['mainname'] = $product->getMainName();
        $json_product['price'] = $product->getPrice();

        if($product instanceof BookProduct) {
            $json_product['numpages'] = $product->getNumberOfPages();
            $json_product['type'] = "book";
        }
        if($product instanceof CDProduct) {
            $json_product['playlength'] = $product->getPlayLength();
            $json_product['type'] = "cd";
        }
        if($product instanceof GameProduct) {
            $json_product['pegi'] = $product->getPegi();
            $json_product['type'] = "game";
        }

        return json_encode($json_product);
    }
}