<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\QuoteFeatures\Plugin\Magento\Checkout\CustomerData;

use Magento\Checkout\CustomerData\DefaultItem;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Quote\Model\Quote\Item;
use ECInternet\QuoteFeatures\Logger\Logger;

/**
 * Plugin for Magento\Checkout\CustomerData\DefaultItem
 */
class DefaultItemPlugin
{
    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    private $currencyInterface;

    /**
     * @var \ECInternet\QuoteFeatures\Logger\Logger
     */
    private $logger;

    /**
     * DefaultItemPlugin constructor.
     *
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $currencyInterface
     * @param \ECInternet\QuoteFeatures\Logger\Logger           $logger
     */
    public function __construct(
        PriceCurrencyInterface $currencyInterface,
        Logger $logger
    ) {
        $this->currencyInterface = $currencyInterface;
        $this->logger            = $logger;
    }

    /**
     * Add additional price info to catalog_attributes
     *
     * @param \Magento\Checkout\CustomerData\DefaultItem $subject
     * @param array                                      $result
     * @param \Magento\Quote\Model\Quote\Item            $item
     *
     * @return array
     */
    public function afterGetItemData(
        /* @noinspection PhpUnusedParameterInspection */ DefaultItem $subject,
        $result,
        Item $item
    ) {
        $this->log('aroundGetItemData()');

        $discount    = 0;
        $amountSaved = 0;

        $priceInfo = $item->getProduct()->getPriceInfo();

        $currentPrice  = $priceInfo->getPrice('final_price')->getAmount()->getValue();
        $originalPrice = $priceInfo->getPrice('regular_price')->getAmount()->getValue();

        $this->log('aroundGetItemData()', [
            'product'       => $item->getProduct()->getData(),
            'final_price'   => $currentPrice,
            'regular_price' => $originalPrice,
            'item_price'    => $item->getPrice()
        ]);

        if ($currentPrice != $originalPrice) {
            $discount    = round((($originalPrice - $currentPrice) / $originalPrice) * 100);
            $amountSaved = $originalPrice - $currentPrice;
        }

        $attributes = [
            'regular_price_value' => $originalPrice,
            'regular_price'       => $this->currencyInterface->format($originalPrice, false, 2),
            'discount_percentage' => $discount,
            'saved_amount'        => $this->currencyInterface->format($amountSaved, false, 2)
        ];

        return array_merge($result, $attributes);
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
        $this->logger->info('Plugin/Magento/Checkout/CustomerData/DefaultItemPlugin - ' . $message, $extra);
    }
}
