<?php

$installer = $this;
$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$entityTypeId = $setup->getEntityTypeId('catalog_product');

$setup->addAttribute(
    $entityTypeId,
    'is_exclude_location_check',
    array(
        'group' => 'General',
        'type' => 'int',
        'label' => 'Exclude Location Check',
        'input' => 'select',
        'source' => 'eav/entity_attribute_source_boolean',
        'required' => false,
        'user_defined' => true,
        'searchable' => true,
        'filterable' => true,
        'visible_on_front' => true,
        'default' => '0',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    )
);

$installer->endSetup();
