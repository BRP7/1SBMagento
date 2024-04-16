<?php

// class Ccc_VendorInventory_Model_Status extends Mage_Core_Model_Abstract
// {
//     const STATUS_ENABLED = 1;
//     const STATUS_DISABLED = 0;

//     /**
//      * Retrieve option array
//      *
//      * @return array
//      */
//     static public function getOptionArray()
//     {
//         return array(
//             self::STATUS_ENABLED => Mage::helper('vendorinventory')->__('Enabled'),
//             self::STATUS_DISABLED => Mage::helper('vendorinventory')->__('Disabled')
//         );
//     }

//     /**
//      * Retrieve option array with empty value
//      *
//      * @return array
//      */
//     static public function getAllOption()
//     {
//         $options = self::getOptionArray();
//         array_unshift($options, array('value' => '', 'label' => ''));
//         return $options;
//     }

//     /**
//      * Retrieve option array with empty value
//      *
//      * @return array
//      */
//     static public function getAllOptions()
//     {
//         $res = array(
//             array(
//                 'value' => '',
//                 'label' => Mage::helper('vendorinventory')->__('-- Please Select --')
//             )
//         );
//         foreach (self::getOptionArray() as $index => $value) {
//             $res[] = array(
//                 'value' => $index,
//                 'label' => $value
//             );
//         }
//         return $res;
//     }

//     /**
//      * Retrieve option text by option value
//      *
//      * @param string $optionId
//      * @return string
//      */
//     static public function getOptionText($optionId)
//     {
//         $options = self::getOptionArray();
//         return isset($options[$optionId]) ? $options[$optionId] : null;
//     }
// }



class Ccc_VendorInventory_Model_Status extends Mage_Core_Model_Abstract
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * Retrieve option array
     *
     * @return array
     */
    static public function getOptionArray()
    {
        // Debug statement to check if the method is being called
        Mage::log('getOptionArray() method called', null, 'vendorinventory.log');

        return array(
            self::STATUS_ENABLED => Mage::helper('vendorinventory')->__('Enabled'),
            self::STATUS_DISABLED => Mage::helper('vendorinventory')->__('Disabled')
        );
    }

    /**
     * Retrieve option array with empty value
     *
     * @return array
     */
    static public function getAllOption()
    {
        $options = self::getOptionArray();
        array_unshift($options, array('value' => '', 'label' => ''));
        return $options;
    }

    /**
     * Retrieve option array with empty value
     *
     * @return array
     */
    static public function getAllOptions()
    {
        $res = array(
            array(
                'value' => '',
                'label' => Mage::helper('vendorinventory')->__('-- Please Select --')
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

    /**
     * Retrieve option text by option value
     *
     * @param string $optionId
     * @return string
     */
    static public function getOptionText($optionId)
    {
        $options = self::getOptionArray();
        return isset($options[$optionId]) ? $options[$optionId] : null;
    }
}
