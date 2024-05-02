<?php
$installer = $this;
$installer->startSetup();

$attributeCode = 'brand'; // Change this to your existing attribute code
$attributeId = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('catalog_product', $attributeCode);

// Check if the attribute exists
// if ($attributeId) {
    $option = array(
        'attribute_id' => $attributeId,
        'sort_order' => 100, // Change the sort order as needed
    );

    $installer->getConnection()->insert($installer->getTable('eav_attribute_option'), $option);
    $optionId = $installer->getConnection()->lastInsertId();

    // Add option values for different store views
    $optionValue = array(
        array('option_id' => $optionId, 'store_id' => 0, 'value' => 'Hybe'), // Default store view
        // Add more store view values if necessary
    );

    $installer->getConnection()->insertMultiple(
        $installer->getTable('eav_attribute_option_value'),
        $optionValue
    );

    // Refresh attribute options cache
    Mage::app()->cleanCache(array(Mage_Eav_Model_Entity_Attribute::CACHE_TAG));

//     echo "Hybe option added successfully to the $attributeCode attribute.";
// } else {
//     // echo "Attribute not found!";
// }

$installer->endSetup();
?>
