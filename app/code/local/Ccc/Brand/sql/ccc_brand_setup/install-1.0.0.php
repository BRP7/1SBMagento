<?php
// File: install-1.0.0.php

// $installer = $this;
// $installer->startSetup();

// $setup = new Mage_Eav_Model_Entity_Setup('core_setup');

// $entityTypeId = $setup->getEntityTypeId('catalog_product');

// // Add brand attribute
// $setup->addAttribute(
//     $entityTypeId,
//     'brand',
//     array(
//         'group' => 'Clothing',
//         'type' => 'varchar',
//         'label' => 'Brand',
//         'input' => 'select',
//         'source' => 'eav/entity_attribute_source_table',
//         'required' => false,
//         'user_defined' => true,
//         'searchable' => true,
//         'filterable' => true,
//         'visible_on_front' => true,
//         'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
//     )
// );

// // Add options
// $attributeId = $installer->getAttributeId($entityTypeId, 'brand');
// $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attributeId);

// $attribute->setData('option', array(
//     'value' => array(
//         'Chanel' => array('Chanel'),
//         'Nike' => array('Nike'),
//         'Adidas' => array('Adidas'),
//         // Add more options here as needed
//     )
// ))->save();

// $installer->endSetup();
?>
