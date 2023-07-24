<?php

namespace Perspective\Review\Block\Product;

use Magento\Customer\Model\Customer;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ProductFactory;
use Perspective\Review\Model\ReviewFactory;
use Perspective\Review\Model\ConfigManager;
use Magento\Customer\Model\CustomerFactory;


class Review extends Template
{

    private ProductFactory $productFactory;
    private ReviewFactory $reviewFactory;
    private ConfigManager $configManager;
    private CustomerFactory $customerFactory;


    public function __construct(
        Template\Context $context,
        ProductFactory   $productFactory,
        ReviewFactory    $reviewFactory,
        ConfigManager    $configManager,
        CustomerFactory  $customerFactory,
        array            $data = []
    )
    {
        parent::__construct($context, $data);
        $this->productFactory = $productFactory;
        $this->reviewFactory = $reviewFactory;
        $this->configManager = $configManager;
        $this->customerFactory = $customerFactory;
    }

    public function isEnabled(): bool
    {
        return $this->configManager->isEnabled();
    }

    /**
     * Retrieve current product data
     *
     * @return AbstractModel
     */
    public function getProduct(): AbstractModel
    {
        $productId = $this->getRequest()->getParam('id');
        return $this->productFactory->create()->load($productId);
    }


    /**
     * Retrieve reviews collection
     *
     * @return AbstractCollection
     */
    public function getReviews(): AbstractCollection
    {
        $productId = $this->getRequest()->getParam('id');
        return $this->reviewFactory->create()->getCollection()
            ->addFieldToFilter('product_id', $productId)
            ->setOrder('created_at', 'DESC');

    }

    /**
     * Return review url
     *
     * @return string
     */
    public function getActionUrl(): string
    {
        return $this->getUrl('perspective/index/post');
    }

    /**
     * Return user info
     *
     * @param $userId
     * @return Customer
     */
    public function getUserInfo($userId): Customer
    {
        return $this->customerFactory->create()->load($userId);
    }
}
