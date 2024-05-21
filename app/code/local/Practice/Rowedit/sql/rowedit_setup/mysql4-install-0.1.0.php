<?php
$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('practice_rowedit/rowedit'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ], 'Entity ID')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, [
        'nullable' => false,
    ], 'Name')
    ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, null, [
        'nullable' => true,
    ], 'Description')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
        'nullable' => false,
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
    ], 'Created At')
    ->setComment('Practice Rowedit Table');

$installer->getConnection()->createTable($table);

$installer->endSetup();
