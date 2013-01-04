<?php

class Esoft_Logger_Model_Mysql4_Logger_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('logger/logger');        
    }  
    
    public function addCategoriesData(){
        
    }
    /*
     * Get Category association
     */    
    public function addCatUserNameToSelect() {
        //$store_id = Mage::app()->getStore()->getStoreId();
        $store_id = Mage::helper('logger')->getStore(); 
               
       // die($store_id);
        $cat_var = Mage::getSingleton('core/resource')->getTableName('catalog_category_entity_varchar');
        $this->getSelect()               
            ->joinLeft(array('category' => $this->getTable('catalog/category')), 'main_table.category_id=category.entity_id')           
            ->joinLeft(array('cat' => $cat_var), '(category.entity_id = cat.entity_id AND cat.store_id = '.$store_id.' AND cat.attribute_id = 41)')
           // ->where('ce2.attribute_id='.$lastnameAttr->getAttributeId())    // Attribute code for lastname.
           ->joinLeft(array('user' => $this->getTable('admin/user')), 'main_table.user_id = user.user_id')     
            ->columns(new Zend_Db_Expr("cat.value as category , CONCAT(user.`firstname` ,' ', user.`lastname`,' (', user.`email`,')' ) as fullname"));
        //echo  $this->getSelect(); die;
        return $this;
    }
    
    /*
    * @ Author: Anoop Srivastava
    * @ Created At: 4-Jan-2013
    * @ This function is used to fetch only selected field's value. 
    */
    public function addAttributeToFilter($fieldToEq, $id) {
           $this->addFieldToFilter($fieldToEq,$id);
           return $this;		
    }

    /*
     * Get All Admin User
     */
    public function getLoggerUsers(){
        $users = Mage::getModel("admin/user")->getCollection();
        return $users;
    }
}