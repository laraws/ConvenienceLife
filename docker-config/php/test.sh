#!/bin/bash
source /etc/profile
echo "Hello world" >> /var/log/cron.log 2>&1
