<?php 

class Ccc_Testtwo_IndexController extends Mage_Core_Controller_Front_Action{

    public function indexAction(){
        echo 1232;
        $varAbc = Mage::getModel('testtwo/xyz');
        var_dump(get_class($varAbc));
    }

}
?>