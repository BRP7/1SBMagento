<?php
class Practice_Examtwo_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        echo 1233;
        // var_dump(Mage::helper('practice_examtwo')->isCustomReportsEnabled());
        if (!Mage::helper('practice_examtwo')->isCustomReportsEnabled()) {
            echo 999;
            // $this->_forward('noRoute');
            return;
        }
        $this->loadLayout();
        $this->renderLayout();
    }
}
