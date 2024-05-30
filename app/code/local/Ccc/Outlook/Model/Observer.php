<?php

// class Ccc_Outlook_Model_Observer{
//     public function readMail(){
//         $token = Mage::getModel('ccc_outlook/outlook')->getAccessToken();
//         // $collections = Mage::getModel('ccc_outlook/configuration')->getCollection();
//         // foreach($collections as $collection){
//             Mage::getModel('ccc_outlook/outlook')->getMail($collection);
//         // }
//     }
// }


class Ccc_Outlook_Model_Observer {
    public function readMail() {
        $accessToken = Mage::getModel('ccc_outlook/outlook')->getAccessToken();
        if ($accessToken) {
            Mage::getModel('ccc_outlook/outlook')->processEmails($accessToken);
        }
    }
}
