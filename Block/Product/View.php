<?php

namespace Perspective\Review\Block\Product;

use Magento\Framework\View\Element\Template;
use Perspective\Review\Model\ConfigManager;
use Magento\Catalog\Helper\Data as CatalogHelper;
use Magento\Catalog\Model\Product;

class View extends Template
{

    /**
     * @var ConfigManager
     */
    private ConfigManager $configManager;

    /**
     * @var CatalogHelper
     */
    private CatalogHelper $catalogHelper;


    /**
     * @param Template\Context $context
     * @param ConfigManager $configManager
     * @param CatalogHelper $catalogHelper
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ConfigManager    $configManager,
        CatalogHelper    $catalogHelper,
        array            $data = []
    ) {
        parent::__construct($context, $data);
        $this->configManager = $configManager;
        $this->catalogHelper = $catalogHelper;
    }

    /**
     * Is Enabled flag
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->configManager->isEnabled();
    }

    /**
     * Retrieve current product data
     *
     * @return Product|null
     */
    public function getProduct(): Product|null
    {
        return $this->catalogHelper->getProduct();
    }


    /**
     * Return post review url
     *
     * @return string
     */
    public function getPostActionUrl(): string
    {
        return $this->getUrl('perspective_review/index/post');
    }

    /**
     * Get URL for ajax call
     *
     * @return string
     */
    public function getProductReviewUrl(): string
    {
        return $this->getUrl(
            'perspective_review/index/reviewList',
            [
                'id' => $this->getProduct()->getId(),
            ]
        );
    }
}
