

<?php
// Define upgrade script
$installer = $this;
$installer->startSetup();

// Add status column to the table
$installer->getConnection()
    ->addColumn($installer->getTable('sales_flat_order'), 'product_execluded_location_checked', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'nullable'  => true,
        'default'   => 0,
        'comment'   => 'Is Location Checked'
    ));

$installer->endSetup();
