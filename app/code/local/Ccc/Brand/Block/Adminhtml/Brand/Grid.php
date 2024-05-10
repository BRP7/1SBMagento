<?php
class Ccc_Brand_Block_Adminhtml_Brand_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('brandGrid');
        $this->setDefaultSort('option_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('eav/entity_attribute_option')->getCollection();
        $collection->addFieldToFilter('attribute_id', 216); // Assuming 216 is the ID of the brand attribute
        $collection->getSelect()->join(
            array('attribute' => 'eav_attribute'),
            'main_table.attribute_id = attribute.attribute_id',
            array('attribute_code')
        );
        $collection->getSelect()->where("attribute.attribute_code = 'brand'");
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('option_id', array(
            'header'    => Mage::helper('brand')->__('Option ID'),
            'index'     => 'option_id',
            'type'      => 'number'
        ));

        $this->addColumn('value', array(
            'header'    => Mage::helper('brand')->__('Option Name'),
            'index'     => 'value'
        ));

        // Add the action column
        $this->addColumn('action', array(
            'header'    => Mage::helper('brand')->__('Action'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getOptionId', // Method to retrieve the option id
            'actions'   => array(
                array(
                    'caption'   => Mage::helper('brand')->__('Edit'),
                    'url'       => array(
                        'base' => '*/*/edit'
                    ),
                    'field'     => 'option_id'
                )
            ),
            'filter'    => false,
            'sortable'  => false,
            'is_system' => true
        ));

        return parent::_prepareColumns();
    }

    protected function _getAttributeIdByCode($attributeCode)
    {
        $attribute = Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product', $attributeCode);
        return $attribute->getId();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}
