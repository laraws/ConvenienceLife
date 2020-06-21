#!/bin/bash

#supervisord
cp /var/config/supervisor/laravel-worker.conf  /etc/supervisor/conf.d/
supervisord -c /etc/supervisor/supervisord.conf
supervisorctl reread
supervisorctl update
supervisorctl start laravel-worker:*
