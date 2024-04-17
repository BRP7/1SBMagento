<?php
class Ccc_VendorInventory_Block_Adminhtml_VendorInventory_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct($attributes=array())
    {
        parent::__construct($attributes);
        $this->setTemplate('vendorinventory/grid.phtml');
    }

    protected function _prepareCollection()
    {
        // Load your collection
        $collection = Mage::getModel('vendorinventory/vendorinventory')->getCollection();
        // print_r($collection->getData());
        // die();
        
        // if (!Mage::getSingleton('admin/session')->isAllowed('vendorinventory/rows/showall')) {
            // Modify the SQL query to apply the order by
            // $collection->setOrder('id', 'DESC');
            
            // Apply custom limit
            // $customLimit = 4; // Change this to your desired limit
            // $collection->getSelect()->limit($customLimit);
            // $this->setCollection($collection);
            // return parent::_prepareCollection();
        // }
        $this->setCollection($collection);

        // Set the collection to the grid
        return parent::_prepareCollection();
    }
    
    


    public function checkColumn($column)
    {
        return Mage::getSingleton('admin/session')->isAllowed('vendorinventory/columns/' . $column);
    }
    protected function _prepareColumns()
    {
        $columns = array(
            'id' => array(
                'header' => Mage::helper('vendorinventory')->__('vendorinventory Id'),
                'align' => 'right',
                'width' => '50px',
                'index' => 'id',
                'is_allowed' => $this->checkColumn('id'), // ACL check
            ),
            'vendorinventory_name' => array(
                'header' => Mage::helper('vendorinventory')->__('vendorinventory Name'),
                'align' => 'left',
                'index' => 'vendorinventory_name',
                'is_allowed' => $this->checkColumn('name'), // ACL check
            ),
            'vendorinventory_image' => array(
                'header' => Mage::helper('vendorinventory')->__('vendorinventory Image'),
                'align' => 'center',
                'index' => 'vendorinventory_image',
                // 'renderer' => 'Ccc_VendorInventory_Block_Adminhtml_vendorinventory_Grid_Renderer_Image', // Use custom renderer for image column
                'is_allowed' => $this->checkColumn('image'), // ACL check

            ),
            'status' => array(
                'header' => Mage::helper('vendorinventory')->__('Status'),
                'align' => 'left',
                'index' => 'status',
                'is_allowed' => $this->checkColumn('status'), // ACL check

            ),
            'show_on' => array(
                'header' => Mage::helper('vendorinventory')->__('Show On'),
                'align' => 'left',
                'index' => 'show_on',
                'is_allowed' => $this->checkColumn('showon'), // ACL check

            ),
        );

        // Loop through each column
        foreach ($columns as $columnKey => $columnConfig) {
            // Add column
            if ($columnConfig['is_allowed']==true) {
                $this->addColumn($columnKey, $columnConfig);
            }
        }


        // Add more columns as needed

        return parent::_prepareColumns();
    }
    public function getRowUrl($row)
    {
        if (Mage::getSingleton('admin/session')->isAllowed('vendorinventory/edit')) {
            return $this->getUrl('*/*/edit', array('id' => $row->getId()));
        }
        return false;
    }

    // MAss Actions 
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('id'); // Change to 'vendorinventory_id'

        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label' => Mage::helper('vendorinventory')->__('Delete'),
                'url' => $this->getUrl('*/*/massDelete'),
                'confirm' => Mage::helper('vendorinventory')->__('Are you sure you want to delete selected vendorinventorys?')
            )
        );

        $statuses = Mage::getSingleton('vendorinventory/status')->getOptionArray();

        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem(
            'status',
            array(
                'label' => Mage::helper('vendorinventory')->__('Change status'),
                'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
                'additional' => array(
                    'visibility' => array(
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('vendorinventory')->__('Status'),
                        'values' => $statuses
                    )
                )
            )
        );

        Mage::dispatchEvent('vendorinventory_adminhtml_vendorinventory_grid_prepare_massaction', array('block' => $this));
        return $this;
    }
   
}
