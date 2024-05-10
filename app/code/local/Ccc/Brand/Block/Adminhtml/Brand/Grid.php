<?php
class Ccc_Brand_Block_Adminhtml_Brand_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('brandGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    public function _prepareCollection()
    {
        // Load the attribute model
        $attribute = Mage::getModel('eav/entity_attribute')->load(216); // Assuming 216 is the ID of the brand attribute

        // Check if the attribute exists and is of the select type
        if ($attribute && $attribute->getFrontendInput() == 'select') {
            // Get the attribute options
            $options = $attribute->getSource()->getAllOptions(false);

            // Create a new collection
            $collection = new Varien_Data_Collection();

            // Add options to the collection
            foreach ($options as $option) {
                $row = new Varien_Object();
                $row->setData('option_id', $option['value']);
                $row->setData('option_name', $option['label']);
                $collection->addItem($row);
            }

            $this->setCollection($collection);
        } else {
            // Handle case when attribute is not found or is not a select type attribute
            Mage::getSingleton('adminhtml/session')->addError("Brand attribute not found or is not a select type attribute.");
        }

        return parent::_prepareCollection();
    }

    // public function _prepareColumns()
    // {
    //     // Add columns to the grid
    //     $this->addColumn('option_id', array(
    //         'header'    => Mage::helper('brand')->__('Option ID'),
    //         'index'     => 'option_id',
    //         'type'      => 'number'
    //     ));

    //     $this->addColumn('option_name', array(
    //         'header'    => Mage::helper('brand')->__('Option Name'),
    //         'index'     => 'option_name'
    //     ));

    //     return parent::_prepareColumns();
    // }


    protected function _prepareColumns()
    {
        $this->addColumn('option_id', array(
            'header'    => Mage::helper('brand')->__('Option ID'),
            'index'     => 'option_id',
            'type'      => 'number'
        ));
    
        $this->addColumn('option_name', array(
            'header'    => Mage::helper('brand')->__('Option Name'),
            'index'     => 'option_name'
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
                        'base' => '*/*/edit' // Custom URL for editing the option
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
