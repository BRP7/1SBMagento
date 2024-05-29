<?php
class Practice_Reportmanager_Block_Adminhtml_Customer_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'practice_reportmanager';
        $this->_controller = 'adminhtml_customer';
        parent::__construct();
        $this->_updateButton('save', 'label', Mage::helper('practice_reportmanager')->__('Save reportmanager'));
        $this->_updateButton('delete', 'label', Mage::helper('practice_reportmanager')->__('Delete reportmanager'));
        if(!Mage::getSingleton('admin/session')->isAllowed('practice_reportmanager/reportmanager/delete')){
            $this->removeButton('delete');
        }
    }

    public function getHeaderText()
    {
        $model = Mage::registry('reportmanager_data');
        if ($model && $model->getId()) {
            return Mage::helper('practice_reportmanager')->__('Edit Reportmanager');
        } else {
            return Mage::helper('practice_reportmanager')->__('New Reportmanager');
        }
    }
}
