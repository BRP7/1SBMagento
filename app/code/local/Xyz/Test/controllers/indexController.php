<?php 

class Xyz_Test_IndexController extends Mage_Core_Controller_Front_Action{

    public function indexAction(){
        echo "XYZ";
        $varAbc = Mage::getModel('demo/xyz');
        var_dump(get_class($varAbc));
    }

}
?>