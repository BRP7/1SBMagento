<?php
class Ccc_Blockoverride_Model_Product extends Mage_Catalog_Model_Product
{
    /**
     * Retrieve Product Name
     *
     * @return string
     */
    public function getName()
    {
        $productName = parent::getName();
        $productName = $productName. " xyz";
        return $productName; 
    }

    protected function _load($id, $field = null)
    {
        parent::_load($id, $field);

        // Convert description to lowercase
        $this->setDescription(strtolower($this->getDescription()));

        return $this;
    }
}
