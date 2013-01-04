<?php
class Esoft_Logger_Block_Adminhtml_Logger extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_logger';
    $this->_blockGroup = 'logger';
    $this->_headerText = Mage::helper('logger')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('logger')->__('Add Item');
    parent::__construct();
  }
}