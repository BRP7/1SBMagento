<?php


class Ccc_Ticketsystem_Block_Adminhtml_Ticketsystemviewcomment extends Mage_Adminhtml_Block_Template
{
    public function _construct(){
        $this->setTemplate('ticketsystem/ticket_comment.phtml');
    }

    public function getTicketCommentCollection()
    {
        $id = $this->getRequest()->getParam('id');
        $collection = Mage::getModel('ccc_ticketsystem/comment')->getCollection()->addFieldToFilter('ticket_id',$id);
        return $collection;
    }

    // public function getStatusColor($statusId)
    // {
    //     return Mage::getModel('ccc_ticketsystem/status')
    //         ->load($statusId)
    //         ->getColorCode();
    // }
}