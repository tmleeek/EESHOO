<?php

class Magestore_Membership_Block_Adminhtml_Group_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('groupGrid');
      $this->setDefaultSort('group_id');
      $this->setDefaultDir('DESC');
	  $this->setUseAjax(true);
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('membership/group')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('group_id', array(
          'header'    => Mage::helper('membership')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'group_id',
      ));

      $this->addColumn('group_name', array(
          'header'    => Mage::helper('membership')->__('Name'),
		  'width'     => '150px',
          'index'     => 'group_name',
      ));
	  
	  $this->addColumn('priority', array(
          'header'    => Mage::helper('membership')->__('Priority'),
		  'width'     => '150px',
          'index'     => 'priority',
      ));
	
	  $this->addColumn('group_product_price', array(
          'header'    => Mage::helper('membership')->__('Product Price'),
		  'width'     => '150px',
          'index'     => 'group_product_price',
		  'renderer'  => 'membership/adminhtml_group_renderer_price',
      ));
	  
	  
      $this->addColumn('description', array(
			'header'    => Mage::helper('membership')->__('Description'),
			'index'     => 'description',
      ));
	 

      $this->addColumn('group_status', array(
          'header'    => Mage::helper('membership')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'group_status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('membership')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('membership')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		//$this->addExportType('*/*/exportCsv', Mage::helper('membership')->__('CSV'));
		//$this->addExportType('*/*/exportXml', Mage::helper('membership')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('group_id');
        $this->getMassactionBlock()->setFormFieldName('group');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('membership')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('membership')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('membership/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('group_status', array(
             'label'=> Mage::helper('membership')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'group_status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('membership')->__('Status'),
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
	
	public function getGridUrl()
    {
        return $this->getUrl('*/*/grid');
    }

}