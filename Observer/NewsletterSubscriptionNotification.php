<?php

namespace PinBlooms\Notifications\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\AdminNotification\Model\InboxFactory;
use Psr\Log\LoggerInterface;

class NewsletterSubscriptionNotification implements ObserverInterface
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
     * NewsletterSubscriptionNotification function
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
     * NewsletterSubscriptionNotification function
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $subscriber = $observer->getEvent()->getDataObject();
            $subscriberEmail = $subscriber->getSubscriberEmail();
            $subscriberStatus = $subscriber->getSubscriberStatus();

            if ($subscriberStatus == \Magento\Newsletter\Model\Subscriber::STATUS_SUBSCRIBED) {
                $message = __('A new user has subscribed to the newsletter: %1', $subscriberEmail);
                $this->addAdminNotification(
                    __('New Newsletter Subscription'),
                    $message
                );
            }
        } catch (\Exception $e) {
            $this->logger->error('Error in NewsletterSubscriptionNotification observer: ' . $e->getMessage());
        }
    }

    /**
     * Undocumented function
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
