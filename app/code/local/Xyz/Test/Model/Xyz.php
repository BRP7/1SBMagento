<?php

class Xyz_Test_Model_Xyz extends Mage_Core_Model_Abstract
{
    public function __construct(){
        echo "<br>";
        echo get_class($this);
        echo 22;
    }   
}
?>