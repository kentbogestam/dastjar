#!/bin/sh

# Script name : cumbari_create_coupon.sh
# Dumps all db in advertise 
dbname="cumbari_admin"
date=`date +%Y-%m-%d`

wget --no-check-certificate https://advertise.cumbari.com/couponUsageStatisticsHistory.php -o /tmp/couponUsageStatisticsHistory.err
if [ $? -gt 0 ]; then
mailx -s "Erron in financialService on advertise" admin@cumbari.com </dev/null
fi

rm /root/couponUsageStatisticsHistory.php
