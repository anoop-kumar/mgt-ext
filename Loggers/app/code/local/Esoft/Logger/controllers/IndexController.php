<?php
class Esoft_Logger_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/logger?id=15 
    	 *  or
    	 * http://site.com/logger/id/15 	
    	 */
    	/* 
		$logger_id = $this->getRequest()->getParam('id');

  		if($logger_id != null && $logger_id != '')	{
			$logger = Mage::getModel('logger/logger')->load($logger_id)->getData();
		} else {
			$logger = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($logger == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$loggerTable = $resource->getTableName('logger');
			
			$select = $read->select()
			   ->from($loggerTable,array('logger_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$logger = $read->fetchRow($select);
		}
		Mage::register('logger', $logger);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}