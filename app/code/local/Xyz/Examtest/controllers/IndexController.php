<?php

class Xyz_Examtest_IndexController extends Mage_Core_Controller_Front_Action{

    public function indexAction(){
       
        // die("Reached here");
        echo 123;
    }

    public function editAction(){
        echo "Hello World";
        echo "IndexController action is working"; // Test message
        exit;
    }
}