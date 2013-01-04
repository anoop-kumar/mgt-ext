<?php

class Esoft_Logger_Block_Adminhtml_Logger_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('loggerGrid');
      $this->setDefaultSort('logger_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);      
  }
   
  //New Version
  protected function _prepareCollection()
{    
    $collection = Mage::getModel('logger/logger')->getCollection();   
    $collection->addCatUserNameToSelect();
    $this->setCollection($collection);
    return parent::_prepareCollection();
} 


  protected function _prepareColumns()
  {
      
      $this->addColumn('logger_id', array(
          'header'    => Mage::helper('logger')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'logger_id',
      ));

      $this->addColumn('category', array(
          'header'    => Mage::helper('logger')->__('Category'),
          'align'     =>'left',
          'index'     => 'category',
          //'format'     => '$category',          
      ));

      $this->addColumn('fullname', array(
          'header'    => Mage::helper('logger')->__('User'),
          'align'     =>'left',
          'index'     => 'fullname',
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('logger')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('logger')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('logger')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('logger')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('logger_id');
        $this->getMassactionBlock()->setFormFieldName('logger');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('logger')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('logger')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('logger/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('logger')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('logger')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}