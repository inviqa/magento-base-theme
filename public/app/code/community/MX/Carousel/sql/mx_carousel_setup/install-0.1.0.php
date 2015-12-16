<?php
$installer = $this;

$installer->run(
    'CREATE TABLE IF NOT EXISTS `'.$installer->getTable('mx_carousel/carousel_slide').'` (
       `slide_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
       `title` VARCHAR(128) NOT NULL,
       `image` TEXT NOT NULL,
       `link_url` TEXT,
       `sort_order` INT(8) UNSIGNED NOT NULL,
       `created_time` DATETIME NOT NULL,
       `update_time` TIMESTAMP NOT NULL,
       PRIMARY KEY (`slide_id`)
    ) ENGINE=InnoDb DEFAULT CHARSET=utf8'
);

// End setup
$installer->endSetup();
