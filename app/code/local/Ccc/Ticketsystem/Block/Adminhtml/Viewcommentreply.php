<?php


class Ccc_Ticketsystem_Block_Adminhtml_Viewcommentreply extends Mage_Adminhtml_Block_Template
{
    public function _construct(){
        $this->setTemplate('ticketsystem/comment_reply_system.phtml');
    }
    public function getComments()
    {
        $id = $this->getRequest()->getParam('id');
        $collection = Mage::getModel('ccc_ticketsystem/comment')->getCollection()->addFieldToFilter('ticket_id',$id);
        return $collection;
    }
}