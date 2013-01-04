<?php

class Esoft_Logger_Block_Adminhtml_Logger_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
     
      $config_category = Mage::helper('logger')->getCategories();
      $storeId = Mage::helper('logger')->getStore(); 
      $root_cat = Mage::app()->getStore($storeId)->getRootCategoryId();
      if(strstr($config_category,',')){
          $root_categories = explode(',',$config_category);
      }else{
         $root_categories = array($config_category); 
      }
      $category_option = array();
      //print_r($root_categories);
      foreach($root_categories as $category){
          
          if($category != $root_cat)              continue;
          
          $_category = Mage::getModel('catalog/category')->load($category);
          $_subcategories = $_category->getChildrenCategories();
          if (count($_subcategories) > 0){
              foreach($_subcategories as $_subcategory){
                 $category_option[] = ( array(
                'label' => (string) $_subcategory->getName(),
                'value' => $_subcategory->getId()
                    ));
              }
          }
      }
      
      //echo "<pre>"; print_r($category_option); die;
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('logger_form', array('legend'=>Mage::helper('logger')->__('Item information')));
     
      $fieldset->addField('category_id', 'select', array(
          'label'     => Mage::helper('logger')->__('Category'),
          'class'     => 'required-entry',
          'required'  => true,
          'values'    => $category_option,
          'name'      => 'category_id',
      ));
      
      $users = Mage::getModel("admin/user")->getCollection();
      foreach ($users as $user) {
            $users_option[] = ( array(
                'label' => ((string) $user->getFirstname())." ".((string) $user->getLastname())." (".((string) $user->getEmail()).")",
                'value' => $user->getId()
                    ));
        }
      $fieldset->addField('user_id', 'select', array(
          'label'     => Mage::helper('logger')->__('User'),
          'required'  => false,
          'name'      => 'user_id',
          'values'    => $users_option,  
	  ));

     
      if ( Mage::getSingleton('adminhtml/session')->getLoggerData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getLoggerData());
          Mage::getSingleton('adminhtml/session')->setLoggerData(null);
      } elseif ( Mage::registry('logger_data') ) {
          $form->setValues(Mage::registry('logger_data')->getData());
      }
      return parent::_prepareForm();
  }
}