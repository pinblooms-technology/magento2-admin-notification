# Magento 2.7 - Admin Notification in Various Events

## Overview
The **PinBlooms_Notifications** module provides admin notifications for key events in Magento 2.7, ensuring store administrators stay informed in real time.

## Features
- **Order Placed Notification**: Alerts admins when a new order is placed.
- **Customer Registration Notification**: Notifies admins when a new customer registers.
- **Newsletter Subscription Notification**: Sends notifications when a customer subscribes to the newsletter.
- **Contact Form Submission Notification**: Alerts admins when a contact form is submitted.

## Installation
1. Download or clone this repository.
2. Copy the module files to `app/code/PinBlooms/Notifications`.
3. Run the following commands in your Magento root directory:
   ```bash
   php bin/magento module:enable PinBlooms_Notifications
   php bin/magento setup:upgrade
   php bin/magento setup:di:compile
   php bin/magento setup:static-content:deploy -f
   php bin/magento cache:flush
   ```

## Configuration
- Navigate to **Admin Panel → Stores → Configuration → PinBlooms → Notifications** to manage settings.
- Enable or disable specific notifications as needed.

## File Structure
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
                |           `-- ActionPredispatch.php
                |-- Model
                |   |-- NotifiedNotificationRepository.php
                |   |-- NotifiedNotification.php
                |   `-- ResourceModel
                |       |-- NotifiedNotification
                |       |   `-- Collection.php
                |       |   -- CollectionFactory.php
                |       `-- NotifiedNotification.php
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

## Usage
1. **Order Notification**: An admin notification is generated when an order is placed.
2. **Customer Registration Notification**: A notification is sent when a new customer registers.
3. **Newsletter Subscription Notification**: Admins receive a notification when a customer subscribes.
4. **Contact Form Submission Notification**: A notification appears when a contact form is submitted.

## Support
For any issues, feel free to open a GitHub issue or contact us.

## License
This module is released under the MIT License.

