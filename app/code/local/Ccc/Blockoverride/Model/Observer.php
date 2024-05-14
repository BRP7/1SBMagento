<?php

class Ccc_Blockoverride_Model_Observer
{
    public function demo(Varien_Event_Observer $observer)
    {
        // echo '<pre>';
        // print_r($observer);
        $user = $observer->getUser();
        $userId = $user->getId();
        $userName = $user->getUsername();
        $loginTime = now();
        Mage::log(" Admin user with ID: $userId and username: $userName logged in at $loginTime", null, 'admin_login.log');
    }
}