#!/bin/sh

# Script name : cumbari_create_coupon.sh
# Dumps all db in advertise 
dbname="cumbari_admin"
date=`date +%Y-%m-%d`



wget --no-check-certificate https://advertise.cumbari.com/mobilab.php </dev/null
if [ $? -gt 0 ]; then
mailx -s "Erron in importing data from mobilab on advertise" admin@cumbari.com </dev/null
fi
