<?php

namespace PinBlooms\Notifications\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\AdminNotification\Model\InboxFactory;
use Magento\Sales\Api\OrderRepositoryInterface;
use Psr\Log\LoggerInterface;

class OrderPlaced implements ObserverInterface
{
    /**
     * @var InboxFactory
     */
    protected $inboxFactory;

    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * OrderPlaced function
     *
     * @param InboxFactory $inboxFactory
     * @param OrderRepositoryInterface $orderRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        InboxFactory $inboxFactory,
        OrderRepositoryInterface $orderRepository,
        LoggerInterface $logger
    ) {
        $this->inboxFactory = $inboxFactory;
        $this->orderRepository = $orderRepository;
        $this->logger = $logger;
    }

    /**
     * OrderPlaced function
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $orderIds = $observer->getEvent()->getOrderIds();
            if (!empty($orderIds)) {
                foreach ($orderIds as $orderId) {

                    $order = $this->orderRepository->get($orderId);
                    $customerName = $order->getCustomerFirstname() . ' ' . $order->getCustomerLastname();
                    $customerEmail = $order->getCustomerEmail();

                    $notificationMessage = __('New Order Placed: %1', $order->getIncrementId())
                        . ' ,' . __('Customer: %1', $customerName)
                        . ' ,' . __('Email: %1', $customerEmail);

                    $this->addAdminNotification(
                        __('New Order Notification'),
                        $notificationMessage
                    );
                }
            }
        } catch (\Exception $e) {
            $this->logger->error('Error in OrderPlaced observer Notification: ' . $e->getMessage());
        }
    }

    /**
     * AddAdminNotification function
     *
     * @param string $title
     * @param string $message
     * @return void
     */
    protected function addAdminNotification($title, $message)
    {
        $inbox = $this->inboxFactory->create();
        $inbox->setTitle($title)
            ->setDescription($message)
            ->setSeverity(1)
            ->setIsRead(0)
            ->setDateAdded(date('Y-m-d H:i:s'))
            ->save();
    }
}
