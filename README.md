# Magento 2.7 - Admin Notification in various events

## Admin Notification in :
- Order Place
- Customer Registration
- Newsletter Subscription
- Contact Form Submission


<b>Module: PinBlooms_Notifications</b>

```
|-- README.md
-- app
    -- code
        -- PinBlooms
            -- Notifications
                |-- Observer
                |-- ContactFormSubmissionNotification.php
                |-- CustomerRegistrationNotification.php
                |-- NewsletterSubscriptionNotification.php
                |-- OrderPlaced.php
                |   -- Controller
                |         -- ActionPredispatch.php
                |-- Model
                |   |-- NotifiedNotificationRepository.php
                |   |-- NotifiedNotification.php
                |   |-- ResourceModel
                |       |-- NotifiedNotification
                |       |   -- Collection.php
                |       |   -- CollectionFactory.php
                |       -- NotifiedNotification.php
                |-- etc
                |   |-- acl.xml
                |   |-- adminhtml
                |   |   |-- events.xml
                |   |-- frontend
                |   |   |-- events.xml
                |   |-- db_schema.xml
                |   |-- di.xml
                |   `-- module.xml
                |-- registration.php
                |-- composer.json
``` 
For more useful solution in Magento2, please visit <a href="https://github.com/pinblooms-technology">PinBlooms Technology Pvt. Ltd.</a>
