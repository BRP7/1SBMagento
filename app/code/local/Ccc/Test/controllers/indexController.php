<?php 

class Ccc_Test_IndexController extends Mage_Core_Controller_Front_Action{

    public function indexAction()
    {
        echo "CCC";
        $varAbc = Mage::getModel('ccc_test/test');
        var_dump(get_class($varAbc));
    }


    
}
?>