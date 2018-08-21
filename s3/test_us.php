#!/usr/local/bin/php
<?php
/**
* $Id$
*
* S3 class usage
*/

if (!class_exists('S3')) require_once 'tpyo-amazon-s3-php-class-390ea1a/S3.php';

// AWS access info
if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAIAF662JUNBTP6YHQ');
if (!defined('awsSecretKey')) define('awsSecretKey', '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');

//$uploadFile = dirname(__FILE__).'/S3.php'; // File to upload, we'll use the S3 class since it exists

$uploadFile = '/srv/www/htdocs/upload/category/cat_icon_1203b44b36659acb583ac473f2359b1f.png';
//$bucketName = '	http://cumbari-coupons.s3-website-eu-west-1.amazonaws.com';
$bucketName = 'cumbari_us.s3-website-us-east-1.amazonaws.com';

// If you want to use PECL Fileinfo for MIME types:
//if (!extension_loaded('fileinfo') && @dl('fileinfo.so')) $_ENV['MAGIC'] = '/usr/share/file/magic';


// Check if our upload file exists
if (!file_exists($uploadFile) || !is_file($uploadFile))
	exit("\nERROR: No such file: $uploadFile\n\n");

// Check for CURL
if (!extension_loaded('curl') && !@dl(PHP_SHLIB_SUFFIX == 'so' ? 'curl.so' : 'php_curl.dll'))
	exit("\nERROR: CURL extension not loaded\n\n");

// Pointless without your keys!
//if (awsAccessKey == 'AKIAIAF662JUNBTP6YHQ' || awsSecretKey == 'mHn5SZRqsn/TWDxQefHQJm2Yzz8zo5cuWFQGd1gm')
//	exit("\nERROR: AWS access information required\n\nPlease edit the following lines in this file:\n\n".
//	"define('awsAccessKey', 'change-me');\ndefine('awsSecretKey', 'change-me');\n\n");

// Instantiate the class
$s3 = new S3(awsAccessKey, awsSecretKey);

// List your buckets:
echo "S3::listBuckets(): ".print_r($s3->listBuckets(), 1)."\n";

// Put our file (also with public read access)
	if ($s3->putObjectFile($uploadFile, $bucketName, baseName($uploadFile), S3::ACL_PUBLIC_READ)) {
		echo "S3::putObjectFile(): File copied to {$bucketName}/".baseName($uploadFile).PHP_EOL;
}else {
	echo "S3::putObjectFile(): Unable to create file (it may already exist and/or be owned by someone else)\n";
}


		// Get the contents of our bucket
//		$contents = $s3->getBucket($bucketName);
//		echo "S3::getBucket(): Files in bucket {$bucketName}: ".print_r($contents, 1);


		// Get object info
//		$info = $s3->getObjectInfo($bucketName, baseName($uploadFile));
//		echo "S3::getObjecInfo(): Info for {$bucketName}/".baseName($uploadFile).': '.print_r($info, 1);


?>
