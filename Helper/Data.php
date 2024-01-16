<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\QuoteFeatures\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Helper
 */
class Data extends AbstractHelper
{
    const CONFIG_PATH_ENABLED = 'quote_features/general/enable';

    /**
     * Is extension enabled?
     *
     * @return bool
     */
    public function isModuleEnabled()
    {
        return $this->scopeConfig->isSetFlag(self::CONFIG_PATH_ENABLED);
    }
}
