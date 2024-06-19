<?php
class Ccc_Ticketsystem_Block_Adminhtml_Ticketsystemfilter extends Mage_Adminhtml_Block_Template
{
    public function _construct(){
        $this->setTemplate('ticketsystem/ticket_add_filter.phtml');
    }

    public function getStatusOptions()
    {
        $statuses = Mage::getResourceModel('ccc_ticketsystem/status_collection')
            ->addFieldToSelect(['label', 'status_id']);

        $options = [];
        foreach ($statuses as $status) {
            $options[$status->getStatusId()] = $status->getLabel();
        }

        return $options;
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
}