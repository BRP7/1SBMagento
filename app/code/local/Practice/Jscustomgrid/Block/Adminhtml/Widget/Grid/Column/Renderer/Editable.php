<?php
class Practice_Jscustomgrid_Block_Adminhtml_Widget_Grid_Column_Renderer_Editable extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Input
{
    public function render(Varien_Object $row)
    {
        $attributeCode = $this->getColumn()->getIndex();
        $value = $row->getData($attributeCode);

        // Get attribute model and options
        $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attributeCode);
        $options = $attribute->getSource()->getAllOptions(false);
        $url = $this->getUrl('*/*/updateCustomAttribute');
        $formKey = Mage::getSingleton('core/session')->getFormKey();

        // Build HTML for select element
        $html = '<select onchange="updateCustomAttribute(' . $row->getData('entity_id') . ', this.value, \'' . $url . '\', \'' . $formKey . '\')" ';
        $html .= 'name="' . $this->getColumn()->getId() . '" ';
        $html .= 'class="select product custom-attribute-editable" ';
        $html .= 'data-id="' . $row->getId() . '">';
        
        foreach ($options as $option) {
            $selected = ($option['value'] == $value) ? ' selected="selected"' : '';
            $html .= '<option value="' . htmlspecialchars($option['value']) . '"' . $selected . '>';
            $html .= htmlspecialchars($option['label']);
            $html .= '</option>';
        }

        $html .= '</select>';
        return $html;
    }
}
