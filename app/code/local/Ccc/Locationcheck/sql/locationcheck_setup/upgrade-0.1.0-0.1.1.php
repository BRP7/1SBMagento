<?php


$installer = $this;
$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$entityTypeId = $setup->getEntityTypeId('catalog_product');

// Add brand attribute
$setup->addAttribute(
    $entityTypeId,
    'is_exclude_location_check',
    array(
        'group' => 'general',
        'type' => 'varchar',
        'label' => 'Is_Exclude_Location_Check',
        'input' => 'select',
        'source' => 'eav/entity_attribute_source_table',
        'required' => false,
        'user_defined' => true,
        'searchable' => true,
        'filterable' => true,
        'visible_on_front' => true,
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'option' => array(
            'value' => array(
                'Yes' => array('Yes'),
                'No' => array('No'),
            )
        )
    )
);

// Add options
// $attributeId = $installer->getAttributeId($entityTypeId, 'is_exclude_location_check');
// $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attributeId);

// $attribute->setData('option', array(
//     'value' => array(
//         'Chanel' => array('Chanel'),
//         'Nike' => array('Nike'),
//         'Adidas' => array('Adidas'),
//         // Add more options here as needed
//     )
// )
// )->save();

// $installer->endSetup();
?>