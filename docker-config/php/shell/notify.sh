#!/bin/bash
source /etc/profile
cd /var/ConvenienceLife
php artisan schedule:run >> /dev/null 2>&1
# php artisan expresses:notification
