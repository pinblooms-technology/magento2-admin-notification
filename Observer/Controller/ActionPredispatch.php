<?php

namespace PinBlooms\Notifications\Observer\Controller;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\AdminNotification\Model\InboxFactory;
use PinBlooms\Notifications\Model\NotifiedNotificationRepository;
use Magento\Review\Model\ResourceModel\Review\CollectionFactory;
use Magento\Framework\UrlInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;

class ActionPredispatch implements ObserverInterface
{
    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $backendSession;

    /**
     * @var CollectionFactory
     */
    protected $reviewCollectionFactory;

    /**
     * @var UrlInterface
     */
    protected $url;

    /**
     * @var InboxFactory
     */
    protected $inboxFactory;

    /**
     * @var NotifiedNotificationRepository
     */
    protected $notifiedNotificationRepository;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * ActionPredispatch function
     *
     * @param \Magento\Backend\Model\Auth\Session $backendSession
     * @param CollectionFactory $reviewCollectionFactory
     * @param UrlInterface $url
     * @param InboxFactory $inboxFactory
     * @param NotifiedNotificationRepository $notifiedNotificationRepository
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        \Magento\Backend\Model\Auth\Session $backendSession,
        CollectionFactory $reviewCollectionFactory,
        UrlInterface $url,
        InboxFactory $inboxFactory,
        NotifiedNotificationRepository $notifiedNotificationRepository,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->backendSession = $backendSession;
        $this->reviewCollectionFactory = $reviewCollectionFactory;
        $this->url = $url;
        $this->inboxFactory = $inboxFactory;
        $this->notifiedNotificationRepository = $notifiedNotificationRepository;
        $this->customerRepository = $customerRepository;
    }

    /**
     * ActionPredispatch function
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {

        if (!$this->backendSession->isLoggedIn() || $observer->getRequest()->isXmlHttpRequest()) {
            return;
        }

        $pendingReviews = $this->reviewCollectionFactory->create()
            ->addFieldToFilter('status_id', \Magento\Review\Model\Review::STATUS_PENDING)
            ->getItems();

        foreach ($pendingReviews as $review) {
            $reviewId = $review->getId();
            $customerId = $review->getCustomerId();

            if ($customerId) {
                try {
                    $customer = $this->customerRepository->getById($customerId);
                    $customerName = $customer->getFirstname() . ' ' . $customer->getLastname();
                    $customerEmail = $customer->getEmail();
                } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                    $customerName = __('Unknown');
                    $customerEmail = __('N/A');
                }
            } else {
                $customerName = __('Guest');
                $customerEmail = __('N/A');
            }

            $notificationMessage = __('Received New Review: %1', $review->getTitle())
                . ' ,' . __('Customer: %1', $customerName)
                . ' ,' . __('Email: %1', $customerEmail);

            if (!$this->notifiedNotificationRepository->isNotificationExist('pending_review', $notificationMessage)) {
                $this->addAdminNotification(
                    __('Pending Reviews'),
                    $notificationMessage,
                    'pending_review'
                );
                $this->notifiedNotificationRepository->addNotification('pending_review', $notificationMessage);
            }
        }
    }

    /**
     * AddAdminNotification function
     *
     * @param string $title
     * @param string $message
     * @param string $notificationType
     * @return void
     */
    public function addAdminNotification($title, $message, $notificationType)
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
