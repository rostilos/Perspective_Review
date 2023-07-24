<?php
namespace Perspective\Review\Model;

use Magento\Catalog\Model\Product;
use Magento\Framework\Model\AbstractModel;

class Review extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Perspective\Review\Model\ResourceModel\Review::Class);
    }

    public function getUser(): mixed
    {
        return $this->_getData('user_id');
    }
}
