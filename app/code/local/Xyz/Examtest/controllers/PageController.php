<?php 

class Xyz_Examtest_PageController extends Mage_Core_Controller_Front_Action{

    public function indexAction(){
        echo "Page Controller ";
        echo "<br>";
        $varAbc = Mage::getModel('xyz_examtest/examtest');
        echo "<br>";
        var_dump(get_class($varAbc));
    }

}
?>