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

class ReviewList extends Template
{

    /**
     * @var ProductFactory
     */
    private ProductFactory $productFactory;

    /**
     * @var ReviewFactory
     */
    private ReviewFactory $reviewFactory;

    /**
     * @var ConfigManager
     */
    private ConfigManager $configManager;

    /**
     * @var CustomerFactory
     */
    private CustomerFactory $customerFactory;

    /**
     * @param Template\Context $context
     * @param ProductFactory $productFactory
     * @param ReviewFactory $reviewFactory
     * @param ConfigManager $configManager
     * @param CustomerFactory $customerFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ProductFactory   $productFactory,
        ReviewFactory    $reviewFactory,
        ConfigManager    $configManager,
        CustomerFactory  $customerFactory,
        array            $data = []
    ) {
        parent::__construct($context, $data);
        $this->productFactory = $productFactory;
        $this->reviewFactory = $reviewFactory;
        $this->configManager = $configManager;
        $this->customerFactory = $customerFactory;
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
     * @return AbstractModel
     */
    public function getProduct(): AbstractModel
    {
        $productId = $this->getRequest()->getParam('id');
        return $this->productFactory->create()->load($productId);
    }


    /**
     * Retrieve reviews collection for current product
     *
     * @return AbstractCollection
     */
    public function getReviewsCollection(): AbstractCollection
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
     *  Retrieve User Info
     *
     * @param int $userId
     * @return Customer
     */
    public function getUserInfo(int $userId): Customer
    {
        return $this->customerFactory->create()->load($userId);
    }
}
