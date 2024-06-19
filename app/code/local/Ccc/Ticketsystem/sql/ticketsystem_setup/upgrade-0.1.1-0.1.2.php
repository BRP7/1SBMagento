<?php

$installer = $this;

$installer->startSetup();

$tableName = $installer->getTable('ccc_ticketsystem/filter');

if ($installer->getConnection()->isTableExists($tableName)) {
    Mage::log("Table $tableName already exists", null, 'ccc_store_filter.log');
    return;
}
$table = $installer->getConnection()
    ->newTable($installer->getTable('ccc_ticketsystem/filter'))
    ->addColumn('filter_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Filter Id')
    ->addColumn('label', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Label')
    ->addColumn('field', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Field')
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Value')
    ->setComment('Store Filter Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();
