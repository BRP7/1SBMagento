<?php
class Practice_Custompermission_Block_Adminhtml_Catalog_Product extends Mage_Adminhtml_Block_Catalog_Product
{
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (!Mage::getSingleton('admin/session')->isAllowed('catalog/products/action/new')) {
            $this->_removeButton('add_new');
        }
        return $this;
    }
}