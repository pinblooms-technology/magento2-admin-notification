<?php

namespace PinBlooms\Notifications\Model;

use Magento\Framework\App\ResourceConnection;

class NotifiedNotificationRepository
{
    /**
     * @var ResourceConnection
     */
    protected $resource;

    /**
     * @var [type]
     */
    protected $connection;

    /**
     * NotifiedNotificationRepository function
     *
     * @param ResourceConnection $resource
     */
    public function __construct(
        ResourceConnection $resource
    ) {
        $this->resource = $resource;
        $this->connection = $resource->getConnection();
    }

    /**
     * IsNotificationExist function
     *
     * @param string $notificationType
     * @param string $message
     * @return boolean
     */
    public function isNotificationExist($notificationType, $message)
    {
        // Query to check if notification already exists
        $select = $this->connection->select()
            ->from($this->resource->getTableName('custom_notification'))
            ->where('notification_type = ?', $notificationType)
            ->where('message = ?', $message);

        $result = $this->connection->fetchOne($select);
        return $result ? true : false;
    }

    /**
     * AddNotification function
     *
     * @param string $notificationType
     * @param string $message
     * @return void
     */
    public function addNotification($notificationType, $message)
    {
        $data = [
            'notification_type' => $notificationType,
            'message' => $message,
            'status' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->connection->insert($this->resource->getTableName('custom_notification'), $data);
    }
}
