<?php

class MX_Adminhtml_Helper_Image
{
    /** @var Zend_File_Transfer_Adapter_Http */
    protected $_filesAdapter;

    /**
     * @param Zend_File_Transfer_Adapter_Http $filesAdapter
     */
    public function __construct($filesAdapter = null)
    {
        if (is_null($filesAdapter)) {
            $filesAdapter = new Zend_File_Transfer_Adapter_Http();
        }
        $this->_filesAdapter = $filesAdapter;
    }

    /**
     * Save the image uploaded to the slide
     *
     * @param $folder
     * @param $fieldName
     *
     * @return string
     * @throws Exception
     */
    public function saveImage($folder, $fieldName)
    {
        $basePath = Mage::getBaseDir('media') . '/' . $folder . '/';

        $uploader = new Varien_File_Uploader($fieldName);
        $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'))
            ->setAllowRenameFiles(true)
            ->setAllowCreateFolders(true)
            ->setFilesDispersion(true);

        $fileLocation = $uploader->save($basePath, $this->getImageFilename($fieldName));
        return $folder . $fileLocation['file'];
    }


    /**
     * Deletes image from media folder
     *
     * @param $fileName
     * @return bool
     */
    public function deleteImage($fileName)
    {
        $filePath = Mage::getBaseDir('media') . '/' . $fileName;
        return unlink($filePath);
    }

    /**
     * Get the filename of the uploaded image
     *
     * @return string|false
     */
    public function getImageFilename($fieldName)
    {
        if ($this->_filesAdapter->isUploaded($fieldName)) {
            return $this->_filesAdapter->getFilename($fieldName);
        }

        return false;
    }
}
