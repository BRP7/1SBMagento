<?php

class Ccc_VendorInventory_Model_Resource_ConfigData_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    public function _construct(){
    // {echo 12;die;
        $this->_init("vendorinventory/configdata");
    }
}