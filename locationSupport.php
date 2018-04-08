<?php
header('Content-Type: text/html; charset=utf-8');
header('Content-Type: text/html; charset=UTF-8');
ob_start();

include_once("cumbari.php");
$inoutObj = new inOut();
$menu = "location";
$location = 'class="selected"';
include("mainSupport.php");


if (!isset($_SESSION['supportuserid'])) {
    $url = BASE_URL . 'support.php';
    $inoutObj->reDirect($url);
    exit;
}


// For add public location.

if (isset($_POST['continue'])) {
    $fname = $_FILES['publiclocation']['name'];
    $chk_ext = explode(".", $fname);
    if (strtolower($chk_ext[1] == "csv")) {
        $filename = $_FILES['publiclocation']['tmp_name'];
        $handle = fopen($filename, "r");
	 //$handle = str_replace("\t", ";",  iconv('UTF-16', 'UTF-8', $handle));
        $storenameIncmt = 0;
        //$latIncmt = 0;
        $blankStore = array();
        $recordCounter = 0;
        while (($data = fgetcsv($handle, 1000, ",")) != FALSE) {
            if($recordCounter){
            $storeId = $data[0];
            $uId = $data[1];
            $lat = $data[2];
            $long = $data[3];
            $store_name = $data[4];
            $street =  $data[5];
            $zip = $data[6];
            $city = $data[7];
            $country = $data[8];
            $country_code = $data[9];
            $phone = $data[10];
            $email = $data[11];
            $chain = $data[12];
            $block = $data[13];
            $store_link = $data[14];
            $s_activ = $data[15];
            $version = $data[16];
            //$access_type = $data[17];

///////////////// condition for check same street address with same store name

            mysqli_query("SET CHARACTER SET 'utf8'") or die(mysql_error());
            $query1 = "select * from store where store_name ='" . $store_name . "' and street = '" . $street . "'";
            $res1 = mysqli_query($query1);

           if($res1 > 0)
           {
            $rs1 = mysqli_fetch_array($res1);

            $checkStoreId = $rs1['store_id'];

            if($checkStoreId == '')
            {


///////////////// user id condition

            if($uId == '')
            {
                $access_type = 0; // 0 means public store
            }else{
                $access_type = 1; // 1 means private store
            }

  ///////////////// store name condition

            if ($store_name == '') {
                $storenameIncmt++;
            }

    ///////////////// email condition

            if ($email == '') {
                $email = 'admin@dastjar.com';
            }

   ///////////////// country code condition

            if ($country_code == '') {
                // $country = 'india';
                $QUE = "select iso from country where name ='" . strtoupper($country) . "'";
                $res = mysqli_query($QUE) or die(mysql_error());
                $row = mysqli_fetch_array($res);
                $country_code = $row['iso'];
            }

    ///////////////// s_activ  condition

            if($s_activ == '')
            {
                $s_activ = 1;
            }

     ///////////////// version condition

            if($version == '')
            {
                $version = 'NULL';
            }




  ////////////// run lat long script

           if($lat == '')
           {
             //$expStr = explode(" ",$street);
            //print_r($expStr);
              // echo getlatandlon(urlencode($street.' '.$city.''.$country));
       $latLangURL = 'http://maps.google.com/maps/api/geocode/json?address='.$street.' '.$city.' '.$country.'&sensor=false';
      //$geocode=file_get_contents($latLangURL);
      $geocode=file_get_contents(str_replace(" ", "%20",$latLangURL));


     // $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$street.'&sensor=false');
      $output= json_decode($geocode);

      $lat = $output->results[0]->geometry->location->lat;
      $long = $output->results[0]->geometry->location->lng;

    // echo '<pre>';  echo "Latitude : ".$lat;
    // echo "Longitude : ".$long; echo '</pre>';

     if($lat == '')
     {
        array_push($blankStore,$store_name);

     }
           }

//         if ($lat == '')
//            {
//                $latIncmt++;
//            }

       //// insert into database
            if($storeId == '')
            {
            $storeId = uuid();
            }

            if(($store_name != '') && ($lat != ''))
            {
            $queryPro = "INSERT INTO store(`store_id`,`u_id`,`latitude`,`longitude`,`store_name`,`street`,`city`, `country`,`country_code`,`phone`,`email`,`store_link`,`s_activ`,`access_type`,`chain`,`block`,`zip`)
        VALUES ('" . $storeId . "','" . $uId . "','" . $lat . "', '" . $long . "','" . $store_name . "','" . $street . "','" . $city . "' ,'" . $country . "','" . $country_code . "','" . $phone . "','" . $email . "','" . $store_link . "','" . $s_activ . "','" . $access_type . "','" . $chain . "','" . $block . "','" . $zip . "');";
           mysqli_query($queryPro);

            }

            }
           }
        }
        $recordCounter++;

        }

       //$totalerrfile = $storenameIncmt + $latIncmt;
        fclose($handle);
        if(count($blankStore))
        {
           
           $_SESSION['MESSAGE'] = implode(",", $blankStore) . "<b> Data's are not Uploaded </b>";

            $text = implode(",", $blankStore);
            $line = "Sno.\tStoreName\tDate\tReason\n";
            $i=1;
           foreach ($blankStore as $text1) {

            $line.="  $i\t $text1\t  ".date("y/m/d")."\t NOT ABLE TO FIND LAT/LONG VALUE\n";
            $line.="========================================================================\n";
            $i++;
            }


        function append_file($filename,$newdata) {
        $f=fopen($filename,'a');
        fwrite($f,$newdata);
        fclose($f);
        }

        $cumbari = "cumbari_log_" . time();
      $path = '../../../var/cumbari/logs/'.$cumbari.'.log';      
        append_file($path,$line);        }
        
        if ($storenameIncmt != '') {
            $_SESSION['MESSAGE_2'] = $storenameIncmt . "<b> Store name are not Available </b>";

        }
    } else {
        $_SESSION['MESSAGE'] = "<font color='red'><b>Invalid File Format.</b></font>";
    }
}


// End .
?>


<html>
    <head>


        <link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
        <link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
        <script language="JavaScript" src="lib/grid/js/grid.js" type="text/javascript"></script>
       <META http-equiv="Content-Type" content="text/html; charset=utf-8">

    </head>


    <body>
        <div class="center">
            <div id="msg" align="Center">
<?php
if ($_SESSION['MESSAGE']) {
    echo $_SESSION['MESSAGE'];
    $_SESSION['MESSAGE'] = "";
}
?>
            </div>
            <br/>
            <div style=" font-size:22px;"  >
                <b>   <?
echo "ADD LOCATION";
?></b>
            </div>

            <div id="container">
                <table width="900"  cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td valign="top" ><table  cellpadding="0" cellspacing="0">

                                <tr>
                                    <td height="300" valign="top">
                                        <table width="900"  align="center" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td colspan="2" align="center">
                                                    <form action= "" method="post" target="_self" enctype="multipart/form-data">

                                                               <table width="100%" border="0" cellpadding="0" cellspacing="0">

                                                            <tr>

                                                                <td align="center">
<?php
if ($_SESSION['MESSAGE']) {
    echo $_SESSION['MESSAGE'];
    $_SESSION['MESSAGE'] = "";
}

if ($_SESSION['MESSAGE_2']) {
    echo $_SESSION['MESSAGE_2'];
    $_SESSION['MESSAGE_2'] = "";
}
?></td>
                                                                <td>&nbsp;</td>
                                                            </tr>

                                                            <tr>
                                                                <td align="center"><b>Import Location Data:</b></td>
                                                                <td>
                                                                    <input type="file" name="publiclocation"/>
                                                                    <input type="submit" name="continue" value="Import" />
                                                                </td>
                                                            </tr>
                                                            <tr><td height="20"></td></tr>



                                                            </tr>
                                                        </table>
                                                    </form>

                                                </td>
                                            </tr>

                                        <br /> </td>
                                </tr>
                            </table></td>
                    </tr>
                </table>
                </td>
                </tr>

                </table>
            </div>



            <table width="100%" >
                <tr>
                    <td height="60">&nbsp;</td>
                </tr>

                <tr>

                    <td ><span class='mandatory'>* These Fields Are Mandatory </span>
                    </td>
                </tr>
            </table></div>
<? include("footer.php"); ?>
    </body>
</html>
