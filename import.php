<?php

/*  File Name   : getBrandView.php
*   Description : Brand Details
*   Author      : Himanshu Singh
*   Date        : 6th,Dec,2010  Creation
*/

header('Content-Type: text/html; charset=utf-8');

ob_start();
include_once("cumbari.php");
$inoutObj = new inOut();
$menu = "import";
$import = 'class="selected"';
include("mainSupport.php");


if(!isset($_SESSION['supportuserid'])) {
    $url = BASE_URL . 'support.php';
    $inoutObj->reDirect($url);
    exit;
}


// For Product Import.

if(isset($_POST['productButton']))
{
$fname = $_FILES['importProduct']['name'];
$chk_ext = explode(".",$fname);
if(strtolower($chk_ext[1] == "csv"))
{
    $filename = $_FILES['importProduct']['tmp_name'];
    $handle = fopen($filename,"r");
    while(($data = fgetcsv($handle,1000,",")) != FALSE)
    {
       $company_id			=  $data[0];
	   $lang				=  $data[1];
	   $product_name		=  $data[2];
	   $category_name		=  $data[3];	
       $keyword				=  $data[4];
	   $small_image			=  $data[5];
	   $large_image			=  $data[6];
	   $is_sponsered		=  $data[7];
	   $ean_code			=  $data[8];
	   $product_info_page	=  $data[9];
	   $product_number		=  $data[10];
	   $start_of_publishing	=  $data[11];
	   $is_public			=  $data[12];
	   
	   
		/// Select user id from company id.
        $QUE = "select u_id from company where company_id='" . $company_id . "'";
        $res = mysqli_query($QUE) or die(mysql_error());
        $row = mysqli_fetch_array($res);
        $u_id = $row['u_id'];
		
		/* Based on category_name here we will get the category id. */

		$queryCat = "select category_id  from category inner join category_names_lang_list on category.category_id = category_names_lang_list.category inner join lang_text on lang_text.id = category_names_lang_list.names_lang_list where lower(lang) = '".trim(strtolower($lang))."' and lower(text)= '".trim(strtolower($category_name))."'";
		$res = mysqli_query($queryCat);
		$data = mysqli_fetch_array($res);
		$categoryId = $data['category_id'];

		/* End code to get category id.*/

		$productId  = uuid();
		//$userId	= $_SESSION['userid'];
		$userId		= $u_id;
		//$userId = '4e1bebeeedef8';
		$s_active	= 0;

		$queryPro = "INSERT INTO product(`product_id`,`u_id`,`company_id`, `small_image`,`product_name`,`is_sponsored`, `category`,`large_image`,`ean_code`,`product_number`,`is_public`,`start_of_publishing`,`product_info_page`,`s_activ`)
        VALUES ('" . $productId . "','" . $userId . "','" . $company_id . "', '" . $small_image . "','" . $product_name . "','" . $is_sponsered . "','" . $categoryId . "' ,'" . $large_image . "','" . $ean_code . "','" . $product_number . "','" . $is_public . "','" . $start_of_publishing . "','" . $product_info_page . "','" . $s_active . "');";

		mysqli_query($queryPro);


		$sloganLangId = uuid();
		$_SQL = "insert into lang_text(id,lang,text) values('" . $sloganLangId . "','" . $lang . "','" . $product_name . "')";
        $res = mysqli_query($_SQL) or die(mysql_error());

		$_SQL = "insert into product_offer_slogan_lang_list(`product_id`,`offer_slogan_lang_list`) values('" . $productId . "','" . $sloganLangId . "')";
        $res = mysqli_query($_SQL) or die(mysql_error());

	      ////////keyword entry///////
        $keywordId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $keywordId . "','" . $lang . "','" . $keyword . "')";
        $res = mysqli_query($_SQL) or die(mysql_error());

        $_SQL = "insert into product_keyword(`product_id`,`offer_keyword`) values('" . $productId . "','" . $keywordId . "')";
        $res = mysqli_query($_SQL) or die(mysql_error());

    }
    fclose($handle);
    $_SESSION['MESSAGE'] = "<b>Successfully Imported Product Data.</b>";
}
 else
     {
          $_SESSION['MESSAGE'] = "<font color='red'><b>Invalid File Format.</b></font>";
     }
    
}

// End Product Import.

// For Stock Import.

if(isset($_POST['stockButton']))
{
$fname = $_FILES['importStock']['name'];
$chk_ext = explode(".",$fname);
if(strtolower($chk_ext[1] == "csv"))
{
    $filename = $_FILES['importStock']['tmp_name'];
    $handle = fopen($filename,"r");
    while(($data = fgetcsv($handle,0,",")) != FALSE)
    {
       $store_id = uuid();
	   $product_id			=  $data[0];
	   $in_stock			=  $data[1];
	   $amount_in_stock		=  $data[2];
      
	   $sql = "INSERT into in_stock(store_id,product_id,in_stock,amount_in_stock) values('$store_id','$product_id','$in_stock]','$amount_in_stock')";
       mysqli_query($sql) or die(mysql_error());
    }
    fclose($handle);
    $_SESSION['MESSAGE'] = "<b>Successfully Imported Stock Data.</b>";
}
 else
     {
         $_SESSION['MESSAGE'] = "<font color='red'><b>Invalid File Format.</b></font>";
     }
    
}

// End Stock Import.

?>


<html>
    <head>


<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="lib/grid/js/grid.js" type="text/javascript"></script>
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
                echo "Import";
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
                                                                ?></td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        
														<tr>
															<td align="center"><b>Import Product Data:</b></td>
															<td>
																<input type="file" name="importProduct"/>
																<input type="submit" name="productButton" value="Import Product" />
															</td>
														</tr>
														<tr><td height="20"></td></tr>
                                                        
														<tr>
															<td align="center"><b>Import Stock Data:</b></td>
															<td>
																<input type="file" name="importStock" />
																<input type="submit" name="stockButton" value="Import Stock" />
															</td>
														</tr>
														
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
