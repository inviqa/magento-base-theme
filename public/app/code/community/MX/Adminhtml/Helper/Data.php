<?php
/**
 * Data helper for adminhtml
 *
 * @category Adminhtml
 * @package  MX_Adminhtml
 *
 * @author Adam Smith <adam@sessiondigital.com>
 */
class MX_Adminhtml_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * @param Mage_Core_Model_Abstract $model
     */
    public function addUpdatedTime(Mage_Core_Model_Abstract $model)
    {
        $dateTime = Mage::getSingleton('core/date')->gmtDate();
        if ($model->isObjectNew() && !$model->hasCreatedTime()) {
            $model->setCreatedTime($dateTime);
        }
        $model->setUpdateTime($dateTime);
    }
}
