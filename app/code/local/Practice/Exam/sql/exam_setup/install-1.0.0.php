<?php

$installer = $this;

$installer->startSetup();

/**
 * Drop table 'practice_customgrid' if it exists
 */
$tableName = $installer->getTable('practice_permissionpractice/permissionpractice');
if ($installer->getConnection()->isTableExists($tableName)) {
    echo "Table $tableName already exists.\n";
    return;
}

$table = $installer->getConnection()
    ->newTable($tableName)
    ->addColumn(
        'permissionpractice_id',
        Varien_Db_Ddl_Table::TYPE_SMALLINT,
        null,
        [
            'identity' => true,
            'nullable' => false,
            'primary' => true,
        ],
        'Customgrid Id'
    )
    ->addColumn(
        'grid_name',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        255,
        [
            'nullable' => false,
        ],
        'Grid Name'
    )
    ->addColumn(
        'show_on',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        255,
        [],
        'Show On'
    )
    ->addColumn(
        'status',
        Varien_Db_Ddl_Table::TYPE_SMALLINT,
        null,
        [
            'nullable' => false,
            'default' => '1',
        ],
        'Status'
    )
    ->setComment('Permissionpractice Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();
