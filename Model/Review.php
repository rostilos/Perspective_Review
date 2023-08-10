<?php

namespace Perspective\Review\Model;

use Magento\Catalog\Model\Product;
use Magento\Framework\Model\AbstractModel;

class Review extends AbstractModel
{
    /**
     * @inheritdoc
     */
    protected function _construct(): void
    {
        $this->_init(\Perspective\Review\Model\ResourceModel\Review::class);
    }

    /**
     * Retrieve user Id
     *
     * @return mixed
     */
    public function getUserId(): mixed
    {
        return $this->_getData('user_id');
    }
}
