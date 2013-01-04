<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

$sql = "ALTER TABLE {$this->getTable('catalog/product')}  ADD `sears_item_errors` tinytext NULL;";
$installer->run($sql);

$installer->endSetup();
?>
