#!/bin/bash
_now=$(date +"%m_%d_%Y")
_file="/var/www/html/Research/Finance/logs/$_now.log"
echo "Starting log to $_file..."
php /var/www/html/Research/Finance/ValueStocksBot.php > "$_file"
echo "done" 
