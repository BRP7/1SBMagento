<?php
class Ccc_VendorInventory_Model_VendorInventory extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        echo 123;
        parent::_construct();
        $this->_init('vendorinventory/vendorinventory');
    }

}

?>

