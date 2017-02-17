<?php namespace Barber\Transformers;
    /**
     * Created by Apptitud.mx.
     * User: diegogonzalez
     * Date: 3/19/15
     * Time: 12:18 PM
     */


/**
 * Class ProductTransformer
 * @package Barber\Transformers
 */
class ProductTransformer extends Transformer {

    /**
     * @param $product
     * @return array
     */
    public function transform($product)
    {
        return [
            'id'             => $product->id,
            'name'           => $product->name,
            'sku'            => $product->sku,
            'price'          => (int) $product->price,
            'image'          => $product->image,
            'active'         => (bool) $product->active,
            'order'          => (int) $product->order,
        ];
    }

}