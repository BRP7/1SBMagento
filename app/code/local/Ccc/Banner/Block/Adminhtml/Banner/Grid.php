<?php
class Ccc_Banner_Block_Adminhtml_Banner_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


    protected function _prepareCollection()
    {
        // Load your collection
        $collection = Mage::getModel('ccc_banner/banner')->getCollection();
        // if (!Mage::getSingleton('admin/session')->isAllowed('ccc_banner/rows/showall')) {

            // Modify the SQL query to apply the order by  
            $collection->setOrder('banner_id', 'DESC');
            // Modify the SQL query to apply the limit  
            $collection->getSelect()->limit(4);
        // }
        // Set the collection to the grid
        // $this->setCollection($collection);
        // $this->getCollection()->load();
        return parent::_prepareCollection();
    }


    public function checkColumn($column)
    {
        return Mage::getSingleton('admin/session')->isAllowed('ccc_banner/columns/'.$column);
    }
    protected function _prepareColumns()
    {
        $columns=array(
            'banner_id'=>array(
                'header' => Mage::helper('banner')->__('Banner Id'),
                'align' => 'right',
                'width' => '50px',
                'index' => 'banner_id',
                'is_allowed' => $this->checkColumn('id'), // ACL check
            ),
            'banner_name'=>array(
                'header' => Mage::helper('banner')->__('Banner Name'),
                'align' => 'left',
                'index' => 'banner_name',
                'is_allowed' => $this->checkColumn('name'), // ACL check
            ),
            'banner_image'=> array(
                'header' => Mage::helper('banner')->__('Banner Image'),
                'align' => 'center',
                'index' => 'banner_image',
                'renderer' => 'Ccc_Banner_Block_Adminhtml_Banner_Grid_Renderer_Image', // Use custom renderer for image column
                'is_allowed' => $this->checkColumn('image'), // ACL check

            ),
            'status'=>array(
                'header' => Mage::helper('banner')->__('Status'),
                'align' => 'left',
                'index' => 'status',
                'is_allowed' => $this->checkColumn('status'), // ACL check

            ),
            'show_on'=>    array(
                'header' => Mage::helper('banner')->__('Show On'),
                'align' => 'left',
                'index' => 'show_on',
                'is_allowed' => $this->checkColumn('showon'), // ACL check

            ),
        );   
        
        // Loop through each column
        foreach ($columns as $columnKey => $columnConfig) {
            // Add column
            $this->addColumn($columnKey, $columnConfig);

            // Remove column if ACL check fails
            if (!$this->getColumn($columnKey)->getIsAllowed()) {
                $this->removeColumn($columnKey);
            }
        }


        // Add more columns as needed

        return parent::_prepareColumns();
    }
    public function getRowUrl($row)
    {
        if (Mage::getSingleton('admin/session')->isAllowed('ccc_banner/edit')) {
            return $this->getUrl('*/*/edit', array('banner_id' => $row->getId()));
        }
        return false;
    }

    // MAss Actions 
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('banner_id');
        $this->getMassactionBlock()->setFormFieldName('banner_id'); // Change to 'banner_id'

        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label' => Mage::helper('banner')->__('Delete'),
                'url' => $this->getUrl('*/*/massDelete'),
                'confirm' => Mage::helper('banner')->__('Are you sure you want to delete selected banners?')
            )
        );

        $statuses = Mage::getSingleton('ccc_banner/status')->getOptionArray();

        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem(
            'status',
            array(
                'label' => Mage::helper('banner')->__('Change status'),
                'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
                'additional' => array(
                    'visibility' => array(
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('banner')->__('Status'),
                        'values' => $statuses
                    )
                )
            )
        );

        Mage::dispatchEvent('banner_adminhtml_banner_grid_prepare_massaction', array('block' => $this));
        return $this;
    }




}
