<?php
// File: mysql4-upgrade-1.0.1-1.0.2.php

$installer = $this;
$installer->startSetup();

// Get attribute id of the brand attribute
$attributeId = $installer->getAttributeId('catalog_product', 'brand');

// Make the brand attribute visible on the frontend product pages
$installer->updateAttribute('catalog_product', $attributeId, 'is_visible_on_front', 1);

$installer->endSetup();
?>
