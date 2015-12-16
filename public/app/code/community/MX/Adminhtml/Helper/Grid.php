<?php
/**
 * Helper for setting up admin grids
 *
 * @category Adminhtml
 * @package  MX_Adminhtml
 *
 * @author Adam Smith <adam@sessiondigital.com>
 */
class MX_Adminhtml_Helper_Grid
{
    /**
     * @param Mage_Adminhtml_Block_Widget_Grid $grid
     * @param string $fieldName
     * @param string $heading
     * @param string $type
     * @return $this
     */
    public function addSimpleColumn(Mage_Adminhtml_Block_Widget_Grid $grid, $fieldName, $heading, $type = 'text')
    {
        $grid->addColumn(
            $fieldName,
            array('header' => $heading, 'index' => $fieldName, 'type' => $type)
        );
        return $this;
    }

    /**
     * @param Mage_Adminhtml_Block_Widget_Grid $grid
     * @param string $fieldName
     * @param string $heading
     * @return $this
     */
    public function addBooleanColumn(Mage_Adminhtml_Block_Widget_Grid $grid, $fieldName, $heading)
    {
        $grid->addColumn(
            $fieldName,
            array(
                'header' => $heading,
                'index' => $fieldName,
                'type' => 'options',
                'options'   => array('1' => 'Yes', '0' => 'No')
            )
        );
        return $this;
    }

    /**
     * @param Mage_Adminhtml_Block_Widget_Grid $grid
     * @param array $actions
     * @return $this
     */
    public function addOptionsColumn(Mage_Adminhtml_Block_Widget_Grid $grid, array $actions)
    {
        $grid->addColumn(
            'options',
            array(
                'header' => 'Options',
                'type' => 'action',
                'filter' => false,
                'sortable' => false,
                'getter' => 'getId',
                'actions' => $actions
            )
        );
        return $this;
    }

    /**
     * Get the options that build the standard edit action
     * @param string $idFieldName
     * @return array
     */
    public function getEditAction($idFieldName)
    {
        return array(
            'caption' => 'Edit',
            'url'     => array('base'=>'*/*/edit'),
            'field'   => $idFieldName
        );
    }

}
