<?php

namespace Perspective\Review\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Perspective\Review\Model\ReviewFactory;
use Magento\Customer\Model\Session;

class Post extends Action
{
    /**
     * @var ReviewFactory
     */

    protected $reviewFactory;

    public function __construct(
        Context       $context,
        ReviewFactory $reviewFactory,
        Session $customerSession
    )
    {
        parent::__construct($context);
        $this->reviewFactory = $reviewFactory;
        $this->customerSession = $customerSession;
    }

    public function execute(): void
    {
        $productId = $this->getRequest()->getParam('id');
        $reviewText = $this->getRequest()->getParam('detail');
        $userId = $this->customerSession->getCustomerId();

        // TODO: validation

        $review = $this->reviewFactory->create();
        $review->setProductId($productId);
        $review->setDetail($reviewText);
        $review->setCreatedAt(date('Y-m-d H:i:s'));
        $review->setUserId($userId);
        $review->save();

        $this->_redirect('catalog/product/view', ['id' => $productId]);
    }
}
