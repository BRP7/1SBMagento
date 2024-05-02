<?php

$installer = $this;
$installer->startSetup();

// Function to add option to attribute
function addOptionToAttribute($installer, $attributeCode, $optionLabel)
{
    // Load the attribute model
    $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attributeCode);

    // Check if the attribute exists
    if ($attribute && $attribute->getId()) {
        // Load attribute options
        $options = $attribute->getSource()->getAllOptions(false);

        // Check if the option already exists
        $optionExists = false;
        foreach ($options as $option) {
            if ($option['label'] == $optionLabel) {
                $optionExists = true;
                break;
            }
        }

        // If the option doesn't exist, add it
        if (!$optionExists) {
            // Prepare data for the new option
            $data = array(
                'attribute_id' => $attribute->getId(),
            );

            // Insert option into the attribute option table
            $installer->getConnection()->insert(
                $installer->getTable('eav_attribute_option'),
                $data
            );

            // Get the new option id
            $optionId = $installer->getConnection()->lastInsertId();

            // Add option label for the default store view
            $data = array(
                'option_id' => $optionId,
                'store_id' => 0, // Default store view
                'value' => $optionLabel
            );

            // Insert option value into the attribute option value table
            $installer->getConnection()->insert(
                $installer->getTable('eav_attribute_option_value'),
                $data
            );

            echo "$optionLabel option added successfully to the $attributeCode attribute.\n";
        } else {
            echo "Option '$optionLabel' already exists for the $attributeCode attribute.\n";
        }
    } else {
        echo "Attribute '$attributeCode' not found.\n";
    }
}

// Add options
addOptionToAttribute($installer, 'brand', 'Hermes');
addOptionToAttribute($installer, 'brand', 'Chanel');

$installer->endSetup();
?>
