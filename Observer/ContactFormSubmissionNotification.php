<?php

namespace PinBlooms\Notifications\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\AdminNotification\Model\InboxFactory;
use Psr\Log\LoggerInterface;

class ContactFormSubmissionNotification implements ObserverInterface
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
     * ContactFormSubmissionNotification function
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
     * ContactFormSubmissionNotification function
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $model = $observer->getEvent()->getObject();
            if ($model instanceof \Numismatic\AdvancedContact\Model\Request) {
                $info = $model->getInfo();
                $data = json_decode($info, true);
                $contactEmail = $this->getFieldValue($data, 'email');
                $contactMessage = $this->getFieldValue($data, 'message');
                $contactMobile = $this->getFieldValue($data, 'phone');

                $message = __('Contact Form Submitted by: %1', $contactEmail)
                    . ',' . __('Message: %1', $contactMessage)
                    . ',' . __('Mobile: %1', $contactMobile);

                $this->addAdminNotification(
                    __('New Contact Form Submission'),
                    $message
                );
            }
        } catch (\Exception $e) {
            $this->logger->error('Error in ContactFormSubmissionNotification observer: ' . $e->getMessage());
        }
    }

    /**
     * Retrieve a field's value from the provided data array by key.
     *
     * @param array $data
     * @param string $key
     * @return string
     */
    protected function getFieldValue(array $data, string $key)
    {
        foreach ($data as $field) {
            if (isset($field['key']) && $field['key'] === $key) {
                return $field['value'];
            }
        }
        return __('Unknown');
    }

    /**
     * Add an admin notification.
     *
     * @param string $title
     * @param string $message
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
