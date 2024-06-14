<?php

$installer = $this;

$installer->startSetup();

$tableName = $installer->getTable('ccc_filetransfer/ftpfile');

if ($installer->getConnection()->isTableExists($tableName)) {
    Mage::log("Table $tableName already exists", null, 'ccc_filetransfer_filetransfer.log');
} else {
    $table = $installer->getConnection()
        ->newTable($installer->getTable('ccc_filetransfer/ftpfile'))
        ->addColumn('ftp_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
        ), 'Filetransfer Id')
        ->addColumn('file_path', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
        ), 'File Path')
        ->addColumn('configuration_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => false,
        ), 'Configuration Id')
        ->setComment('CCC Filetransfer Filetransfer Table');
    $installer->getConnection()->createTable($table);

    $installer->getConnection()->addForeignKey(
        $installer->getFkName('ccc_filetransfer/ftpfile', 'configuration_id', 'ccc_filetransfer/ftpconfiguration', 'configuration_id'),
        $installer->getTable('ccc_filetransfer/ftpfile'),
        'configuration_id',
        $installer->getTable('ccc_filetransfer/ftpconfiguration'),
        'configuration_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    );
}

$installer->endSetup();
