<?php

namespace Perspective\Review\Controller\Index;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Perspective\Review\Model\ConfigManager;
use Perspective\Review\Model\ReviewFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Customer\Model\Session;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Message\ManagerInterface;

class Post implements HttpPostActionInterface
{
    /**
     * @var ReviewFactory
     */
    private ReviewFactory $reviewFactory;

    /**
     * @var Session
     */
    private Session $customerSession;

    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;

    /**
     * @var Validator
     */
    private Validator $formKeyValidator;

    /**
     * @var ConfigManager
     */
    private ConfigManager $configManager;

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @var RedirectFactory
     */
    private RedirectFactory $redirectFactory;

    /**
     * @var ManagerInterface
     */
    private ManagerInterface $messageManager;

    /**
     * @param ReviewFactory $reviewFactory
     * @param Session $customerSession
     * @param ProductRepositoryInterface $productRepository
     * @param Validator $formKeyValidator
     * @param ConfigManager $configManager
     * @param RequestInterface $request
     * @param RedirectFactory $redirectFactory
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        ReviewFactory              $reviewFactory,
        Session                    $customerSession,
        ProductRepositoryInterface $productRepository,
        Validator                  $formKeyValidator,
        ConfigManager              $configManager,
        RequestInterface           $request,
        RedirectFactory            $redirectFactory,
        ManagerInterface           $messageManager,
    ) {
        $this->reviewFactory = $reviewFactory;
        $this->customerSession = $customerSession;
        $this->productRepository = $productRepository;
        $this->formKeyValidator = $formKeyValidator;
        $this->configManager = $configManager;
        $this->request = $request;
        $this->redirectFactory = $redirectFactory;
        $this->messageManager = $messageManager;
    }

    /**
     * Execute action based on request and return result
     *
     * @return Redirect|ResultInterface
     * @throws NoSuchEntityException
     */
    public function execute(): Redirect|ResultInterface
    {
        $resultRedirect = $this->redirectFactory->create()->setRefererUrl();

        if (!$this->formKeyValidator->validate($this->request)) {
            $this->messageManager->addErrorMessage(__('Invalid form key provided.'));
            return $resultRedirect;
        }

        $productId = $this->request->getParam('id');
        $customerId = $this->customerSession->getCustomerId();
        $data = $this->request->getPostValue();

        if (!$this->configManager->isGuestReviewsAllowed() && !$customerId) {
            $this->messageManager->addErrorMessage(__('You must be logged in to post a review.'));
            return $resultRedirect;
        }

        $product = $this->productRepository->getById($productId);

        if (!empty($data)) {
            $review = $this->reviewFactory->create()->setData($data);

            try {
                $review->setProductId($product->getId())
                    ->setCreatedAt(date('Y-m-d H:i:s'))
                    ->setUserId($this->customerSession->getCustomerId())
                    ->save();

                $this->messageManager->addSuccessMessage(__('You have successfully posted a review.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        } else {
            $this->messageManager->addErrorMessage(__('We can\'t post your review right now.'));
        }

        return $resultRedirect;
    }
}
