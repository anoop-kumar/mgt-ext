<?php

$installer = $this;

/**
 * Creating table magentostudy_news
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('logger'))
    ->addColumn('logger_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'identity' => true,
        'nullable' => false,
        'primary'  => true,
    ), 'Entity id')
    ->addColumn('category_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'Category id')
    ->addColumn('user_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'User')    
    ->addColumn('published_at', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
        'nullable' => true,
        'default'  => null,
    ), 'Update Time')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable' => true,
        'default'  => null,
    ), 'Creation Time')
//    ->addIndex($installer->getIdxName(
//            $installer->getTable('magentostudy_news/news'),
//            array('published_at'),
//            Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX
//        ),
//        array('published_at'),
//        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX)
//    )
    ->setComment('Logger item');

$installer->startSetup();
$installer->run("
    DROP TABLE IF EXISTS {$this->getTable('logger/logger')};
");
$installer->getConnection()->createTable($table);

$installer->endSetup(); 