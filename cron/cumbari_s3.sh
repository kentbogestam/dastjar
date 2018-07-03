#!/bin/bash
 
# Usage cumbari_s3.sh "name of file to upload in s3" "directory to upload to can either be coupon, brands, category or category_lib"
# Usage cumbari_s3.sh myfile dir

INFILE=$1
DIR=$2"/"

OUTFILE=`basename $INFILE`
BASE="cumbari-coupons/upload/"
if [ -f $INFILE ] ; then

aws s3 cp $INFILE s3://$BASE$DIR --acl public-read
	if [ $? -gt 0 ]; then
 		mailx -s "Erron in transferring file $BASE$DIR  $INFILE  to s3" admin@cumbari.com </dev/null
	fi
else
	mailx -s "S3 File $BASE$DIR $INFILE  do not exist on advertise.cumbari.com" admin@cumbari.com </dev/null
fi

