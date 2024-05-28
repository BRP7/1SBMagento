<?php
class Practice_Reportmanager_Block_Adminhtml_Customer_Grid extends Mage_Adminhtml_Block_Customer_Grid
{
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('customer/customer')->getCollection();
        $user = Mage::getSingleton('admin/session')->getUser();
        $filterReport = Mage::getModel('practice_reportmanager/reportmanager')->getCollection()
            ->addFieldToFilter('user_id', $user->getId())
            ->addFieldToFilter('report_type', 'customer')
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
        $this->addColumn('id', array(
            'header' => Mage::helper('practice_reportmanager')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'entity_id',
        )
        );

        $this->addColumn('user_id', array(
            'header' => Mage::helper('practice_reportmanager')->__('User Id'),
            'align' => 'left',
            'index' => 'user_id',
        )
        );

        $this->addColumn('report_type', array(
            'header' => Mage::helper('practice_reportmanager')->__('Report Type'),
            'align' => 'left',
            'index' => 'report_type',
        )
        );
        $this->addColumn('is_active', array(
            'header' => Mage::helper('practice_reportmanager')->__('IS Active'),
            'align' => 'left',
            'index' => 'is_active',
        )
        );
        return parent::_prepareColumns();
    }
}
