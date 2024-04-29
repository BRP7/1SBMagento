<?php

require_once("../app/Mage.php");

Mage::run();

Mage::getModel('vendorinventory/observer')->readcsv();