<?php
class Ccc_VendorInventory_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getBrandNames()
    {
        $attribute = Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product', 'brand');

        if ($attribute && $attribute->getId()) {
            $options = $attribute->getSource()->getAllOptions(false);
        }
        return $options;
    }
}
?>