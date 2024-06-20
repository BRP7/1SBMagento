<?php
$installer = $this;
$installer->startSetup();
$tableTicketSystem = $installer->getTable('ccc_ticketsystem/comment');

$installer->getConnection()->addColumn($tableTicketSystem, 'parent_id', array(
    'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'nullable' => false,
    'comment' => 'Parent Id',
)
);

$installer->endSetup();
