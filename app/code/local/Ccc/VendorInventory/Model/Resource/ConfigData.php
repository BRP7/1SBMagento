<?php

class Ccc_VendorInventory_Model_Resource_ConfigData extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        // echo 123;die;
        $this->_init('vendorinventory/configdata', 'id');
    }
}