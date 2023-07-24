<?php
namespace Perspective\Review\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
class Review extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('perspective_reviews', 'review_id');
    }
}
