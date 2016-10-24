<?php
/**
 * @category    Fishpig
 * @package     Fishpig_iBanners
 * @license     http://fishpig.co.uk/license.txt
 * @author      Ben Tideswell <help@fishpig.co.uk>
 */

$this->startSetup();

$this->getConnection()->addColumn(
    $this->getTable('ibanners_banner'),
    'category',
    " INT NULL AFTER `url`"
);

$this->getConnection()->addColumn(
    $this->getTable('ibanners_banner'),
    'subtitle',
    " VARCHAR(255) NULL AFTER `title`"
);

$this->getConnection()->addColumn(
    $this->getTable('ibanners_banner'),
    'text',
    " VARCHAR(512) NULL AFTER `is_enabled`"
);

$this->getConnection()->addColumn(
    $this->getTable('ibanners_banner'),
    'button_text',
    " VARCHAR(255) NULL AFTER `text`"
);

$this->getConnection()->dropColumn(
    $this->getTable('ibanners_banner'),
    'alt_text'
);

$this->getConnection()->dropColumn(
    $this->getTable('ibanners_banner'),
    'html'
);

$this->getConnection()->dropColumn(
    $this->getTable('ibanners_banner'),
    'url_target'
);

$this->endSetup();
