#!/bin/bash
 
# Usage cumbari_s3.sh "name of file to upload in s3" "directory to upload to can either be coupon, brands, category or category_lib"
# Usage cumbari_s3.sh myfile dir

INFILE=$1
DIR=$2"/"

OaUTFILE=`basename $INFILE`
BASE="cumbari-coupons/upload/"
if [ -f $INFILE ] ; then

#s3put --fail "x-amz-acl: public-read" $BASE$DIR$OUTFILE $INFILE 2>/dev/null
aws s3 cp $INFILE s3://$BASE$DIR --acl public-read 
	if [ $? -gt 0 ]; then
 		mailx -s "Erron in transferring file $BASE$DIR  $INFILE  to s3" sushil.bhadouria@shephertz.com </dev/null
	fi
else
	mailx -s "S3 File $BASE$DIR $INFILE  do not exist on advertise.cumbari.com" sushil.bhadouria@shephertz.com </dev/null
fi

