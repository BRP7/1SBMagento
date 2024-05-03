<?php
class Ccc_Blockoverride_Block_Product_List extends Mage_Catalog_Block_Product_List
{
    protected function _getProductCollection()
    {
        // Add your custom logic here
        // Example: Limit the number of products to 10
        // echo 123;
        // var_dump(get_class($this));
        $collection = parent::_getProductCollection();
        $collection->setPageSize(2);
        return $collection;
        // return 123;
    }
}
