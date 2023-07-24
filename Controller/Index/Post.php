<?php

namespace Perspective\Review\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Perspective\Review\Model\ConfigManager;
use Perspective\Review\Model\ReviewFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Customer\Model\Session;
use Magento\Framework\Controller\Result\Redirect;

class Post extends Action
{
    public function __construct(
        Context                    $context,
        ReviewFactory              $reviewFactory,
        Session                    $customerSession,
        ProductRepositoryInterface $productRepository,
        Validator                  $formKeyValidator,
        ConfigManager              $configManager
    )
    {
        parent::__construct($context);
        $this->reviewFactory = $reviewFactory;
        $this->customerSession = $customerSession;
        $this->productRepository = $productRepository;
        $this->formKeyValidator = $formKeyValidator;
        $this->configManager = $configManager;
    }

    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());

        if (!$this->formKeyValidator->validate($this->getRequest())) {
            return $resultRedirect;
        }

        $productId = $this->getRequest()->getParam('id');
        $customerId = $this->customerSession->getCustomerId();
        $data = $this->getRequest()->getPostValue();

        if (!$this->configManager->isGuestReviewsAllowed() && !$customerId) {
            $this->messageManager->addErrorMessage(__('You must be logged in to post a review.'));
            return $resultRedirect;
        }

        if (($product = $this->productRepository->getById($productId)) && !empty($data)) {

            $review = $this->reviewFactory->create()->setData($data);

            try {
                $review->setProductId($product->getId())
                    ->setCreatedAt(date('Y-m-d H:i:s'))
                    ->setUserId($this->customerSession->getCustomerId())
                    ->save();

                $this->messageManager->addSuccessMessage(__('You have successfully posted a review.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('We can\'t post your review right now.'));
            }
        } else {
            $this->messageManager->addErrorMessage(__('We can\'t post your review right now.'));
        }

        return $resultRedirect;
    }
}
