#!/bin/bash
source /etc/profile
cd /var/www
php artisan schedule:run >> /dev/null 2>&1
# php artisan expresses:notification
