
<?php

echo 123213;

$installer = $this;
$installer->startSetup();

// Create a role
$role = Mage::getModel('admin/role')
    ->setName('Custom Role')
    ->setRoleType('G')
    ->setTreeLevel(1)
    ->save();

// Set role resources
Mage::getModel('admin/rule')
    ->setRoleId($role->getId())
    ->setResources(array('all'))
    ->saveRel();

// Create a user
$user = Mage::getModel('admin/user')
    ->setData(array(
        'username'  => 'newuser',
        'firstname' => 'First',
        'lastname'  => 'Last',
        'email'     => 'newuser@example.com',
        'password'  => '123',
        'is_active' => 1
    ))->save();

// Assign role to user
Mage::getModel('admin/user')->setUserId($user->getId())->setRoleIds(array($role->getId()))->saveRelations();

$installer->endSetup();
