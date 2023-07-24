<?php

namespace Perspective\Review\Block\Product;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ProductFactory;
use Perspective\Review\Model\ReviewFactory;

class Review extends Template
{
    /**
     * @var ProductFactory;
     */
    protected $productFactory;

    /**
     * @var ReviewFactory;
     */
    protected $reviewFactory;

    public function __construct(
        Template\Context $context,
        ProductFactory   $productFactory,
        ReviewFactory    $reviewFactory,
        array            $data = []
    )
    {
        parent::__construct($context, $data);
        $this->productFactory = $productFactory;
        $this->reviewFactory = $reviewFactory;
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
}
