<?php

class Esoft_Logger_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Path to store config if front-end output is enabled
     *
     * @var string
     */
    const XML_PATH_SELECT_CATEGORY            = 'logger/view/select_category';

    /**
     * Path to store config where count of news posts per page is stored
     *
     * @var string
     */
    const XML_PATH_CHOOSE_STORE     = 'logger/view/choose_store';
    
    /**
     * Checks whether news can be displayed in the frontend
     *
     * @param integer|string|Mage_Core_Model_Store $store
     * @return boolean
     */
    public function getCategories($store = null)
    {        
        return Mage::getStoreConfig(self::XML_PATH_SELECT_CATEGORY, $store);
    }
        

    /**
     * Return the number of items per page
     *
     * @param integer|string|Mage_Core_Model_Store $store
     * @return int
     */
    public function getStore($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_CHOOSE_STORE, $store);
    }


}