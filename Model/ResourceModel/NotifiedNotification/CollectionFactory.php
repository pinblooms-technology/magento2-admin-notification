<?php

namespace PinBlooms\Notifications\Model\ResourceModel\NotifiedNotification;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use PinBlooms\Notifications\Model\ResourceModel\NotifiedNotification\Collection;
use Magento\Framework\ObjectManagerInterface;

class CollectionFactory
{
    /**
     * @var PinBlooms\Notifications\Model\ResourceModel\NotifiedNotification\Collection
     */
    protected $collection;

    /**
     * CollectionFactory constructor.
     * @param ObjectManagerInterface $objectManager
     */
    /**
     * CollectionFactory function
     *
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->collection = $objectManager->get(Collection::class);
    }

    /**
     * Create and return the collection instance.
     *
     * @return Collection
     */
    public function create()
    {
        return $this->collection;
    }
}
