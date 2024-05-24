<?php
$installer = $this;
$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$entityTypeId = $setup->getEntityTypeId('catalog_product');

$setup->addAttribute(
    $entityTypeId,
    'sold_count',
    array(
        'group' => 'General',
        'type' => 'int',
        'label' => 'Sold Count',
        'input' => 'text',
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
