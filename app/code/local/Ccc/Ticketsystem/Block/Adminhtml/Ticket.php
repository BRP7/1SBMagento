<?php

class Ccc_Ticketsystem_Block_Adminhtml_Ticket extends Mage_Adminhtml_Block_Template
{
    public function _construct(){
        $this->setTemplate('ticketsystem/ticket_form.phtml');
    }
    public function getUsers()
    {
        $users = Mage::getResourceModel('admin/user_collection')
            ->addFieldToSelect(['user_id', 'username'])
            ->addFieldToFilter('is_active', 1)
            ->setOrder('username', 'ASC');

        foreach ($users as $user) {
            $usersArray[$user->getUserId()] = $user->getUsername();
        }
        return $usersArray;
    }
    public function getCurrentUserId()
    {
        return Mage::getSingleton('admin/session')->getUser()->getId();
    }
}