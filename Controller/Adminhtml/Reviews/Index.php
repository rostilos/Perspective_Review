<?php

namespace Perspective\Review\Controller\Adminhtml\Reviews;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

class Index implements HttpGetActionInterface
{

    /**
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        private readonly PageFactory $resultPageFactory
    ) {
    }

    /**
     * @inheritdoc
     */
    public function execute(): ResultInterface
    {
        return $this->resultPageFactory->create();
    }
}
