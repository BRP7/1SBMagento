<?php
$installer = $this;
$installer->startSetup();

// Create the role
$role = Mage::getModel('admin/role')
    ->setName('Catalog Manager')
    ->setRoleType('G')
    ->setRoleName('catalog_manager')
    ->setTreeLevel(1)
    ->save();

// Define ACL resources
$resources = array(
    'admin/catalog/category',
    'admin/catalog/product'
);

// Assign permissions to the role
foreach ($resources as $resource) {
    Mage::getModel('admin/rules')
        ->setRoleId($role->getId())
        ->setResources(array($resource))
        ->saveRel();
}

// Create the admin user
$adminUser = Mage::getModel('admin/user')
    ->setData(array(
        'username'  => 'catalog_manager',
        'firstname' => 'Catalog',
        'lastname'  => 'Manager',
        'email'     => 'catalog_manager@example.com',
        'password'  => 'password123',
        'is_active' => 1
    ))
    ->save();

// Assign the role to the user
$adminUser->setRoleIds(array($role->getId()))
    ->setRoleUserId($adminUser->getUserId())
    ->saveRelations();

$installer->endSetup();