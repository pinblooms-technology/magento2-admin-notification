<?php

namespace PinBlooms\Notifications\Model\ResourceModel\Notification;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use PinBlooms\Notifications\Model\Notification;
use PinBlooms\Notifications\Model\ResourceModel\Notification as NotificationResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'notification_id';

    /**
     * @var string
     */
    protected $_keyFieldName = 'notification_id';

    /**
     * @var PinBlooms\Notifications\Model\Notification
     */
    protected $_model = Notification::class;

    /**
     * Undocumented variable
     *
     * @var PinBlooms\Notifications\Model\ResourceModel\Notification
     */
    protected $_resourceModel = NotificationResourceModel::class;

    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init($this->_model, $this->_resourceModel);
    }
}
