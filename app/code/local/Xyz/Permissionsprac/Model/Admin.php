<?php
class Xyz_Permissionsprac_Model_Admin extends Mage_Core_Model_Abstract
{
    public function createRole($roleName, $roleType = 'G', $resources = array('all'))
    {
        $role = Mage::getModel('admin/role');
        $role->setName($roleName)
             ->setRoleType($roleType)
             ->setTreeLevel(1)
             ->save();

        $role->setRoleType($roleType)->setRoleId($role->getId())->setResources($resources)->saveRel();

        return $role;
    }

    public function createUser($username, $password, $firstName, $lastName, $email, $roleId)
    {
        $user = Mage::getModel('admin/user')
            ->setData(array(
                'username'  => $username,
                'firstname' => $firstName,
                'lastname'  => $lastName,
                'email'     => $email,
                'password'  => $password,
                'is_active' => 1
            ))->save();

        $user->setRoleIds(array($roleId))
             ->setRoleUserId($user->getUserId())
             ->saveRelations();

        return $user;
    }
}
