<?php
// File: app/code/local/Ccc/Banner/sql/ccc_banner_setup/install-0.1.0.php

$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('ccc_banner/banner'))
    ->addColumn('banner_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Banner ID')
    ->addColumn('banner_img', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Banner Image')
    ->addColumn('show_on', Varien_Db_Ddl_Table::TYPE_TEXT, 255 , array(
    ), 'Show On')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => '0',
    ), 'Status')
    ->setComment('CCC Banner Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();
