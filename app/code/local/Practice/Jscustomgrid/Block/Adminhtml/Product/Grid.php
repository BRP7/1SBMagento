<?php

class Practice_Jscustomgrid_Block_Adminhtml_Product_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        // $this->setTemplate('jscustomgris/grid.phtml');
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
    
       
        return  $this->setCollection($collection);
    }
    

    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('practice_jscustomgrid')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'entity_id',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('practice_jscustomgrid')->__('Name'),
            'align'     =>'left',
            'index'     => 'name',
        ));

        $this->addColumn('brand', array(
            'header'    => Mage::helper('practice_jscustomgrid')->__('brand'),
            'align'     =>'left',
            'index'     => 'brand',
        ));
        
        $this->addColumn('instock_date', array(
            'header'    => Mage::helper('practice_jscustomgrid')->__('instock_date'),
            'align'     =>'left',
            'index'     => 'instock_date',
        ));

        $this->addColumn('custom_select_attribute', array(
            'header'    => Mage::helper('practice_jscustomgrid')->__('Custom Attribute'),
            'align'     => 'left',
            'index'     => 'custom_select_attribute',
            'editable'  => true,
            'renderer'  => 'Practice_Jscustomgrid_Block_Adminhtml_Widget_Grid_Column_Renderer_Editable',
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('product');

        return $this;
    }

    public function getRowUrl($row)
    {
        // Check if the admin user has permission to access the productDetail action
        // if (Mage::getSingleton('admin/session')->isAllowed('practice_customgrid/customgrid/productdetail')) {
            // Return JavaScript code instead of URL
            return 'javascript:void(0)';
        // }
        // return parent::getRowUrl($row);
    }
    
}
