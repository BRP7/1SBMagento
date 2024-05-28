<?php
class Practice_Reportmanager_Block_Adminhtml_Catalog_Product extends Mage_Adminhtml_Block_Catalog_Product
{
    public function __construct()
    {
        parent::__construct();
        $this->_addButton('save_report', array(
            'label'     => Mage::helper('catalog')->__('Save Report'),
            'onclick'   => 'saveReport()',
            'class'     => 'save',
        ));
    }
}
