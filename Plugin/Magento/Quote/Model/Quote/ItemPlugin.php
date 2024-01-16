<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\QuoteFeatures\Plugin\Magento\Quote\Model\Quote;

use Magento\Quote\Model\Quote\Item;
use ECInternet\QuoteFeatures\Helper\Data;
use ECInternet\QuoteFeatures\Logger\Logger;

/**
 * Plugin for Magento\Quote\Model\Quote\Item
 */
class ItemPlugin
{
    /**
     * @var \ECInternet\QuoteFeatures\Helper\Data
     */
    private $helper;

    /**
     * @var \ECInternet\QuoteFeatures\Logger\Logger
     */
    private $logger;

    /**
     * @param \ECInternet\QuoteFeatures\Helper\Data   $helper
     * @param \ECInternet\QuoteFeatures\Logger\Logger $logger
     */
    public function __construct(
        Data $helper,
        Logger $logger
    ) {
        $this->helper = $helper;
        $this->logger = $logger;
    }

    /**
     * @param Item $subject
     * @param Item $result
     *
     * @return Item
     */
    public function afterBeforeSave(
        Item $subject,
        Item $result
    ) {
        if ($this->helper->isModuleEnabled()) {
            $this->log('afterBeforeSave()', ['item' => $subject->getData()]);
        }

        return $result;
    }

    /**
     * Write to extension log
     *
     * @param string $message
     * @param array  $extra
     *
     * @return void
     */
    private function log(string $message, array $extra = [])
    {
        $this->logger->info('Plugin/Magento/Quote/Model/Quote/ItemPlugin - ' . $message, $extra);
    }
}
