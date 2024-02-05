
# Unirsal Whatsapp Notification Extension

Unirsal Whatsapp Notifications integrates Magento 2 with the Unirsal messaging service to send transactional text notifications. Customers can be notified when their order is successfully placed as well as when it is invoiced, shipped, canceled, refunded, held or released.

## Requirements

* PHP 7.3.0+ or 7.4.0+ (recommended)
* Magento Open Source/Commerce 2.3.0+ or 2.4.0+ (recommended)
* A [LINK Mobility] account in Unirsal platform




### Composer (recommended)

We highly recommend purchasing the extension from the [Magento Marketplace],
where you can receive the latest version for free. Once purchased, you can use
the following commands to install it from a terminal or command prompt:

    $ cd /path/to/your/site
    $ composer require Unirsal/module-unirsal-notifications

### Manual

This extension can be downloaded from [GitHub] and installed into the
`app/code` directory of your Magento installation with these commands:

    $ cd /path/to/your/site/app/code
    $ mkdir Unirsal
    $ cd Unirsal
    $ mkdir Whatsappbasic
    $ cd Whatsappbasic
    $ git clone git@github.com:Unirsal/magento-module.git

### Post-Install

After installing the extension for the first time, please run these commands to
enable it:

    $ cd /path/to/your/site
    $ php bin/magento module:enable Unirsal_Notifications

Once you have enabled the extension, please follow the instructions in the
[Post-Install, Post-Update or Post-Uninstall][post]
section to complete the installation process.


## Configuration

The settings can configured in the Admin panel at
`Stores > Settings > Configuration > General > Unirsal`. For detailed
descriptions of the available options, please refer to the [User Guide].


## Support

If you experience any issues or errors while using the extension, please open a
ticket by sending an e-mail to [info@unirsal.com][Support]. Be sure to
include your domain, PHP version, Magento version, a detailed description of the
problem including steps to reproduce it and any other relevant information. We
do our best to respond to all legitimate inquires within 48 business hours.
