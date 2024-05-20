<?php

class Practice_Jscustomgrid_Block_Adminhtml_Product_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('productGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        parent::_prepareCollection();
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('entity_id')
            ->addAttributeToSelect('brand')
            ->addAttributeToSelect('instock_date')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('custom_select_attribute');

        Mage::log($collection->getData(), null, 'custom.log', true);

        return $this->setCollection($collection);
    }

    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header' => Mage::helper('practice_jscustomgrid')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'entity_id',
        )
        );

        $this->addColumn('name', array(
            'header' => Mage::helper('practice_jscustomgrid')->__('Name'),
            'align' => 'left',
            'index' => 'name',
        )
        );

        $this->addColumn('brand', array(
            'header' => Mage::helper('practice_jscustomgrid')->__('Brand'),
            'align' => 'left',
            'index' => 'brand',
        )
        );

        $this->addColumn('instock_date', array(
            'header' => Mage::helper('practice_jscustomgrid')->__('In Stock Date'),
            'align' => 'left',
            'index' => 'instock_date',
        )
        );

        $this->addColumn('custom_select_attribute', array(
            'header' => Mage::helper('practice_jscustomgrid')->__('Custom Attribute'),
            'align' => 'left',
            'index' => 'custom_select_attribute',
            'editable' => true,
            'renderer' => 'Practice_Jscustomgrid_Block_Adminhtml_Widget_Grid_Column_Renderer_Editable',
        )
        );

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('product');

        return $this;
    }

    // public function getRowUrl($row)
    // {
    //     return 'javascript:void(0)';
    // }

    public function getRowClass(Varien_Object $row)
    {
        return 'product-name';
    }
    public function getRowId(Varien_Object $row)
    {
        return $row->getId();
    }

    // for inline css
    // public function getRowAttributes($row)
    // {
    //     return 'data-product-id="' . $row->getId() . '" data-update-url="' . $this->getUpdateUrl() . '" data-form-key="' . $this->getFormKey() . '"';
    // }


    public function getUpdateUrl()
    {
        return $this->getUrl('*/*/getProductDetails');
    }

    public function getFormKey()
    {
        return Mage::getSingleton('core/session')->getFormKey();
    }

    protected function _toHtml()
    {
        $updateUrl = $this->getUpdateUrl();
        $formKey = $this->getFormKey();
    
        // Get product IDs from the current collection
        $productIds = [];
        foreach ($this->getCollection() as $item) {
            $productIds[] = $item->getId();
        }
    
        // Convert the array of product IDs into a JavaScript variable
        $productIdsString = json_encode($productIds);
    
        // Echo JavaScript variables containing the URL, form key, and product IDs
        echo "<script type='text/javascript'>
                var updateUrl = '{$updateUrl}';
                var formKey = '{$formKey}';
                var productIds = {$productIdsString};
              </script>";
    
        return parent::_toHtml();
    }
    
    

}
