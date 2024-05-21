<?php

class Practice_Rowedit_Block_Adminhtml_Rowedit_Grid_Renderer_EditButton extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    protected static $rowCounter = 0;
    public function render(Varien_Object $row)
    {
        Mage::log('EditButton Renderer Called', null, 'rowgrid.log'); 
        // Render competitor information
        $rowId = $row->getData('entity_id');
        $statusOptions = array(
            '1' => 'Enabled',
            '0' => 'Disabled'
        );
        $status = json_encode($statusOptions);
        $editUrl = $this->getUrl('*/*/save', array('entity_id' => $rowId));
        $output = "<a href='#' class='edit-row' data-url='{$editUrl}' data-entity-id='{$rowId}' data-status='{$status}'>Edit</a>";
        return $output;
    }
}
