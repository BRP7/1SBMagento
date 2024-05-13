<?php
class Practice_Custompermission_Block_Adminhtml_Catalog_Category_Grid extends Mage_Adminhtml_Block_Catalog_Category_Edit
{
    public function getRowUrl($row)
    {
        if (Mage::getSingleton('admin/session')->isAllowed('catalog_product/edit')) {
            return $this->getUrl('*/*/edit', array(
                'store'=>$this->getRequest()->getParam('store'),
                'id'=>$row->getId()));
        }
        return false;
    }
}
?>