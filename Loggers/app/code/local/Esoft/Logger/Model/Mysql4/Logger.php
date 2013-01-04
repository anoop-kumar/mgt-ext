<?php

class Esoft_Logger_Model_Mysql4_Logger extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the logger_id refers to the key field in your database table.
        $this->_init('logger/logger', 'logger_id');
    }  
    /*
     * Getting the category name
     */
    public function getCategoryName($catId){
        $category = $categories = Mage::getModel('catalog/category');
        $category->load($catId);
        if($category->getId()){
            return $category->getName();
        }
        return false;
    }
    
    /*
     * Getting the User name
     */
    public function getUserName($userId){
        $user =  Mage::getModel('admin/user');
        $user->load($userId);
        if($user->getId()){
            return $user->getFirstname()." ".$user->getLastname()." (".$user->getEmail().")";
        }
        return false;
    }
}