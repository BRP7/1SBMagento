
<?php













// $installer = $this;//Mage_Core_Model_Resource_Setup
// $installer->startSetup();

// // Load the eav/entity_setup model
// $entitySetup = Mage::getModel('eav/entity_setup', 'core_setup');

// // Define the attribute code
// $attributeCode = 'brand';

// // Get the attribute model
// $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attributeCode);

// // Get the attribute ID
// $attributeId = $attribute->getId();

// if ($attributeId) {
//     // Define the options to be added
//     $options = array(
//         'Hermes' => array(
//             0 => 'Hermes', // Default label (admin store view)
//             1 => 'Hermes', // Label for store view with ID 1 (English,French,...)
//             // Add more store view labels if necessary
//         ),
//         'Chanel' => array(
//             0 => 'Chanel', // Default label (admin store view)
//             1 => 'Chanel', // Label for store view with ID 1
//             // Add more store view labels if necessary
//         ),
//         'Chambor' => array(
//             0 => 'Chambor', // Default label (admin store view)
//             // 1 => 'Chanel', // Label for store view with ID 1
//             // Add more store view labels if necessary
//         ),
//     );

//     // Check if options already exist
//     $existingOptions = $attribute->getSource()->getAllOptions();

//     // Loop through options and add if not already existing
//     foreach ($options as $value => $labels) {
//         $found = false;
//         foreach ($existingOptions as $existingOption) {
//             if ($existingOption['label'] == $labels[0]) {
//                 $found = true;
//                 break;
//             }
//         }

//         if (!$found) {
//             $entitySetup->addAttributeOption(['attribute_id' => $attributeId, 'value' => ['0' => $labels]]);
//             // echo "$value option added successfully to the $attributeCode attribute.\n";
//         } else {
//             // echo "$value option already exists in the $attributeCode attribute.\n";
//         }
//     }
// } else {
//     // echo "Attribute '$attributeCode' not found.\n";
// }

// $installer->endSetup();
?>
