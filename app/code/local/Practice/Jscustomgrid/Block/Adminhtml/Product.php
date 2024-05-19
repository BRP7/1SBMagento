<?php

class Practice_Jscustomgrid_Block_Adminhtml_Product extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_product';
        $this->_blockGroup = 'practice_jscustomgrid';
        $this->_headerText = Mage::helper('practice_jscustomgrid')->__('Product Manager');
        parent::__construct();
        $this->_removeButton('add');
    }

    protected function _prepareLayout()
    {
        $this->setChild('grid', $this->getLayout()->createBlock('practice_jscustomgrid/adminhtml_product_grid', 'product.grid'));
        return parent::_prepareLayout();
    }
    
    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }

}
