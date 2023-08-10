<?php

namespace Perspective\Review\Model;

use Magento\Catalog\Model\Product;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Validator\NotEmpty;
use Magento\Framework\Validator\ValidateException;
use Magento\Framework\Validator\ValidatorChain;

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
     * Validate review summary fields
     *
     * @return bool|string[]
     * @throws ValidateException
     */
    public function validate(): array|bool
    {
        $errors = [];

        if (!ValidatorChain::is($this->getDetail(), NotEmpty::class)) {
            $errors[] = __('Please enter a review text.');
        }

        if (empty($errors)) {
            return true;
        }
        return $errors;
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
