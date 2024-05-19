<?php

class Practice_Jscustomgrid_Block_Adminhtml_Widget_Grid_Column_Renderer_Editable extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Input
{
    public function render(Varien_Object $row)
    {
        $value = $row->getData($this->getColumn()->getIndex());
        $html = '<input type="text" ';
        $html .= 'name="' . $this->getColumn()->getId() . '" ';
        $html .= 'value="' . htmlspecialchars($value) . '" ';
        $html .= 'class="input-text custom-attribute-editable" '; // Add a custom class for easier selection
        $html .= 'data-id="' . $row->getId() . '" ';
        $html .= '/>';
        return $html;
    }
}
