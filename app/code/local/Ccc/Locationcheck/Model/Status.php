<?php

class Ccc_Locationcheck_Model_Status extends Mage_Core_Model_Abstract
{
    const IS_ACTIVE_ENABLED = '1';
    const IS_ACTIVE_DISABLED = '0';


    static public function getOptionArray()
    {
        return array(
            self::IS_ACTIVE_ENABLED => Mage::helper('locationcheck')->__('Yes'),
            self::IS_ACTIVE_DISABLED => Mage::helper('locationcheck')->__('No')
        );
    }

    static public function getAllOption()
    {
        $options = self::getOptionArray();
        array_unshift($options, array('value' => '', 'label' => ''));
        return $options;
    }

  
    static public function getAllOptions()
    {
        $res = array(
            array(
                'value' => '',
                'label' => Mage::helper('locationcheck')->__('-- Please Select --')
            )
        );
        foreach (self::getOptionArray() as $index => $value) {
            $res[] = array(
                'value' => $index,
                'label' => $value
            );
        }
        return $res;
    }

    static public function getOptionText($optionId)
    {
        $options = self::getOptionArray();
        return isset($options[$optionId]) ? $options[$optionId] : null;
    }
}
