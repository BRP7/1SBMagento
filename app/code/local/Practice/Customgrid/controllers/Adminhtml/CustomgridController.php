<?php

class Practice_Customgrid_Adminhtml_CustomgridController extends Mage_Core_Controller_Front_Action{

    public function indexAction(){
        $this->loadLayout();
        $this->renderLayout();
    }
}