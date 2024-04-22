<?php
$installer = $this;
$installer->startSetup();

// Table 1: Inventory_configuration
$table = $installer->getConnection()
    // ->newTable($installer->getTable('inventory_configuration'))
    ->newTable($installer->getTable('vendorinventory/configuration'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
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
    ->setComment('Inventory Configuration Table');
$installer->getConnection()->createTable($table);

// Table 2: Inventory_configuration_rule
$table = $installer->getConnection()
    // ->newTable($installer->getTable('inventory_configuration_rule'))
    ->newTable($installer->getTable('vendorinventory/rule'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'ID')
    ->addColumn('condition', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Condition')
    ->addColumn('condition_operators', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Condition Operators')
    ->addColumn('condition_value', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Condition Value')
    ->addColumn('display_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable'  => false,
    ), 'Display Date')
    ->setComment('Inventory Configuration Rule Table');
$installer->getConnection()->createTable($table);

// Table 3: Inventory_instock_date
$table = $installer->getConnection()
    // ->newTable($installer->getTable('inventory_instock_date'))
    ->newTable($installer->getTable('vendorinventory/instock_date'))
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Product ID')
    ->addColumn('product_name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Product Name')
    ->addColumn('sku', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'SKU')
    ->addColumn('instock_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable'  => false,
    ), 'Instock Date')
    ->addColumn('available_qty', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
    ), 'Available Quantity')
    ->addColumn('next_available_qty', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
    ), 'Next Available Quantity')
    ->addColumn('restock_days', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
    ), 'Restock Days')
    ->addColumn('price', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
    ), 'Price')
    ->addColumn('created_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable'  => false,
    ), 'Created Date')
    ->addColumn('ship_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable'  => false,
    ), 'Ship Date')
    ->addColumn('product_status', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Product Status')
    ->setComment('Inventory Instock Date Table');
$installer->getConnection()->createTable($table);

$table = $installer->getConnection()
    ->newTable($installer->getTable('vendorinventory/vendorinventory'))
    ->addColumn('config_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'ID')
    ->addColumn('brand_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable'  => false,
    ), 'brandid')
    ->setComment('vendorInventory Block Table');
$installer->getConnection()->createTable($table);


$table = $installer->getConnection()
    ->newTable($installer->getTable('vendorinventory/configdata'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'ID')
    ->addColumn('config_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable' => false,
    ), 'config_id')
    ->addColumn('brand_data', Varien_Db_Ddl_Table::TYPE_TEXT,255, array(
        'nullable' => false,
    ), 'Brand Data')
   
    ->setComment('vendorInventory Brand Config Data Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();



