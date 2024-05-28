<?php

class Practice_Reportmanager_Block_Adminhtml_Customer extends Mage_Adminhtml_Block_Customer{
    public function __construct()
    {
        parent::__construct();
        $this->_addButton('save_report', array(
            'label'     => Mage::helper('customer')->__('Save Report'),
            'onclick'   => 'saveCustomerReport()',
            'class'     => 'save',
        ));
    }
}