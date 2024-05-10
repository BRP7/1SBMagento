<?php
class Ccc_Brand_Block_Adminhtml_Brand extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'brand';
        $this->_controller = 'adminhtml_brand';
        $this->_headerText = Mage::helper('brand')->__('Brand Attributes');
        $this->_addButtonLabel = Mage::helper('brand')->__('Add New Brand');

        parent::__construct();
    }

    protected function _prepareLayout()
    {
        $this->setChild('grid', $this->getLayout()->createBlock('brand/adminhtml_brand_grid', 'brand.grid'));
        return parent::_prepareLayout();
    }
}
