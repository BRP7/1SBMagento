<?php

class Practice_Reportmanager_Block_Adminhtml_Customer extends Mage_Adminhtml_Block_Widget_Grid_Container    
{
    public function __construct()
    {
        // echo 12;
        $this->_controller = 'adminhtml_customer';
        $this->_blockGroup = 'practice_reportmanager';
        $this->_headerText = Mage::helper('practice_reportmanager')->__('Report Manager');
        parent::__construct();
        $this->setId('reportmanager');
        $this->_addButton('save_report', array(
            'label' => Mage::helper('customer')->__('Save Report'),
            'onclick' => 'saveCustomerReport()',
            'class' => 'save',
        )
        );
    }

}