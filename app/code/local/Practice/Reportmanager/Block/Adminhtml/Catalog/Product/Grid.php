<?php
class Practice_Reportmanager_Block_Adminhtml_Catalog_Product_Grid extends Mage_Adminhtml_Block_Catalog_Product_Grid
{
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('catalog/product')->getCollection();
        // Apply saved filters if available
        $user = Mage::getSingleton('admin/session')->getUser();
        $filterReport = Mage::getModel('practice_reportmanager/reportmanager')->getCollection()
            ->addFieldToFilter('user_id', $user->getId())
            ->addFieldToFilter('report_type', 'product')
            ->addFieldToFilter('is_active', 1)
            ->getFirstItem();

        if ($filterReport->getId()) {
            $filters = json_decode($filterReport->getFilterData(), true);
            $this->setFilter($filters);
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $this->addColumn('sold_count', array(
            'header' => Mage::helper('catalog')->__('Sold Count'),
            'index'  => 'sold_count',
        ));

        return parent::_prepareColumns();
    }
}
