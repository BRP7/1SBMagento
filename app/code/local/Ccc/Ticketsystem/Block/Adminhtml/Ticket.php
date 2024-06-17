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
    public function getStatusOptions()
    {
        $statuses = Mage::getResourceModel('ccc_ticketsystem/status_collection')
            ->addFieldToSelect(['status_id', 'label']); 

        $options = [];
        foreach ($statuses as $status) {
            var_dump($status->getId());
            $options[$status->getId()] = $status->getLabel();
        }
        return $options;
    }

}