<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Esoft_Logger_Model_Dashboard_Observer {

    public function coreBlockAbstractPrepareLayoutAfter(Varien_Event_Observer $observer) {
        if (Mage::app()->getFrontController()->getAction()->getFullActionName() === 'adminhtml_dashboard_index') {
            $block = $observer->getBlock();
            if ($block->getNameInLayout() === 'dashboard') {
                $block->getChild('topSearches')->setUseAsDashboardHook(true);
            }
        }
    }

    public function coreBlockAbstractToHtmlAfter(Varien_Event_Observer $observer) {
        if (Mage::app()->getFrontController()->getAction()->getFullActionName() === 'adminhtml_dashboard_index') {
            if ($observer->getBlock()->getUseAsDashboardHook()) {
                $html = $observer->getTransport()->getHtml();
                $html .= $this->getLoggerOfUser();
                $observer->getTransport()->setHtml($html);
            }
        }
    }

    private function getLoggerOfUser() {
        $html = null;
        if (Mage::getSingleton('admin/session')->isLoggedIn()) {
            $html = '</fieldset></div>';
            $html .= '<div class="entry-edit">';
            $html .= '<div class="entry-edit-head"><h4>';
            $admin = Mage::getSingleton('admin/session')->getUser();
            $error_message = $this->getLoggedData($admin->getId());
            $html .= 'SEARS Logged Messages';
            $html .= '</h4></div>';
            $html .= '<fieldset class="np">';
            $html .= $error_message;
        } else {

            $html = 'Not Logged in';
        }
        return $html;
    }

    private function getLoggedData($user_id) {
        $html = '<p align="center" style="padding:20px;"><span class="empty-text a-center">No records found.</span></p>';
        $logger_model = Mage::getModel('logger/logger')->getCollection();
        $logger_model->addFieldToFilter('user_id', $user_id);
        //echo $logger_model->getSelect();
        $records = (int) $logger_model->count();
        $error_messages = '';
        $categories_assigned = array();
        if($records){
            foreach($logger_model as $logger){
                $categoryid = $logger->getCategoryId();
                $categories_assigned = $this->getChildCategories($categoryid, $categories_assigned);
            }
        }else{
            return $html;
        }
        
        $i =0;
        $collection = Mage::getModel('catalog/product')->getCollection();
        $sql = $collection->getSelect()->where("market_status = '0'");
        $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
        $product_cat_entity = $connection->fetchAll($sql);
        foreach ($product_cat_entity as $product_entity) {
            $sku = $product_entity['sku'];
            $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);
            $categoryIds = $product->getCategoryIds();           
            foreach ($categoryIds as $categoryId) {
                if (in_array($categoryId, $categories_assigned)) {                        
                    $error_messages .='<div class="notification-global">'. $product_entity['sears_item_errors'] . '</div>';
                    break;
                }
            }
        }        
        if (!empty($error_messages)) {
            $html = '<p align="center" style="padding:5px;">';
            $html .= $error_messages;
            $html .= '</p>';
        }
        return $html;
    }
    
    /*
     * Get all the child categories
     */
    private function getChildCategories($categoryid, $cat_assigned){
        $category_model = Mage::getModel('catalog/category'); //get category model 
        $_category = $category_model->load($categoryid); //$categoryid for which the child categories to be found        
        $all_child_categories = $category_model->getResource()->getAllChildren($_category); //array consisting of all child categories id
        if(sizeof($all_child_categories)){
            foreach ($all_child_categories as $catid){
                $cat_assigned[] = $catid;
            } 
        }else{
             $cat_assigned[] = $categoryid;
        }
        return $cat_assigned;
    }

}
