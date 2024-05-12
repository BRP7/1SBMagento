<?php

class Practice_Customgrid_Block_Adminhtml_Customgrid_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'practice_customgrid';
        $this->_controller = 'adminhtml_customgrid';

        $this->_updateButton('save', 'label', Mage::helper('practice_customgrid')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('practice_customgrid')->__('Delete Item'));
    }

    protected function _prepareLayout()
    {
        $this->_addButton('reset', array(
            'label'     => Mage::helper('adminhtml')->__('Reset'),
            'onclick'   => "setLocation('".$this->getUrl('*/*/edit', array('id' => $this->getRequest()->getParam('id')))."')",
            'class'     => 'reset'
        ));

        return parent::_prepareLayout();
    }

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post'
        ));

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    public function getHeaderText()
    {
        if (Mage::registry('customgrid_data')->getId()) {
            return Mage::helper('practice_customgrid')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('current_customgrid')->getTitle()));
        } else {
            return Mage::helper('practice_customgrid')->__('New Item');
        }
    }
}
