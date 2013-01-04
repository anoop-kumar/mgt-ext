<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Esoft_Logger_Model_Observer
{
    public function coreBlockAbstractPrepareLayoutAfter1(Varien_Event_Observer $observer)
    { 
        if (Mage::app()->getFrontController()->getAction()->getFullActionName() === 'adminhtml_dashboard_index')
        {
            $block = $observer->getBlock();
            if ($block->getNameInLayout() === 'dashboard')
            {
                $block->getChild('topSearches')->setUseAsDashboardHook(true);
            }
        }
    }

    public function coreBlockAbstractToHtmlAfter1(Varien_Event_Observer $observer)
    {
       
        if (Mage::app()->getFrontController()->getAction()->getFullActionName() === 'adminhtml_dashboard_index')
        {
            if ($observer->getBlock()->getUseAsDashboardHook())
            {
                $html = $observer->getTransport()->getHtml();
                $myBlock = $observer->getBlock()->getLayout()                       
                    ->createBlock('esoft_logger/block')
                    ->setTheValuesAndTemplateYouNeed('HA!');
                $html .= $myBlock->toHtml();
                $observer->getTransport()->setHtml($html);
            }
        }
    }
}
?>
