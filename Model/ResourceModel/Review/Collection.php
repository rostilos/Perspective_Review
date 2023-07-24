<?php

namespace Perspective\Review\Model\ResourceModel\Review;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init('Perspective\Review\Model\Review', 'Perspective\Review\Model\ResourceModel\Review');
    }
}
