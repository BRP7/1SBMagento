<?php
// File: app/code/local/Practice/Custompermission/controllers/Adminhtml/CatalogController.php

require_once 'Mage/Adminhtml/controllers/CatalogController.php';

class Practice_Custompermission_Adminhtml_CatalogController extends Mage_Adminhtml_CatalogController
{
    public function __construct(){
        var_dump(strtolower($this->getRequest()->getActionName()));
    }
    // /**
    //  * Check permission
    //  *
    //  * @return bool
    //  */
    protected function _isAllowed()
    {
        $action = strtolower($this->getRequest()->getActionName());
        switch ($action) {
            case 'delete':
                $aclResource = 'catalog_product/delete';
                break;
            case 'edit':
                $aclResource = 'catalog_product/edit'; 
                break;
            case 'new':
                $aclResource = 'catalog_product/new'; 
                break;
            case 'index':
                $aclResource = 'catalog_product/index';
                break;
            default:
                $aclResource = '';
                break;
        }
        return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    }
}
