<?php
class Practice_Reportmanager_Block_Adminhtml_Reportmanager extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        
        $this->_controller = 'adminhtml_reportmanager';
        $this->_blockGroup = 'practice_reportmanager';
        $this->_headerText = Mage::helper('practice_reportmanager')->__('Manage Reportmanagers');
        parent::__construct();
        if (!Mage::getSingleton('admin/session')->isAllowed('practice_reportmanager/new')) {
            $this->removeButton('add');
        }
    }
}
