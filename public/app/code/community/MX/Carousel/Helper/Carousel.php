<?php
/**
 * Helper to save and load carousel slides
 *
 * @uses Mage
 * @category Carousel
 * @package  MX_Carousel
 *
 * @author Adam Smith <adam@sessiondigital.com>
 */
class MX_Carousel_Helper_Carousel
{
    /** @var MX_Carousel_Model_Carousel_Slide */
    protected $_slideModel;


    public function __construct(MX_Carousel_Model_Carousel_Slide $slideModel = null)
    {
        if (is_null($slideModel)) {
            $slideModel = Mage::getModel('mx_carousel/carousel_slide');
        }
        $this->_slideModel = $slideModel;
    }

    /**
     * @param $id
     * @return bool
     */
    public function slideExists($id)
    {
        return intval($this->_getSlideById($id)->getId()) > 0;
    }

    /**
     * @param $id
     * @param array $data
     * @return MX_Carousel_Model_Carousel_Slide
     */
    public function getSlide($id, array $data = array())
    {
        $slide = $this->_getSlideById($id);
        if (!empty($data)) {
            $slide->setData($data);
        }
        return $slide;
    }

    /**
     * @param $id
     * @param array $data
     */
    public function saveSlide($id, array $data)
    {
        $this->getSlide($id, $data)->save();
    }

    /**
     * Save the image uploaded to the slide
     *
     * @return string
     */
    public function saveSlideImage()
    {
        return Mage::helper('mx_adminhtml/image')->saveImage('carousel', 'image');
    }

    /**
     * @param $id
     */
    public function deleteSlide($id)
    {
        $this->deleteSlideImage($id);
        $this->getSlide($id)->delete();
    }

    /**
     * Delete the image file currently associated with the slide
     *
     * @param $id
     * @return bool
     */
    public function deleteSlideImage($id)
    {
        $imagePath = Mage::getBaseDir('media') . '/' . $this->getSlide($id)->getImage();
        return unlink($imagePath);
    }

    /**
     * @param $id
     * @return MX_Carousel_Model_Carousel_Slide
     */
    protected function _getSlideById($id)
    {
        return $this->_slideModel->load($id);
    }

}
