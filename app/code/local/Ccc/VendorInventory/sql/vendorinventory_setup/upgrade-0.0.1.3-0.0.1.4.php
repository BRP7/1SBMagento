<?php


$installer = $this;
$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$entityTypeId = $setup->getEntityTypeId('catalog_product');

echo "Add new attribute";
$setup->addAttribute(
    $entityTypeId,
    'instock_date',
    array(
        // 'group' => 'General', // Add to the 'General' attribute set
        'type' => 'datetime', // Use 'datetime' for date with time
        'label' => 'In Stock Date', // Attribute Label
        'input' => 'date', // Use 'date' as input type
        'visible' => true,
        'required' => false,
        'user_defined' => true,
        'searchable' => false, // Set to false if you don't want this attribute to be searchable
        'filterable' => false, // Set to false if you don't want this attribute to be filterable
        'comparable' => false, // Set to false if you don't want this attribute to be comparable
        'visible_on_front' => true,
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL, // Set scope to 'SCOPE_STORE' for store-specific value
    )
);

$installer->endSetup();
?>
