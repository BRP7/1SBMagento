<?php
// Define upgrade script
$installer = $this;
$installer->startSetup();

// Add status column to the table
$installer->getConnection()
    ->addColumn($installer->getTable('practice_rowedit/rowedit'), 'status', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
        'nullable'  => true,
        'default'   => null,
        'comment'   => 'Status'
    ));

$installer->endSetup();
