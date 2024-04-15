<?php


/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * Create table 'cms/block'
 */
$table = $installer->getConnection()
    // ->newTable($installer->getTable('Inventory_configuration'))
    ->newTable($installer->getTable('ccc_vendorinventory/ccc_vendorinventory'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'ID')
    ->addColumn('configuration_name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Configuration Name')

    ->addColumn('fileformat', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'File Format')

    ->addColumn('filename', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'File Name')
    
    ->setComment('Vendor Inventory Configuration Table');
    // print_r($table);
    $installer->getConnection()->createTable($table);