<?php

class Ccc_VendorInventory_Model_Observer
{

    public function readcsv()
    {
        echo 123;

    //     $brand = [];
    //     // Load the product model
    //     $product = Mage::getModel('catalog/product');

    //     // Get the 'brand' attribute model
    //     $attribute = Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product', 'brand');

    //     if ($attribute && $attribute->getId()) {

    //         $options = $attribute->getSource()->getAllOptions(false);
    //         // echo 123;
    //         foreach ($options as $option) {
    //             if ($option['label'] == "Zara")
    //                 $id = $option['value'];
    //         }
    //     }
    //     // echo $id;

    //     $path = Mage::getBaseDir('var') . DS . 'inventory' . DS . $id . DS . 'inventory.csv';
    //     // echo $path;
    //     $row = 0;
    //     $header = [];
    //     $array = [];
    //     if (($open = fopen($path, "r")) !== false) {
    //         // echo 1222;
    //         while (($data = fgetcsv($open, 1000, ",")) !== false) {
    //             if (!$row) {
    //                 // echo 123;
    //                 $header = $data;
    //                 $row++;
    //                 continue;
    //             }

    //             $array[] = array_combine($header, $data);
    //             // echo "<pre>";
    //             // print_r($array);

    //         }

    //     $config = Mage::getModel('vendorinventory/configration')->load($id, 'brand_id');
    //     // print_r($config->getId());
    //     $branddata = Mage::getModel('vendorinventory/configrationdata')->load($config->getId(),'config_id')->getData();
    //         // print_r($branddata);
    //         $serial = unserialize($branddata['data']);
    //         // print_r($serial);

    //     }

    //     $ans=$this->rulecheck($array,$serial);
    //     print_r($ans);
    // }

   

    // public function ruleCheck($array, $configArray)
    // {
    //     // print_r($array);
    //     // print_r($configArray);
    //     $resultArray = []; // Initialize an empty array to store the result
    
    //     foreach ($array as $item) {
    //         $matched = true; // Initialize the matched flag as true for each item
    
    //         foreach ($configArray as $field => $rules) {
    //             // Check if the field exists in the item
    //             if (!isset($item[$field])) {
    //                 $matched = false; // Set matched to false if the field is missing
    //                 break; // Break out of the inner loop
    //             }
    
    //             // Compare the value of the field with each rule
    //             foreach ($rules as $rule) {
    //                 // Perform comparison based on the rule
    //                 switch ($rule['operator']) {
    //                     case '==':
    //                         if ($item[$field] != $rule['value']) {
    //                             $matched = false; // Set matched to false if the values don't match
    //                             break 2; // Break out of both inner and outer loops
    //                         }
    //                         break;
    //                     case '!=':
    //                         if ($item[$field] == $rule['value']) {
    //                             $matched = false; // Set matched to false if the values match
    //                             break 2; // Break out of both inner and outer loops
    //                         }
    //                         break;
    //                     // Add more cases for other comparison operators if needed
    //                 }
    //             }
    //         }
    
    //         // If matched is still true, add the item to the result array
    //         if ($matched) {
    //             $resultArray[] = $item;
    //         }
    //     }
    
    //     // Now $resultArray contains only the items that match all the rules
    //     return $resultArray;
    }
    
}


?>