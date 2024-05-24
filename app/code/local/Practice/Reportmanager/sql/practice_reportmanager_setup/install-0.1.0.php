<?php
$installer = $this;

$installer->startSetup();

$tableName = $installer->getTable('practice_reportmanager/reportmanager');
if ($installer->getConnection()->isTableExists($tableName)) {
    Mage::log("Table $tableName already exists", null, 'reportmanager.log');
    return;
}

$table = $installer->getConnection()
    ->newTable($installer->getTable('practice_reportmanager/reportmanager'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Id')
    ->addColumn('user_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable' => false,
    ), 'User Id')
    // ->addColumn('zipcode', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
    //     'nullable' => false,
    // ), 'Zipcode')
    ->addColumn('report_type', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
    ), 'Report Type')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
    ), 'Is Active')
    ->addColumn('filter_data', Varien_Db_Ddl_Table::TYPE_TEXT, array(
        'nullable' => false,
    ), 'Filter Data')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
        'nullable' => false,
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
    ], 'Created At')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
        'nullable' => false,
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
    ], 'Updated At')
    ->setComment('Prctice Report Manager Table');
$installer->getConnection()->createTable($table);
$installer->endSetup();
