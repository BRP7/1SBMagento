<?php
$installer = $this;
$installer->startSetup();
$tableName = $installer->getTable('ccc_filetransfer/ftpconfiguration');
$table = $installer->getConnection()
     ->addColumn($tableName, 'is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, [
        'nullable' => false,
        'default' => '1',
    ], 'Is Active');
$installer->endSetup();

