<?php
class Ccc_Ticketsystem_Block_Adminhtml_Ticketsystem extends Mage_Adminhtml_Block_Template
{
    public function _construct(){
        $this->setTemplate('ticketsystem/ticket_edit_form.phtml');
    }

    // public function getTicketCollection()
    // {
    //     $collection = Mage::getModel('ccc_ticketsystem/ticketsystem')->getCollection();
    //     return $collection;
    // }

    // public function getStatusColor($statusId)
    // {
    //     return Mage::getModel('ccc_ticketsystem/status')
    //         ->load($statusId)
    //         ->getColorCode();
    // }
    public function getStatus($statusId)
    {
        return Mage::getModel('ccc_ticketsystem/status')
            ->load($statusId);
    }

     protected $_collection;

    public function getCollection()
    {
        if (is_null($this->_collection)) {
            $this->_collection = Mage::getModel('ccc_ticketsystem/ticketsystem')->getCollection()
                ->setOrder('created_at', 'DESC');
        }
        
        return $this->_collection;
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

    public function getPagerHtml()
    {
        $pagerBlock = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
        if ($pagerBlock) {
            $pagerBlock->setCollection($this->getCollection());
            return $pagerBlock->toHtml();
        }
        return '';
    }

    protected $_page;
    protected $_limit;

    public function setPage($page)
    {
        $this->_page = $page;
        return $this;
    }

    public function setLimit($limit)
    {
        $this->_limit = $limit;
        return $this;
    }

    public function getTicketCollection()
    {
        $collection = Mage::getModel('ccc_ticketsystem/ticketsystem')->getCollection();
        $collection->setPageSize($this->_limit)->setCurPage($this->_page);
        return $collection;
    }

    public function getPaginationHtml()
    {
        $collection = $this->getTicketCollection();
        $totalRecords = $collection->getSize();
        $this->_limit = max(1, intval($this->_limit));
        $totalPages = ceil($totalRecords / $this->_limit);

        $html = '<div class="pagination">';
        for ($i = 1; $i <= $totalPages; $i++) {
            $html .= '<a href="' . $this->getUrl('*/*/*', array('_current' => true, 'page' => $i)) . '">' . $i . '</a> ';
        }
        $html .= '</div>';
        return $html;
    }
}