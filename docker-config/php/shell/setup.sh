#!/bin/bash

cronStatus=$( service cron status >/dev/null 2>&1 && echo 1 || echo 0)
superStatus=$( service supervisor status >/dev/null 2>&1 && echo 1 || echo 0)

if [ $cronStatus -eq 0 ];then
  crontab /var/crontab/cron
  service cron start
  fi

if [ $superStatus -eq 0 ];then
  /var/shell/supervisord.sh
  fi
