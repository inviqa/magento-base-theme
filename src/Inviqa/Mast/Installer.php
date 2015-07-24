<?php

namespace Inviqa\Mast;

use Composer\Installer\PackageEvent;
use Composer\Script\Event;

class Installer
{
    public static $ignoredFiles= [".ds_store", ".git"];

    public static function postPackageInstall(Event $event)
    {
        $currentDir = getcwd();
        $composer = $event->getComposer();
        $extra = $composer->getPackage()->getExtra();
        $vendorDir = $composer->getConfig()->get('vendor-dir');
        if (!empty($extra) && array_key_exists('path-mappings', $extra)) {
            foreach ($extra['path-mappings'] as $path => $mapItem) {
                $package = $mapItem['package'];
                $file = $mapItem['file'];
                $destination = $currentDir . DIRECTORY_SEPARATOR . $path;
                $fileToTransfer = $vendorDir . DIRECTORY_SEPARATOR . $package . DIRECTORY_SEPARATOR . $file;

                self::copy($fileToTransfer, $destination);
            }
        }
    }

    private static function copy($source, $destination)
    {
        if (!is_dir($source)) {
            return false;
        }

        if (!is_dir($destination)) {
            if (!mkdir($destination, 0777, true)) {
                echo "Could not create destination path '{$destination}'" . PHP_EOL;
                return false;
            }
        }

        $directoryIterator = new \DirectoryIterator($source);
        foreach ($directoryIterator as $file) {
            if (self::isFileIgnored($file->getFilename())) {
                continue;
            }

            if ($file->isFile()) {
                rename($file->getRealPath(), "$destination/" . $file->getFilename());
            } else if (!$file->isDot() && $file->isDir()) {
                self::copy($file->getRealPath(), "$destination/$file");
            }
        }
    }

    private static function isFileIgnored($file)
    {
        return in_array($file, self::$ignoredFiles);
    }
}
