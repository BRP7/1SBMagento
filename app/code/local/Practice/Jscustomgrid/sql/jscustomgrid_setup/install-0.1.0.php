<?php

$installer = $this;
$installer->startSetup();

$installer->addAttribute('catalog_product', 'custom_select_attribute', array(
    'type' => 'int',
    'backend' => '',
    'frontend' => '',
    'label' => 'Custom Select Attribute',
    'input' => 'select',
    'class' => '',
    'source' => 'eav/entity_attribute_source_table',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'default' => '',
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => false,
    'unique' => false,
    'apply_to' => '',
    'is_configurable' => false,
));

$installer->endSetup();
