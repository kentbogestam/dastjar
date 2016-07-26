#!/bin/bash
 
# Usage cumbari_s3.sh "name of file to upload in s3" "directory to upload to can either be coupon, brands, category or category_lib"
# Usage cumbari_s3.sh myfile dir

INFILE=$1
DIR=$2"/"

OUTFILE=`basename $INFILE`
BASE="cumbari-coupons/upload/"
if [ -f $INFILE ] ; then

#s3put --fail "x-amz-acl: public-read" $BASE$DIR$OUTFILE $INFILE 2>/dev/null
aws s3 cp $INFILE s3://$BASE$DIR 
	if [ $? -gt 0 ]; then
 		echo  "Erron in transferring file $BASE$DIR  $INFILE  to s3"
	fi
else
	echo  "S3 File $BASE$DIR $INFILE  do not exist on advertise.cumbari.com" 
fi

