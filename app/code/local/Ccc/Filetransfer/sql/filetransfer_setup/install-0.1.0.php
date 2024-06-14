<?php

$installer = $this;

$installer->startSetup();

$tableName = $installer->getTable('ccc_filetransfer/ftpconfiguration');

if ($installer->getConnection()->isTableExists($tableName)) {
    Mage::log("Table $tableName already exists", null, 'ccc_filetransfer_configuration.log');
    return;
}
$table = $installer->getConnection()
    ->newTable($installer->getTable('ccc_filetransfer/ftpconfiguration'))
    ->addColumn('configuration_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Configuration Id')
    ->addColumn('username', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'User Name')
    ->addColumn('password', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Password')
    ->addColumn('port', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable' => false,
    ), 'Port')
     ->addColumn('host', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Host')
    ->setComment('CCC Filetransfer Configuration Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();
