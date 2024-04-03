<?php 

class Xyz_Test_PageController extends Mage_Core_Controller_Front_Action{

    public function indexAction(){
        echo "Page Controller ";
        echo "<br>";
        $varAbc = Mage::getModel('test/xyz');
        echo "<br>";
        var_dump(get_class($varAbc));
    }

}
?>