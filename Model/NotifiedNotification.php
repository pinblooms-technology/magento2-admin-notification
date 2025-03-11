<?php

namespace PinBlooms\Notifications\Model;

use Magento\Framework\Model\AbstractModel;
use PinBlooms\Notifications\Model\ResourceModel\NotifiedNotification as ResourceModel;

class NotifiedNotification extends AbstractModel
{
    /**
     * @var string
     */
    protected $_idFieldName = 'notification_id';

    /**
     * @var string
     */
    protected $_primaryKey = 'notification_id';

    /**
     * @var PinBlooms\Notifications\Model\ResourceModel\NotifiedNotification
     */
    protected $_resourceModel = ResourceModel::class;

    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
