<?php

namespace PinBlooms\Notifications\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class NotifiedNotification extends AbstractDb
{
    /**
     * Define the main table and primary key
     */
    protected function _construct()
    {
        $this->_init('custom_notification', 'notification_id');
    }
}
