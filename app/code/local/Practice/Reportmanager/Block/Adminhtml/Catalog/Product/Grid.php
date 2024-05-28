<?php
class Practice_Reportmanager_Block_Adminhtml_Catalog_Product_Grid extends Mage_Adminhtml_Block_Catalog_Product_Grid
{
    protected function _prepareColumns()
    {
        $this->addColumn('sold_count', array(
            'header' => Mage::helper('catalog')->__('Sold Count'),
            'index'  => 'sold_count',
        ));

        return parent::_prepareColumns();
    }
}
