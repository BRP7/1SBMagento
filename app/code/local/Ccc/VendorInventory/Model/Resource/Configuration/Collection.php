// app/code/local/Ccc/VendorInventory/Model/Resource/Configuration/Collection.php
<?php
class Ccc_VendorInventory_Model_Resource_Configuration_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('vendorinventory/configuration');
    }
}
?>



