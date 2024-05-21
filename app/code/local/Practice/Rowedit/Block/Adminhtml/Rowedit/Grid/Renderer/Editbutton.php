<?php

class Practice_Rowedit_Block_Adminhtml_Rowedit_Grid_Renderer_EditButton extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    protected static $rowCounter = 0;
    public function render(Varien_Object $row)
    {
        // Render competitor information
        $rowId = $row->getData('entity_id');
        // $status = array(
        //     '1' => 'Enabled',
        //     '2' => 'Disabled'
        // );
        // $status = json_encode($status);
        $editUrl = $this->getUrl('*/*/save', array('entity_id' => $rowId));
        $output = "<a href='#' class='edit-row' data-url='{$editUrl}' data-entity-id='{$rowId}'>Edit</a>";
        // $output = "<a href='#' class='edit-jalebi' data-url='{$editUrl}' data-jalebi-id='{$rowId}' data-status='{$status}'>Edit</a>";
        return $output;
    }
}
