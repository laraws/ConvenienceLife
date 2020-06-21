#!/bin/bash
# php项目的一些服务启动
# cron配置和启动

crontab /var/www/docker-config/php/crontab/cron
service cron restart

#supervisord
cp /var/www/docker-config/php/supervisor/laravel-worker.conf  /etc/supervisor/conf.d/
supervisord -c /etc/supervisor/supervisord.conf
supervisorctl reread
supervisorctl update
supervisorctl start laravel-worker:*
#supervisorctl start cron-worker:*

