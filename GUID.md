# Configer The Plugin

## Overview

Unirsal Whatsapp Notifications integrates Magento 2 with the Unirsal messaging service to send transactional text notifications. Customers can be notified when their order is successfully placed as well as when it is invoiced, shipped, canceled, refunded, held or released.



**Note**: 
* Unirsal Notification is totally compatible with Magetrend PdfTemplates and  Default Magneto 2 Invoce PDF.
* The extension supports and keeps track of logged customers or entered phone by visitors when they're in the checkout page.
* The module will be run depending on the Cronjob configuration.


## How to configure

Login to Magento Admin, ``STORES > Configuration `` to configure it in general

![](https://i.imgur.com/u4GACMz.png)

### 1. Configuration

#### 1.1 General Configuration
Go to ``Stores > Settings > Configuration > Unirsal > Whatsapp Notification`` then click on ``General Configuration``

![](https://i.imgur.com/41WRg1h.png)

![](https://i.imgur.com/BLudkTD.png)


* **API URL**: The production URL for unirsal https://api.prod.unirsal.com/backend-service/v3/whatsapp-session/message. 
* **API KEY**: Navigate to your unirsal account and place your apikey.
 * **Instance ID**: Navigate to your unirsal account and place your Instance ID.
  
#### 1.2 Configure Notification
After Configer you unirsal account. Go to ``Stores > Settings > Configuration > Unirsal > Whatsapp Notification`` and click on **Invoice Notification** Or **Order Notification**.

![](https://i.imgur.com/CJloGz0.png)

* **Invoice Notification**: Triggers Invoice Generated for an Order.
Sample Message 

```javascript
Dear #customerName, Your order number #orderIncrementId has been received successfully.

Variables for Placement Notification :

#orderIncrementId : Stand for the Order ID
#ordergetCreatedAt : The Date of the order 
#customerName : Customer Name 
#street : Customer Street Address 
#mobilenumber : Customer Mobile Number 

```


* **Order Placement Notification**: Triggers when customer or guest place order .
Sample Message 

```javascript
Dear #customerName, Your order number #orderIncrementId has been received successfully.

Variables for Placement Notification :

#orderIncrementId : Stand for the Order ID
#ordergetCreatedAt : The Date of the order 
#customerName : Customer Name 
#street : Customer Street Address 
#mobilenumber : Customer Mobile Number 

```

* **Order Hold Notification**: Triggers when The Order Status set to holded .
Sample Message 

```javascript
Dear #customerName , your order #orderIncrementId  has been on hold , Due to many  Attempts to contact you on your phone number, To Unhold the order and proceed the  shipping procedures  please contact us.

Variables for Placement Notification :

#orderIncrementId : Stand for the Order ID
#ordergetCreatedAt : The Date of the order 
#customerName : Customer Name 
#street : Customer Street Address 
#mobilenumber : Customer Mobile Number 
#orderStatus : Order Status

```
* **Order Cancel Notification**: Triggers when The Order Status set to cenceld .
Sample Message 

```javascript
Dear #name, We regret to inform you that your order #orderIncrementId has been cancelled. We hope to see you again soon.

Variables for Placement Notification :

#orderIncrementId : Stand for the Order ID
#ordergetCreatedAt : The Date of the order 
#customerName : Customer Name 
#street : Customer Street Address 
#mobilenumber : Customer Mobile Number 
#orderStatus : Order Status

```

* **Order Processing(shippment) Notification**: Triggers when The Order Status set to shipped .
Sample Message 

```javascript
Dear #customerName, your order (#orderIncrementId) has been Shipped. Please don’t hesitate to contact us for any further assistance, and thank you for shopping with us.

Variables for Placement Notification :

#orderIncrementId : Stand for the Order ID
#ordergetCreatedAt : The Date of the order 
#customerName : Customer Name 
#street : Customer Street Address 
#mobilenumber : Customer Mobile Number 
#orderStatus : Order Status

```


* **Order Complete Notification**: Triggers when The Order Status set to complete .
Sample Message 

```javascript
Dear #customerName, your order (#orderIncrementId) has been Completed.thank you for shopping with us.

Variables for Placement Notification :

#orderIncrementId : Stand for the Order ID
#ordergetCreatedAt : The Date of the order 
#customerName : Customer Name 
#street : Customer Street Address 
#mobilenumber : Customer Mobile Number 
#orderStatus : Order Status

```

## Abandoned Cart Notification

Unirsal Whatsapp Notifications integrates Magento 2 Built in abandoned cart report.

 
## How to configure

#### 1.0 Configure Quote Lifetime

Login to Magento Admin, ``STORES > Configuration > Sales > checkout > Shopping Cart`` to configure the time to flag a customer cart as Abandoned Please change **Quite Lifetime** to the intended time the default in 30 days


![](https://i.imgur.com/X1Q6SdV.png)


#### 1.1 Configure Marketing Message

Login to Magento Admin, ``STORES > Configuration > Unirsal > Abandoned Cart Notification`` Enable the cart and lpace the text and image you want to be sent to the customer.

![](https://i.imgur.com/Nu4HLja.png)

![](https://i.imgur.com/VMydv6l.png)

