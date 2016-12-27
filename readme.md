# UP Morg's Task, Finance, and Availability Management System

This repository contains the special project of Jeshurun Orquina <jeshorquina@gmail.com>
for the UP Musician's Organization as partial fulfilment for the requirements of her
undegraduate thesis.

## Setup

In order for this system to work, the following is required:
* Composer (install via sudo apt-get composer)
* PHP (version 5.2 or higher)
* URL Rewrite enabled

URL rewrite enabling can be done as follows:

1. Run the following command:

    ```bash
    sudo a2enmod rewrite
    ```

2. After running the command, change the AllowOverride property of ```<Directory /var/www>``` in ```/etc/apache2/apache2.conf``` from ```None``` to ```All```. you should have in your file something like this:
 
    ```conf
    <Directory /var/www/>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    ```
