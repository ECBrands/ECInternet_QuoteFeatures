<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\QuoteFeatures\Plugin\Magento\Quote\Model;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Type\AbstractType;
use Magento\Quote\Model\Quote;
use ECInternet\QuoteFeatures\Logger\Logger;

class QuotePlugin
{
    /**
     * @var \ECInternet\QuoteFeatures\Logger\Logger
     */
    private $logger;

    /**
     * @param \ECInternet\QuoteFeatures\Logger\Logger $logger
     */
    public function __construct(
        Logger $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * Log addProduct() parameters
     *
     * @param Quote                                    $subject
     * @param \Magento\Quote\Model\Quote\Item|string   $result
     * @param Product|mixed                            $product
     * @param float|\Magento\Framework\DataObject|null $request
     * @param string|null                              $processMode
     *
     * @return \Magento\Quote\Model\Quote\Item|string
     */
    public function afterAddProduct(
        Quote $subject,
        $result,
        Product $product,
        $request = null,
        $processMode = AbstractType::PROCESS_MODE_FULL
    ) {
        $this->log('afterAddProduct()', [
            'quoteId'     => $subject->getId(),
            'result'      => $result,
            'productId'   => $product->getId(),
            'productSku'  => $product->getSku(),
            'request'     => $request,
            'processMode' => $processMode
        ]);

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
        $this->logger->info('Plugin/Magento/Quote/Model/QuotePlugin - ' . $message, $extra);
    }
}
