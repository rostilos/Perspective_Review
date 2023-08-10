<?php

namespace Perspective\Review\Block\Product;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\View\Element\Template;
use Perspective\Review\Model\ResourceModel\Review\CollectionFactory as ReviewCollectionFactory;
use Perspective\Review\Model\ConfigManager;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Catalog\Helper\Data as CatalogHelper;
use Magento\Catalog\Model\Product;

class ReviewList extends Template
{
    /**
     * @var ReviewCollectionFactory
     */
    private ReviewCollectionFactory $collectionFactory;

    /**
     * @var ConfigManager
     */
    private ConfigManager $configManager;

    /**
     * @var CatalogHelper
     */
    private CatalogHelper $catalogHelper;

    /**
     * @var CustomerRepositoryInterface
     */
    private CustomerRepositoryInterface $customerRepository;

    /**
     * @param Template\Context $context
     * @param ReviewCollectionFactory $collectionFactory
     * @param ConfigManager $configManager
     * @param CustomerRepositoryInterface $customerRepository
     * @param CatalogHelper $catalogHelper
     * @param array $data
     */
    public function __construct(
        Template\Context            $context,
        ReviewCollectionFactory     $collectionFactory,
        ConfigManager               $configManager,
        CustomerRepositoryInterface $customerRepository,
        CatalogHelper               $catalogHelper,
        array                       $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
        $this->configManager = $configManager;
        $this->customerRepository = $customerRepository;
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
     * Retrieve reviews collection for current product
     *
     * @return AbstractCollection
     */
    public function getReviewsCollection(): AbstractCollection
    {
        $productId = $this->getProduct()->getId();
        return $this->collectionFactory->create()
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
     * @param int $customerId
     * @return CustomerInterface|null
     * @throws LocalizedException
     */
    public function getUserInfo(int $customerId): ?CustomerInterface
    {
        try {
            $customer = $this->customerRepository->getById($customerId);
        } catch (NoSuchEntityException $e) {
            return null;
        }
        return $customer;
    }
}
