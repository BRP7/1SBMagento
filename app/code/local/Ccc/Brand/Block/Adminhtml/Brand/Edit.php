<?php
class Ccc_Brand_Block_Adminhtml_Brand_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_blockGroup = 'brand';
        $this->_controller = 'adminhtml_brand';
        $this->_mode = 'edit';

        $this->_updateButton('save', 'label', Mage::helper('brand')->__('Save Brand'));
        $this->_updateButton('delete', 'label', Mage::helper('brand')->__('Delete Brand'));

        $this->_removeButton('reset'); // Remove the reset button if not required
    }

    public function getHeaderText()
    {
        if (Mage::registry('current_brand') && Mage::registry('current_brand')->getId()) {
            return Mage::helper('brand')->__("Edit Brand '%s'", $this->escapeHtml(Mage::registry('current_brand')->getValue()));
        } else {
            return Mage::helper('brand')->__('Add New Brand');
        }
    }
}
