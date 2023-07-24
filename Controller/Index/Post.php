<?php

namespace Perspective\Review\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
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
        Validator                  $formKeyValidator
    )
    {
        parent::__construct($context);
        $this->reviewFactory = $reviewFactory;
        $this->customerSession = $customerSession;
        $this->productRepository = $productRepository;
        $this->formKeyValidator = $formKeyValidator;
    }

    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        $productId = $this->getRequest()->getParam('id');

        if (!$this->formKeyValidator->validate($this->getRequest())) {
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }

        $data = $this->getRequest()->getPostValue();

        if (($product = $this->productRepository->getById($productId)) && !empty($data)) {

            $review = $this->reviewFactory->create()->setData($data);

            try {
                $review->setProductId($product->getId())
                    ->setCreatedAt(date('Y-m-d H:i:s'))
                    ->save();

                $this->messageManager->addSuccessMessage(__('You have successfully posted a review.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('We can\'t post your review right now.'));
            }
        } else {
            $this->messageManager->addErrorMessage(__('We can\'t post your review right now.'));
        }

        $this->_redirect('catalog/product/view', ['id' => $productId]);
    }
}
