<?php
// File: app/code/local/Ccc/Blockoverride/controllers/ProductController.php

require_once 'Mage/Catalog/controllers/ProductController.php';

class Ccc_Blockoverride_ProductController extends Mage_Catalog_ProductController
{
    // public function _construct(){
    //     echo 12;
    // }
    public function viewAction()
    {
       
        // Your custom logic here
        echo "This is the overridden product view action!";
        // Call parent action
        parent::viewAction();
    }
}
