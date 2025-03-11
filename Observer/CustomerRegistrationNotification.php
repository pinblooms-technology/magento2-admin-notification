<?php

namespace PinBlooms\Notifications\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\AdminNotification\Model\InboxFactory;
use Psr\Log\LoggerInterface;

class CustomerRegistrationNotification implements ObserverInterface
{
    /**
     * @var InboxFactory
     */
    protected $inboxFactory;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * CustomerRegistrationNotification function
     *
     * @param InboxFactory $inboxFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        InboxFactory $inboxFactory,
        LoggerInterface $logger
    ) {
        $this->inboxFactory = $inboxFactory;
        $this->logger = $logger;
    }

    /**
     * CustomerRegistrationNotification function
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $customer = $observer->getEvent()->getCustomer();
            if ($customer) {
                $customerName = $customer->getFirstname() . ' ' . $customer->getLastname();
                $customerEmail = $customer->getEmail();

                $notificationMessage = __('New Customer Registered: %1', $customerName)
                    . ' ,' . __('Email: %1', $customerEmail);

                $this->addAdminNotification(
                    __('New Customer Registration'),
                    $notificationMessage
                );
            }
        } catch (\Exception $e) {
            $this->logger->error('Error in CustomerRegister observer Notification: ' . $e->getMessage());
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
