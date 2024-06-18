<?php
class Ccc_Ticketsystem_Block_Pagination extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $collection = Mage::getModel('ccc_ticketsystem/ticketsystem')->getCollection();
        $this->setCollection($collection);
    }
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
        $pager->setAvailableLimit(array(5=>5,10=>10,20=>20,'all'=>'all'));
        $pager->setCollection($this->getCollection());
        $this->setChild('pager', $pager);
        $this->getCollection()->load();
        return $this;
    }
    public function getToolbarHtml()
    {
        return $this->getChildHtml('pager');
    }
}
