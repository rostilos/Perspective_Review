<?php

namespace Perspective\Review\Controller\Adminhtml\Reviews;

use Magento\Framework\App\Action\HttpGetActionInterface
use Magento\Framework\Controller\ResultInterface

class Index implements HttpGetActionInterface
{

    /**
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        private readonly PageFactory $resultPageFactory
    ) {
    }

}
