<?php

class Practice_Permissionpractice_IndexController extends Mage_Core_Controller_Front_Action {
    public function indexAction()
    {
        // echo Mage::getStoreConfig('practice_permissionpractice/general/custom_message_1');
        $message1 = Mage::helper('practice_permissionpractice')->getCustomMessage1();
        $message2 = Mage::helper('practice_permissionpractice')->getCustomMessage2();
        $message3 = Mage::helper('practice_permissionpractice')->getCustomMessage3();

        echo "Message 1: " . $message1 . "<br>";
        echo "Message 2: " . $message2 . "<br>";
        echo "Message 3: " . $message3 . "<br>";
    }

}
