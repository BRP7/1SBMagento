<?php
$installer = $this;
$installer->startSetup();
$tableName = $installer->getTable('ccc_filetransfer/ftpfile');
$installer->getConnection()
    ->addColumn($tableName, 'file_name', [
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable' => false,
        'comment' => 'File Name'
    ]);

$installer->getConnection()
    ->addColumn($tableName, 'created_at', [
        'type' => Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        'nullable' => false,
        'default'  => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
        'comment' => 'Created At'
    ]);
$installer->endSetup();

