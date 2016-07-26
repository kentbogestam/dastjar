<?php
try{
	echo "working but not responding</br>";
$file2 = '/srv/www/htdocs/upload/coupon/cpn_1464778643.jpg';
        $dir2 = "coupon";
        $command2 = '/usr/local/bin/test_s3.sh ' . $file2 . " " . $dir2;
echo $command2;		
        //echo "Image dir path".IMAGE_DIR_PATH."</br>";
		//echo $command2; die();
		system($command2);
}catch(Exeption $e){
	echo "error";
	echo $e;
}
?>