<<<<<<< HEAD
<?php
/*  File Name : accountView.php
 *  Description : Account View class and functions.
 * Author  :Himanshu Singh  Date: 10th,December,2010  Creation
*/

class accountView {
    /* Function Header :svrAccountViewDefault()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: User Account Details default function
    */


    function stripePayment(){
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $q = $db->query("SELECT * FROM store WHERE online_payment='1' AND  s_activ='1'");
        $q2 = $db->query("SELECT * FROM user WHERE stripe_user_id != null");

        while ($rs = mysqli_fetch_array($q)) {
           print_r($rs);
        }

        while ($rs2 = mysqli_fetch_array($q2)) {
            print_r($rs2);
        }
/*
        if($data[0]['online_payment'] == 1 && $data2[0]['stripe_user_id'] != null){
            return "Yes";
        }else{
            return "No";
        }
        */
    }




}
?>
=======
<?php
/*  File Name : accountView.php
 *  Description : Account View class and functions.
 * Author  :Himanshu Singh  Date: 10th,December,2010  Creation
*/

 function saveNewStandardOffersDetails() {

        $reseller = $_REQUEST['reseller'];
        $inoutObj = new inOut();
         $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
        $arrUser = array();
        $error = '';


        $preview = $_POST['preview'];
        $arrUser['offer_slogan_lang_list'] = addslashes($_POST['titleSloganStand']);

        if ($_POST['icon'] == "") {
            $arrUser['small_image'] = $_POST['category_image'];
        } else {
            $arrUser['small_image'] = $_POST['icon'];       //ye nahi aa rha hai abhi
        }
        
        $arrUser['is_sponsored'] = $_POST['sponsStand'];
        //$arrUser['category'] = $_POST['linkedCatStand'];  //ye bhi nhi aa rha hai
        $arrUser['category'] = '7099ead0-8d47-102e-9bd4-12313b062day';  
        
       
        $arrUser['link'] = $_POST['link'];  //ye bhi nhi aa rha hai
        // string matching
        if ($arrUser['link']) {
            $filestring = $arrUser['link'];
            $findme = 'http://';
            $pos = strpos($filestring, $findme);
            if ($pos === false) {
                $arrUser['link'] = 'http://' . $filestring;
            } else {
                $arrUser['link'] = $filestring;
            }
        }
        $arrUser['keywords'] = addslashes($_POST['searchKeywordStand']);
        $arrUser['large_image'] = $_POST['picture'];  //ye bhi nhi aa rha hai
        // $arrUser['infopage'] = $_POST['descriptiveStand'];
        // string matching
        if ($arrUser['infopage']) {                       //ye bhi nhi aa rha hai
            $filestring = $arrUser['infopage'];
            $findme = 'http://';
            $pos = strpos($filestring, $findme);
            if ($pos === false) {
                $arrUser['infopage'] = 'http://' . $filestring;
            } else {
                $arrUser['infopage'] = $filestring;
            }
        }
        $arrUser['dish_id'] = $_POST['select2'];
        $arrUser['product_name'] = addslashes(mysqli_real_escape_string($conn,$_POST['productName']));
        $arrUser['ean_code'] = $_POST['eanCode'];                        //ye bhi nhi aa rha hai
        $arrUser['is_public'] = $_POST['publicProduct'];              //ye bhi nhi aa rha hai
        $arrUser['product_number'] = $_POST['productNumber'];    //ye bhi nhi aa rha hai
        $arrUser['start_of_publishing'] = $_POST['startDateStand'];
        $arrUser['start_of_publishing'] = DateTime::createFromFormat('d/m/Y H:i', $arrUser['start_of_publishing']);
        $arrUser['start_of_publishing'] = $arrUser['start_of_publishing']->format('Y-m-d H:i:s');
        $arrUser['lang'] = $_POST['lang'];
        $arrUser['preparationTime'] = $_POST['preparationTime'];
        $arrUser['productDescription'] = mysqli_real_escape_string($conn,$_POST['productDescription']);
        $error.= ( $arrUser['offer_slogan_lang_list'] == '') ? ERROR_TITLE_SLOGAN : '';

        $error.= ( $arrUser['is_sponsored'] == '') ? ERROR_STANDARD_SPONSORED : '';

        //$error.= ( $arrUser['category'] == '') ? ERROR_STANDARD_CATEGORY : '';

        $error.= ( $arrUser['preparationTime'] == '') ? ERROR_PREPARATION_TIME : '';

        $error.= ( $arrUser['productDescription'] == '') ? ERROR_PRODUCT_DESCRIPTION : '';

        $_SESSION['post'] = "";

        // Url kept in the session variable..
        $_SESSION['post'] = $_POST;
        $_SESSION['URL2'] = $_SERVER['PHP_SELF'];

        if ($reseller == '') {
            $query = "SELECT pre_loaded_value FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
            $res = mysqli_query($conn , $query) or die(mysql_error());
            $rs_comp = mysqli_fetch_array($res);
            $rs_comp['pre_loaded_value'];
            if ($rs_comp['pre_loaded_value']) {
                //$_SESSION['userid'];
                $pre_loaded_value = $rs_comp['pre_loaded_value'];
            } else {
                $query = "SELECT pre_loaded_value FROM user as usr
          LEFT JOIN company as camp ON       (camp.company_id=usr.company_id)
         WHERE usr.u_id='" . $_SESSION['userid'] . "'";
                $res = mysqli_query($conn , $query) or die(mysql_error());
                $rs_comp = mysqli_fetch_array($res);
                $pre_loaded_value = $rs_comp['pre_loaded_value'];
                //$rs['new_pre_loaded_value'];
            }
            if ($_POST['sponsStand'] == 1) {
                if (($pre_loaded_value == '0' || $pre_loaded_value == null)) {
                    $_SESSION['MESSAGE2'] = CRADIT_YOUR_ACCOUNT;

                    $url = BASE_URL . 'createStandardOffer.php';
                    $inoutObj->reDirect($url);
                    exit();
                }
            }


            $query = "SELECT pre_loaded_value FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
            $res = mysqli_query($conn , $query) or die(mysql_error());
            $rs = mysqli_fetch_array($res);
            $rs['pre_loaded_value'];
            //echo $_SESSION['userid'];
            if ($arrUser['is_sponsored'] == 1 && ($rs['pre_loaded_value'] == '0' || $rs['pre_loaded_value'] == null)) {
                $_SESSION['MESSAGE'] = INSUFFICIENT_BALANCE;
            }
        }
//print_r($_FILES["icon"]["tmp_name"]); die();
        $CategoryIconName = "cat_icon_" . md5(time());
        $info = pathinfo($_FILES["icon"]["name"]);
        //print_r($info); die();
        // Opload images related to
        if (!empty($_FILES["icon"]["name"])) {
            //echo "Cat in"; die();
            if (!empty($_FILES["icon"]["name"])) {
                $file_extension = strtolower($info['extension']);
                if ($file_extension == "png" || $file_extension == "jpg" || $file_extension == "jpeg" 
            || $file_extension == "gif" || $file_extension == "bmp") {      if ($_FILES["icon"]["error"] > 0) {
                        $error.=$_FILES["icon"]["error"] . "<br />";
                    } else {
                        $cat_filename = $CategoryIconName . "." . strtolower($info['extension']);
                        //move_uploaded_file($_FILES["icon"]["tmp_name"],UPLOAD_DIR."Category/" .$cat_filename);
                        $fileOriginal = $_FILES['icon']['tmp_name'];
                        $crop = '5';
                        $size = 'iphone4_cat';
                        $path = UPLOAD_DIR . "category/";
                        $fileThumbnail = $path . $cat_filename;
                        createFileThumbnail($fileOriginal, $fileThumbnail, $size, $frontUpload = 0, $crop, $errorMsg);
//echo $errorMsg; die();
                        $arrUser['small_image'] = $cat_filename;
                    }
                } else {
                    $error.=NOT_VALID_EXT;
                }
            } else {
                if ($_SESSION['preview']['small_image'] != "") {
                    $arrUser['small_image'] = $_SESSION['preview']['small_image'];
                } elseif ($_POST['smallimage'] == "") {
                    $error.= ERROR_SMALL_IMAGE;
                } else {
                    $arrUser['small_image'] = $_POST['smallimage'];
                }
            }
        } else {
            //echo "Cat Resp icon"; die();
            $category_image = $_POST["category_image"];
            if (!empty($category_image)) {

                $categoryImageName = explode(".", $category_image);
                $cat_filename = $CategoryIconName . "." . $categoryImageName[1];
                //move_uploaded_file($_FILES["icon"]["tmp_name"],UPLOAD_DIR."Category/" .$cat_filename);
                $fileOriginal = UPLOAD_DIR . "category_lib/" . $category_image;
                //$crop = '5';
                //$size = 'iphone4_cat';
                $path = UPLOAD_DIR . "category/";
                $fileThumbnail = $path . $cat_filename;
                copy($fileOriginal, $fileThumbnail);
                //createFileThumbnail($fileOriginal, $fileThumbnail, $size, $frontUpload = 0, $crop, $errorMsg);
                $arrUser['small_image'] = $cat_filename;
            } else {
                if ($_SESSION['preview']['small_image'] != "") {
                    $arrUser['small_image'] = $_SESSION['preview']['small_image'];
                } elseif ($_POST['smallimage'] == "") {
                    $error.= ERROR_SMALL_IMAGE;
                } else {
                    $arrUser['small_image'] = $_POST['smallimage'];
                }
            }
        }

        /////////////////////////// upload smallimages into server///////////////////
        $file1 = _UPLOAD_IMAGE_ . 'category/' . $arrUser['small_image'];

        $dir1 = "category";
        $command = IMAGE_DIR_PATH . $file1 . " " . $dir1;
        system($command);
        //echo "End UPLOAD"; die();
        //// Upload Coupen image//////
        $coupenName = "cpn_" . md5(time());
        // $info = pathinfo($_FILES["picture"]["name"]);
        // if (!empty($_FILES["picture"]["name"])) {

        //     if (strtolower($info['extension']) == "jpg" || strtolower($info['extension']) == "png" || strtolower($info['extension']) == "jpeg") {
        //         if ($_FILES["picture"]["error"] > 0) {
        //             $error.=$_FILES["picture"]["error"] . "<br />";
        //         } else {
        //             $coupon_filename = $coupenName . "." . strtolower($info['extension']);
        //             //move_uploaded_file($_FILES["picture"]["tmp_name"],"upload/coupon/" .$coupon_filename);
        //             // Resize the images/////
        //             $fileOriginal = $_FILES['picture']['tmp_name'];
        //             $crop = '5';
        //             $size = 'iphone4';
        //             $path = UPLOAD_DIR . "coupon/";
        //             $fileThumbnail = $path . $coupon_filename;
        //             createFileThumbnail($fileOriginal, $fileThumbnail, $size, $frontUpload = 0, $crop, $errorMsg);
        //             //////////////////////////
        //             $arrUser['large_image'] = $coupon_filename;
        //         }
        //     } else {
        //         $error.=NOT_VALID_EXT;
        //     }
        // } else {
        //     if ($_SESSION['preview']['large_image'] != "") {
        //         $arrUser['large_image'] = $_SESSION['preview']['large_image'];
        //     } elseif ($_POST['largeimage'] == "") {
        //         $error.=ERROR_LARGE_STANDARD_IMAGE;
        //     } else {
        //         //$arrUser['large_image'] = $_POST['largeimage'];

        //         if ($_SESSION['preview']['large_image'] != "") {
        //             $arrUser['large_image'] = $_SESSION['preview']['large_image'];
        //         } elseif ($_POST['largeimage'] == "") {
        //             $error.= ERROR_SMALL_IMAGE;
        //         } else {
        //             $arrUser['large_image'] = $_POST['largeimage'];
        //         }
        //     }
        // }
        /////////////////////////// upload largeimages into server///////////////////
        $file2 = _UPLOAD_IMAGE_ . 'coupon/' . $arrUser['large_image'];
        $dir2 = "coupon";
        $command2 = IMAGE_DIR_PATH . $file2 . " " . $dir2;
        system($command2);
        //echo $error; die();
        if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            if ($reseller == '') {
                $url = BASE_URL . 'createStandardOffer.php';
                $inoutObj->reDirect($url);
                exit();
            } else {
                $url = BASE_URL . 'createResellerStandardOffer.php';
                $inoutObj->reDirect($url);
                exit();
            }
        } else {
            $_SESSION['post'] = "";
        }

        $catImg = IMAGE_AMAZON_PATH . 'category/' . $arrUser['small_image'];
        $copImg = IMAGE_AMAZON_PATH . 'coupon/' . $arrUser['large_image'];
        //echo $copImg;die();
        $standUniqueId = uuid();
        /// Select company id of this user
        $QUE = "select company_id from company where u_id='" . $_SESSION['userid'] . "'";
        $res = mysqli_query($conn , $QUE) or die(mysqli_error($conn));
        $row = mysqli_fetch_array($res);
        $companyId = $row['company_id'];

        if ($companyId == '') {
            $QUE33 = "select company_id from employer where u_id='" . $_SESSION['userid'] . "'";
            $res33 = mysqli_query($conn , $QUE33) or die(mysqli_error($conn));
            $rs33 = mysqli_fetch_array($res33);
            $empCompId = $rs33['company_id'];
            $companyId = $empCompId;
        }

        $query = "INSERT INTO product(`product_id`,`dish_type`,`u_id`,`company_id`, `small_image`,`product_name`,`product_description`,`lang`,`preparation_Time`,`is_sponsored`, `category`,`large_image`,`product_info_page`,`product_number`,`link`,`start_of_publishing`)
        VALUES ('" . $standUniqueId . "','" . $arrUser['dish_id'] . "','" . $_SESSION['userid'] . "','" . $companyId . "', '" . $catImg . "','" . $arrUser['product_name'] . "','" . $arrUser['productDescription'] . "','" . $arrUser['lang'] . "','" . $arrUser['preparationTime'] . "','" . $arrUser['is_sponsored'] . "','" . $arrUser['category'] . "',
           '" . $copImg . "','" . $arrUser['infopage'] . "','" . $arrUser['product_number'] . "','" . $arrUser['link'] . "','" . $arrUser['start_of_publishing'] . "');";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));


        if ($reseller != '') {
            $query = "UPDATE product SET `reseller_status` = 'P' WHERE product_id = '" . $standUniqueId . "'";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        }

        ////////Slogen entry///////
        $sloganLangId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $sloganLangId . "','" . $arrUser['lang'] . "','" . $arrUser['offer_slogan_lang_list'] . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

//For Dish Discription

        $sloganSubLangId = uuid();
        $dishDiscription = addslashes($arrUser['productDescription']);
        $_SQL = "insert into product_offer_sub_slogan_lang_list(`product_id`,`offer_sub_slogan_lang_list`) values('" . $standUniqueId . "','" . $sloganSubLangId . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

        $_SQL = "insert into lang_text(id,lang,text) values('" . $sloganSubLangId . "','" . $arrUser['lang'] . "','" . $dishDiscription . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

//        $couponId = uuid();
//        $query = "INSERT INTO coupon(`coupon_id`,product_id,`brand_name`, `small_image`, `large_image`, `is_sponsored`,`offer_type`,`infopage`,`startValidity`)
//                 VALUES ('" . $couponId . "','" . $standUniqueId . "','" . $arrUser['brand_name'] . "', '" . $arrUser['small_image'] . "','" . $arrUser['large_image'] . "','" . $arrUser['is_sponsored'] . "','0','" . $arrUser['infopage'] . "','" . $arrUser['start_of_publishing'] . "');";
//        $res = mysql_query($query) or die(mysql_error());
        /// SLogen anf language table relation entry ////

        $_SQL = "insert into product_offer_slogan_lang_list(`product_id`,`offer_slogan_lang_list`) values('" . $standUniqueId . "','" . $sloganLangId . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
//        $_SQL = "insert into product_offer_slogan_lang_list(`product_id `,`offer_slogan_lang_list`) values('" . $productId . "','" . $sloganLangId . "')";
//        $res = mysql_query($_SQL) or die(mysql_error());
        ////////keyword entry///////
         if(trim($arrUser['keywords']) != "")
         {
        $keywordId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $keywordId . "','" . $arrUser['lang'] . "','" . $arrUser['keywords'] . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

        $_SQL = "insert into product_keyword(`product_id`,`offer_keyword`) values('" . $standUniqueId . "','" . $keywordId . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
         }

        $SystemkeyId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $SystemkeyId . "','" . $arrUser['lang'] . "','" . $standUniqueId . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

        $_SQL = "insert into product_keyword(`product_id`,`system_key`) values('" . $standUniqueId . "','" . $SystemkeyId . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));


        $Systemkey_companyId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $Systemkey_companyId . "','" . $arrUser['lang'] . "','" . $companyId . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

        $_SQL = "insert into product_keyword(`product_id`,`system_key`) values('" . $standUniqueId . "','" . $Systemkey_companyId . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
        
        
        
         
        $_SESSION['askforstoreStand'] = 1;
        $_SESSION['MESSAGE'] = STANDARD_OFFER_SUCCESS;
        if ($reseller == '') {
            $url = BASE_URL . 'showStandard.php?standId=' . $standUniqueId;
            $inoutObj->reDirect($url);
            exit();
        } else {
            $url = BASE_URL . 'showResellerStandard.php?standId=' . $standUniqueId;
            $inoutObj->reDirect($url);
            exit();
        }
    }
?>
>>>>>>> 5cc0b9d863b050c75ae40bf9926604635487b3e7
