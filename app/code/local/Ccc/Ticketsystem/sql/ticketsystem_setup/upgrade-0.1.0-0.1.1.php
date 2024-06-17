<?php
$installer = $this;
$installer->startSetup();
$tableStatus = $installer->getTable('ccc_ticketsystem/status');
$installer->getConnection()->dropForeignKey($tableStatus, $installer->getFkName('ccc_ticketsystem/status', 'ticket_id', 'ccc_ticketsystem/ticketsystem', 'ticket_id'));
$installer->getConnection()->dropColumn($tableStatus, 'ticket_id');
$tableTicketSystem = $installer->getTable('ccc_ticketsystem/ticketsystem');
$installer->getConnection()->addColumn(
    $tableTicketSystem,
    'priority',
    array(
        'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'nullable' => false,
        'default' => 0,
        'comment' => 'Priority',
        'after' => 'assign_to',
    )
);

$installer->getConnection()->changeColumn(
    $tableTicketSystem,
    'assign_to',
    'assign_to',
    array(
        'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'nullable' => false,
        'comment' => 'Assign To',
        'after' => 'assign_by',
    )
);

$installer->getConnection()->changeColumn(
    $tableTicketSystem,
    'assign_by',
    'assign_by',
    array(
        'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'nullable' => false,
        'comment' => 'Assign By',
    )
);
$installer->getConnection()->addColumn($tableTicketSystem, 'status_id', array(
    'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'nullable' => false,
    'comment' => 'Status Id',
    'after' => 'assign_to',
)
);

$installer->getConnection()->addForeignKey(
    $installer->getFkName('ccc_ticketsystem/ticketsystem', 'status_id', 'ccc_ticketsystem/status', 'status_id'),
    $tableTicketSystem,
    'status_id',
    $installer->getTable('ccc_ticketsystem/status'),
    'status_id',
    Varien_Db_Ddl_Table::ACTION_CASCADE,
    Varien_Db_Ddl_Table::ACTION_CASCADE
);


$installer->endSetup();
