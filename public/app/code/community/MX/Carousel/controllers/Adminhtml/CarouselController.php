<?php
/**
 * Controller for carousel admin
 *
 * @uses Mage
 * @category Carousel
 * @package  MX_Carousel
 *
 * @author Adam Smith <adam@sessiondigital.com>
 */
class MX_Carousel_Adminhtml_CarouselController
    extends MX_Adminhtml_CustomContent_Controller_Action
{
    protected $_activeMenu = 'cms/mx_carousel';
    protected $_itemName = 'Carousel Slide';
    protected $_itemIdFieldName = 'slide_id';

    /**
     * Set up page title for the current action
     * @return $this
     */
    protected function _setSectionTitle()
    {
        $this->_title($this->__('CMS'))
             ->_title($this->__('Carousel'));
    }

    /**
     * Get the block that will form the basis of the index page
     *
     * @return mixed
     */
    protected function _getIndexBlock()
    {
        return $this->getLayout()->createBlock('mx_carousel/adminhtml_carousel');
    }

    /**
     * Save the slide, first checking whether the existing image needs to be deleted
     * @param $id
     * @param array $data
     */
    protected function _saveItem($id, array $data)
    {
        if ($this->_imageShouldBeDeleted($data)) {
            $this->_deleteImage($id, $data);
        } else {
            $this->_saveImage($data);
        }
        $this->_getCarouselHelper()->saveSlide($id, $data);
    }

    /**
     * Delete the slide based on its id
     * @param $id
     */
    protected function _deleteItem($id)
    {
        $this->_getCarouselHelper()->deleteSlide($id);
    }

    /**
     * @return MX_Carousel_Block_Adminhtml_Carousel_Slide_Edit
     */
    protected function _getEditFormBlock()
    {
        return $this->getLayout()->createBlock('mx_carousel/adminhtml_carousel_slide_edit');
    }

    /**
     * @param integer|null $id
     * @param array $data
     * @return MX_Carousel_Model_Carousel_Slide
     */
    protected function _registerItem($id, array $data)
    {
        $slide = $this->_getCarouselHelper()->getSlide($id, $data);
        Mage::register('slide', $slide);
    }

    /**
     * @param $id
     * @return bool
     */
    protected function _itemExists($id)
    {
        return $this->_getCarouselHelper()->slideExists($id);
    }

    /**
     * @return MX_Carousel_Helper_Carousel
     */
    protected function _getCarouselHelper()
    {
        return Mage::helper('mx_carousel/carousel');
    }

    /**
     * Check to see if the image should be deleted
     *
     * @param array $data
     * @return bool
     */
    protected function _imageShouldBeDeleted(array $data)
    {
        return array_key_exists('delete', $data['image']);
    }

    /**
     * Save image and set the correct filename in the data array
     * If the image is replacing an old image, also delete that image
     *
     * @param array $data
     */
    protected function _saveImage(array &$data)
    {
        $imageFilename = $this->_getImageFilename();
        if (!empty($imageFilename)) {
            $helper = $this->_getCarouselHelper();
            $data['image'] = $helper->saveSlideImage();

            $helper->deleteSlideImage($data['slide_id']);
        } else {
            unset($data['image']);
        }
    }

    /**
     * Delete the image and remove it from the data array
     *
     * @param $id
     * @param array $data
     */
    protected function _deleteImage($id, array &$data)
    {
        $this->_getCarouselHelper()->deleteSlideImage($id);
        $data['image'] = '';
    }

    /**
     * Get the filename of the uploaded image
     *
     * @return string|false
     */
    protected function _getImageFilename()
    {
        return Mage::helper('mx_adminhtml/image')->getImageFilename('image');
    }
}
