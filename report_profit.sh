#!/bin/bash
export TZ=America/Los_Angeles;
_now=$(date +"%m_%d_%Y")
_file="/var/www/html/Yahoo-Finance-API-Wrapper/logs/$_now.log"
echo "Starting log to $_file..."
touch "$_file"
#php /var/www/html/Yahoo-Finance-API-Wrapper/ValueStocksBot.php > "$_file"
php /var/www/html/Yahoo-Finance-API-Wrapper/GenerateReport.php

echo "done" 
