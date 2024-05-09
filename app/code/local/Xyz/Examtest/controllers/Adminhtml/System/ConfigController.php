<?php
class Xyz_Examtest_Adminhtml_System_ConfigController extends Mage_Adminhtml_Controller_Action
{
   
    public function editAction()
    {
        echo 123;
        
        $this->loadLayout();
        // $this->_setActiveMenu('system/config');

        // // Load the standard system configuration block
        // $configBlock = $this->getLayout()->createBlock('adminhtml/system_config_edit');
        // $this->getLayout()->getBlock('content')->append($configBlock);

        $this->renderLayout();
    }
}
