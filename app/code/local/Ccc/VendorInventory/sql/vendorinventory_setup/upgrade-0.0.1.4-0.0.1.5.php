<?php

$installer = $this;
$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$entityTypeId = $setup->getEntityTypeId('catalog_product');

$setup->addAttribute(
    $entityTypeId,
    'instock_date',
    array(
        'group' => 'General',
        'type' => 'varchar', // Corrected attribute type
        'label' => 'In Stock Date', 
        'input' => 'date',
        'visible' => true,
        'required' => false,
        'user_defined' => true,
        'searchable' => false, 
        'filterable' => false, 
        'comparable' => false, 
        'visible_on_front' => true,
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL, 
    )
);

$installer->endSetup();
?>
