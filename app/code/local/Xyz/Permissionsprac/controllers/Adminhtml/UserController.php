<?php
class Xyz_Permissionsprac_Adminhtml_UserController extends Mage_Adminhtml_Controller_Action
{
    public function createRoleAction()
    {
        $model = Mage::getModel('permissionsprac/admin');
        $role = $model->createRole('Custom Role', 'G', array('all'));

        Mage::getSingleton('adminhtml/session')->addSuccess('Role created successfully.');
        $this->_redirectReferer();
    }

    public function createUserAction()
    {
        $model = Mage::getModel('permissionsprac/admin');
        $role = $model->createRole('Custom Role', 'G', array('all')); // You can adjust parameters here based on your needs
        $user = $model->createUser('newuser', 'password123', 'First', 'Last', 'newuser@example.com', $role->getId());

        Mage::getSingleton('adminhtml/session')->addSuccess('User created successfully.');
        $this->_redirectReferer();
    }
}
