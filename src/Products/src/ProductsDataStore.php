<?php

namespace rollun\Service\Products;


use rollun\datastore\DataStore\SerializedDbTable;

class ProductsDataStore extends SerializedDbTable
{
    public const TABLE_NAME = 'products';

    public function create($itemData, $rewriteIfExist = false)
    {
        unset($itemData['datetime']);
        $itemData['id'] = $itemData['id'] ?? sha1(implode('_', $itemData));

        $itemData['datetime'] = (new \DateTime())->format('c');

        return parent::create($itemData, $rewriteIfExist); // TODO: Change the autogenerated stub
    }
}