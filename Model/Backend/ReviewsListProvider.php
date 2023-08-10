<?php

namespace Perspective\Review\Model\Backend;

use Hyva\Admin\Api\HyvaGridArrayProviderInterface;
use Perspective\Review\Model\ReviewFactory;

class ReviewsListProvider implements HyvaGridArrayProviderInterface
{

    /**
     * @var ReviewFactory
     */
    private ReviewFactory $reviewFactory;

    /**
     * @param ReviewFactory $reviewFactory
     */
    public function __construct(
        ReviewFactory $reviewFactory
    ) {
        $this->reviewFactory = $reviewFactory;
    }

    /**
     *
     * @inheirtdoc
     *
     * @return array|array[]
     */
    public function getHyvaGridData(): array
    {
        $collection = $this->reviewFactory->create()->getCollection();

        return array_map(static fn ($item) => [
            'review_id' => $item->getReviewId(),
            'product_id' => $item->getProductId(),
            'detail' => $item->getDetail(),
            'created_at' => $item->getCreatedAt(),
            'user_id' => $item->getUserId(),
        ], $collection->getItems());
    }
}
