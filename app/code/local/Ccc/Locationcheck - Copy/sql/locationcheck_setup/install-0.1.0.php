<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Ccc
 * @package     Ccc_Banner
 * @copyright  Copyright (c) 2006-2018 Magento, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * drop table 'ccc/banner' if it exist
 */
$tableName = $installer->getTable('ccc_locationcheck/locationcheck');
if ($installer->getConnection()->isTableExists($tableName)) {
    // Table already exists, log a message and return
    Mage::log("Table $tableName already exists", null, 'ccc_locationcheck.log');
    return;
}
/**
 * Create table 'ccc/banner'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('ccc_locationcheck/locationcheck'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Id')
    ->addColumn('zipcode', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable' => false,
    ), 'Zipcode')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
    ), 'Is Active')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
        'nullable' => false,
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
    ], 'Created At')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
        'nullable' => false,
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
    ], 'Updated At')
    ->setComment('CCC Location Check Table');
$installer->getConnection()->createTable($table);
$installer->endSetup();
