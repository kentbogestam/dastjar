<?php

//include_once './tpyo-amazon-s3-php-class-390ea1a/S3.php';
require_once './tpyo-amazon-s3-php-class-390ea1a/S3.php';

$s3 = new S3("AKIAIAF662JUNBTP6YHQ", "mHn5SZRqsn/TWDxQefHQJm2Yzz8zo5cuWFQGd1gm");
    print_r($s3->listBuckets());

$file="../upload/category/cat_icon_1203b44b36659acb583ac473f2359b1f.png";
$bucket="http://dastjar-coupons.s3-website-eu-west-1.amazonaws.com";
//$bucket="http://cumbari-coupons.s3-website-eu-west-1";
//$bucket="cumbari-coupons";
$uri="test.png";
// Simple PUT:
    if (S3::putObject(S3::inputFile($file), $bucket, $uri, S3::ACL_PUBLIC_READ)) {
        echo "File uploaded.";
    } else {
        echo "Failed to upload file.";
    }

?>
