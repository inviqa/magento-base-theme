<?php
/**
 * Set up the grid for carousel slides
 *
 * @uses Mage
 * @category Carousel
 * @package  MX_Carousel
 *
 * @author Adam Smith <adam@sessiondigital.com>
 */
class MX_Carousel_Block_Adminhtml_Carousel_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Initialise the grid
     */
    public function _construct()
    {
        $this->setId('slides_grid');
        $this->setDefaultSort('sort_order')
             ->setDefaultDir('ASC');

        parent::_construct();
    }

    /**
     * Prepare the grid collection object for store view filtering
     *
     * @return $this
     */
    protected function _prepareCollection()
    {
        $this->setCollection(
            Mage::getModel('mx_carousel/carousel_slide')->getCollection()
        );
        return parent::_prepareCollection();
    }

    /**
     * Add the required columns to the grid
     *
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->_getGridHelper()
             ->addSimpleColumn($this, 'title', 'Title')
             ->addSimpleColumn($this, 'sort_order', 'Position')
             ->addSimpleColumn($this, 'created_time', 'Created Date', 'datetime')
             ->addSimpleColumn($this, 'update_time', 'Last Updated', 'datetime')
             ->addOptionsColumn($this, $this->_getActions());

        return parent::_prepareColumns();
    }

    /**
     * Get the row click url
     *
     * @param $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('slide_id' => $row->getId()));
    }

    /**
     * @return MX_Adminhtml_Helper_Grid
     */
    protected function _getGridHelper()
    {
        return Mage::helper('mx_adminhtml/grid');
    }

    /**
     * Get the actions to be displayed in the options column
     * @return array
     */
    protected function _getActions()
    {
        return array($this->_getGridHelper()->getEditAction('slide_id'));
    }
}
