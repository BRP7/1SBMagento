<?php
class Ccc_VendorInventory_Block_Adminhtml_VendorInventory extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
echo 12;
        // var_dump(class_exists('Ccc_VendorInventory_Block_Adminhtml_VendorInventory'));
        $this->_controller = 'adminhtml_vendorinventory';
        $this->_blockGroup = 'ccc_vendorinventory';
        $this->_headerText = Mage::helper('vendorinventory')->__('Manage Inventory');
        parent::__construct();
    }
}
