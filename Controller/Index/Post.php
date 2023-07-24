<?php

namespace Perspective\Review\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Perspective\Review\Model\ReviewFactory;

class Post extends Action
{
    /**
     * @var ReviewFactory
     */

    protected $reviewFactory;

    public function __construct(
        Context       $context,
        ReviewFactory $reviewFactory
    )
    {
        parent::__construct($context);
        $this->reviewFactory = $reviewFactory;
    }

    public function execute(): void
    {
        $productId = $this->getRequest()->getParam('id');
        $reviewText = $this->getRequest()->getParam('detail');

        // TODO: validation

        $review = $this->reviewFactory->create();
        $review->setProductId($productId);
        $review->setDetail($reviewText);
        $review->setCreatedAt(date('Y-m-d H:i:s'));
        $review->save();

        $this->_redirect('catalog/product/view', ['id' => $productId]);
    }
}
