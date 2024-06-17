<?php

$installer = $this;

$installer->startSetup();

$tableName = $installer->getTable('ccc_ticketsystem/ticketsystem');

if ($installer->getConnection()->isTableExists($tableName)) {
    Mage::log("Table $tableName already exists", null, 'ccc_ticketsystem.log');
    return;
}
$table = $installer->getConnection()
    ->newTable($installer->getTable('ccc_ticketsystem/ticketsystem'))
    ->addColumn('ticket_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Ticket Id')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Title')
    ->addColumn('descreption', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => false,
    ), 'Descreption')
    ->addColumn('assign_by', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => false,
    ), 'Assign By')
    ->addColumn('assign_to', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => false,
    ), 'Assign To')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
        'nullable' => false,
        'default'  => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
    ], 'Created At')
    ->addColumn('updated_date', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
        'nullable' => false,
        'default'  => Varien_Db_Ddl_Table::TIMESTAMP_INIT_UPDATE,
    ], 'Updated Date')
    ->setComment('Ticket Table');
$installer->getConnection()->createTable($table);




$tableName = $installer->getTable('ccc_ticketsystem/comment');

if ($installer->getConnection()->isTableExists($tableName)) {
    Mage::log("Table $tableName already exists", null, 'ccc_comment.log');
    return;
}
$table = $installer->getConnection()
    ->newTable($installer->getTable('ccc_ticketsystem/comment'))
    ->addColumn('comment_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Ticket Id')
    ->addColumn('descreption', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => false,
    ), 'Descreption')
    ->addColumn('ticket_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable' => false,
    ), 'Ticket Id')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
        'nullable' => false,
        'default'  => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
    ], 'Created At')
    ->addColumn('updated_date', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
        'nullable' => false,
        'default'  => Varien_Db_Ddl_Table::TIMESTAMP_INIT_UPDATE,
    ], 'Updated Date')
    ->setComment('Ticket Table');
$installer->getConnection()->createTable($table);



$tableName = $installer->getTable('ccc_ticketsystem/status');

if ($installer->getConnection()->isTableExists($tableName)) {
    Mage::log("Table $tableName already exists", null, 'ccc_status.log');
    return;
}
$table = $installer->getConnection()
    ->newTable($installer->getTable('ccc_ticketsystem/status'))
    ->addColumn('status_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Status Id')
    ->addColumn('code', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Code')
    ->addColumn('label', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Label')
    ->addColumn('color_code', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Color Code')
    ->addColumn('ticket_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable' => false,
    ), 'Ticket Id')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
        'nullable' => false,
        'default'  => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
    ], 'Created At')
    ->addColumn('updated_date', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
        'nullable' => false,
        'default'  => Varien_Db_Ddl_Table::TIMESTAMP_INIT_UPDATE,
    ], 'Updated Date')
    ->setComment('Ticket Table');
$installer->getConnection()->createTable($table);

$installer->getConnection()->addForeignKey(
    $installer->getFkName('ccc_ticketsystem/status', 'ticket_id', 'ccc_ticketsystem/ticketsystem', 'ticket_id'),
    $installer->getTable('ccc_ticketsystem/status'),
    'ticket_id',
    $installer->getTable('ccc_ticketsystem/ticketsystem'),
    'ticket_id',
    Varien_Db_Ddl_Table::ACTION_CASCADE,
    Varien_Db_Ddl_Table::ACTION_CASCADE
);

$installer->getConnection()->addForeignKey(
    $installer->getFkName('ccc_ticketsystem/comment', 'configuration_id', 'ccc_ticketsystem/ticketsystem', 'ticket_id'),
    $installer->getTable('ccc_ticketsystem/comment'),
    'ticket_id',
    $installer->getTable('ccc_ticketsystem/ticketsystem'),
    'ticket_id',
    Varien_Db_Ddl_Table::ACTION_CASCADE,
    Varien_Db_Ddl_Table::ACTION_CASCADE
);

$installer->endSetup();
