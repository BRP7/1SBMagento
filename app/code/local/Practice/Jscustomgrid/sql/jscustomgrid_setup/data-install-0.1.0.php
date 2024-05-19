<?php

$installer = $this;
$installer->startSetup();

$attributeCode = 'custom_select_attribute';
$attributeId = $installer->getAttributeId('catalog_product', $attributeCode);

$options = array(
    'option_1' => array(
        'order' => 1,
        'value' => 'Option 1'
    ),
    'option_2' => array(
        'order' => 2,
        'value' => 'Option 2'
    ),
);

foreach ($options as $key => $option) {
    $installer->addAttributeOption(array(
        'attribute_id' => $attributeId,
        'sort_order' => $option['order'],
        'value' => array(
            'option_0' => array($option['value'])
        )
    ));
}

$installer->endSetup();
