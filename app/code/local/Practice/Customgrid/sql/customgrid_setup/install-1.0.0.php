<?php


$installer = $this;

$installer->startSetup();

/**
 * drop table 'ccc/banner' if it exist
 */
$tableName = $installer->getTable('customgrid/customgrid');
if ($installer->getConnection()->isTableExists($tableName)) {
    Mage::log("Table $tableName already exists", null, 'practice_customgrid.log');
    return;
}

$table = $installer->getConnection()
    ->newTable($tableName)
    ->addColumn('customgrid_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Banner Id')
    ->addColumn('grid_name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
    ), 'Banner Name')
    ->addColumn('show_on', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
    ), 'Show On ')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable' => false,
        'default' => '1',
    ), 'Status')
    ->setComment('Custom Grid Table');
$installer->getConnection()->createTable($table);
$installer->endSetup();
