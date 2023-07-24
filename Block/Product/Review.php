<?php

namespace Perspective\Review\Block\Product;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ProductFactory;
use Perspective\Review\Model\ReviewFactory;

class Review extends Template
{
    protected $productFactory;
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

    public function getProduct()
    {
        $productId = $this->getRequest()->getParam('id');
        return $this->productFactory->create()->load($productId);
    }

    public function getReviews(): AbstractCollection
    {
        $productId = $this->getRequest()->getParam('id');
        return $this->reviewFactory->create()->getCollection()
            ->addFieldToFilter('product_id', $productId)
            ->setOrder('created_at', 'DESC');

    }
}
