<?php
// File: mysql4-install-1.0.0.php
//upgrade file: mysql4-upgrade-x.x.x-x.x.x.php

$installer = $this;
$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$entityTypeId = $setup->getEntityTypeId('catalog_product');

// echo "Add new attribute";
$setup->addAttribute(
    $entityTypeId,
    'pink_venom',
    array(
        'group' => 'Clothing', // Change group name to 'General' or any other existing group
        'type' => 'int',
        'label' => 'Pink Venom',
        'input' => 'select',
        'visible' => true,
        'required' => false,
        'user_defined' => true,
        'searchable' => true,
        'filterable' => true,
        'comparable' => true,
        'visible_on_front' => true,
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'option' => array(
            'values' => array( // Define your select options here
                'Pink',
                'Blue',
                'Black'
            )
        )
    )
);

$installer->endSetup();
?>
