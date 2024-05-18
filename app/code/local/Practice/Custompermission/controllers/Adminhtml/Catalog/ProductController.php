<?php
// File: app/code/local/Practice/Custompermission/controllers/Adminhtml/CatalogController.php

require_once 'Mage/Adminhtml/controllers/Catalog/ProductController.php';

class Practice_Custompermission_Adminhtml_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController
{
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
                $aclResource = 'catalog/products/action/delete';
                break;
            case 'edit':
                $aclResource = 'catalog/products/action/edit';
                break;
            case 'new':
                $aclResource = 'catalog/products/action/new';
                break;
            case 'index':
                $aclResource = 'catalog/products/action/index';
                break;
            default:
                $aclResource = 'catalog/products/action/index';
                break;
        }
        return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    }
}
