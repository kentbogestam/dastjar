<?php

function editSaveProductPreview($productid, $reseller='') {
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $inoutObj = new inOut();

        $_SESSION['postPaymentStand'] = $_POST;
        $_SESSION['URL2'] = $_SERVER['PHP_SELF'] . "?productId=" . $productid;


        if ($reseller == '') {
            $query = "SELECT pre_loaded_value FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
            $rs_comp = mysqli_fetch_array($res);
            $rs_comp['pre_loaded_value'];
            if ($rs_comp['pre_loaded_value']) {
                $pre_loaded_value = $rs_comp['pre_loaded_value'];
            } else {
                $query = "SELECT pre_loaded_value FROM user as usr
          LEFT JOIN company as camp ON       (camp.company_id=usr.company_id)
         WHERE usr.u_id='" . $_SESSION['userid'] . "'";
                $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
                $rs_comp = mysqli_fetch_array($res);
                $pre_loaded_value = $rs_comp['pre_loaded_value'];
            }
            if ($_POST['sponsStand'] == 1) {
                if (($pre_loaded_value == '0' || $pre_loaded_value == null)) {
                    echo $_SESSION['MESSAGE2'] = CRADIT_YOUR_ACCOUNT;

                    $url = BASE_URL . 'editStandard.php?productId=' . $productid . "&ldacc=1";
                    $inoutObj->reDirect($url);
                    exit();
                }
            }
        }


        $_SESSION['product_for_edit'] = serialize($_POST);

        if ($_FILES['picture']['name'] <> '') {
            //$_SESSION['preview']['large_image'] = $_FILES['picture']['name']; //<> '' ? $_FILES['picture']['name'] : $_POST['largeimage']['name'] ;
        }
        
        $_SESSION['preview']['offer_slogan_lang_list'] = $_POST['titleSloganStand'];
        $_SESSION['preview']['product_name'] = mysqli_real_escape_string($conn,$_POST['productName']);
        $_SESSION['preview']['brand_name'] = $_POST['standOfferName'];  //ye bhi nhi aa rha
        $_SESSION['preview']['product_number'] = $_POST['productNumber']; //ye nhi aa rha
        $_SESSION['preview']['productId'] = $productid;
        $_SESSION['preview']['linkedCatStand'] = $_POST['linkedCatStand']; //ye nhi aa rha 
        $_SESSION['preview']['lang'] = $_POST['lang'];
        $_SESSION['preview']['dish_id'] = $_POST['select2'];
        $_SESSION['preview']['preparation_Time'] = $_POST['preparationTime'];
        $_SESSION['preview']['product_description'] = mysqli_real_escape_string($conn,$_POST['productDescription']);

        //// Upload Coupen image//////
        $coupenName = "cpn_" . md5(time());
        $info = pathinfo($_FILES["picture"]["name"]);

        /*  if (!empty($_FILES["picture"]["name"])) {
          if (strtolower($info['extension']) == "jpg") {
          if ($_FILES["picture"]["error"] > 0) {
          $error.=$_FILES["picture"]["error"] . "<br />";
          } else {
          $coupon_filename = $coupenName . "." . strtolower($info['extension']);
          $fileOriginal = $_FILES['picture']['tmp_name'];
          $crop = '5';
          $size = 'iphone4';
          $path = UPLOAD_DIR . "coupon/";
          $fileThumbnail = $path . $coupon_filename;
          createFileThumbnail($fileOriginal, $fileThumbnail, $size, $frontUpload = 0, $crop, $errorMsg);
          $arrUser['large_image'] = $coupon_filename;
          $_SESSION['preview']['large_image'] = $coupon_filename;
          }
          } else {
          $error.=NOT_VALID_EXT;
          }
          } else {
          $error.=ERROR_SMALL_IMAGE;
          } */

        if (!empty($_FILES["picture"]["name"])) {
            if (strtolower($info['extension']) == "jpg" || strtolower($info['extension']) == "png" || strtolower($info['extension']) == "jpeg") {
                if ($_FILES["picture"]["error"] > 0) {
                    $error.=$_FILES["picture"]["error"] . "<br />";
                } else {
                    $coupon_filename = $coupenName . "." . strtolower($info['extension']);
                    //move_uploaded_file($_FILES["picture"]["tmp_name"],"upload/coupon/" .$coupon_filename);
                    // Resize the images/////
                    $fileOriginal = $_FILES['picture']['tmp_name'];
                    $crop = '5';
                    $size = 'iphone4';
                    $path = UPLOAD_DIR . "coupon/";
                    $fileThumbnail = $path . $coupon_filename;
                    createFileThumbnail($fileOriginal, $fileThumbnail, $size, $frontUpload = 0, $crop, $errorMsg);
                    //////////////////////////
                    $arrUser['large_image'] = $coupon_filename;
                    $_SESSION['preview']['large_image'] = $arrUser['large_image'];
                }
            } else {
                $error.=NOT_VALID_EXT;
            }
        }

        /////////////////////////// upload largeimages into server///////////////////
        $file2 = _UPLOAD_IMAGE_ . 'coupon/' . $arrUser['large_image'];
        $dir2 = "coupon";
        $command2 = IMAGE_DIR_PATH . $file2 . " " . $dir2;
        system($command2);

//        else {
//            if ($_SESSION['preview']['large_image'] != "") {
//                $arrUser['large_image'] = $_SESSION['preview']['large_image'];
//            } elseif ($_POST['largeimage'] == "") {
//                $error.=ERROR_LARGE_STANDARD_IMAGE;
//            } else {
//                //$arrUser['large_image'] = $_POST['largeimage'];
//
//                if ($_SESSION['preview']['large_image'] != "") {
//                    $arrUser['large_image'] = $_SESSION['preview']['large_image'];
//                } elseif ($_POST['largeimage'] == "") {
//                    $error.= ERROR_SMALL_IMAGE;
//                } else {
//                    $arrUser['large_image'] = $_POST['largeimage'];
//                    $_SESSION['preview']['large_image'] = $arrUser['large_image'];
//                }
//            }
//        }
        $q = $this->editSaveProduct($productid, $reseller);
    }

    function editSaveProduct($productid, $reseller='') {

        extract(((unserialize($_SESSION['product_for_edit']))));

        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $arrUser = array();
        $error = '';

        $arrUser['offer_slogan_lang_list'] = addslashes($titleSloganStand);

        if ($_POST['icon'] == "") {
            $arrUser['small_image'] = $_POST['category_image'];
        } else {
            $arrUser['small_image'] = $_POST['icon'];
        }

        $arrUser['is_sponsored'] = $sponsStand;
        $arrUser['link'] = $link;

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
        $arrUser['keywords'] = addslashes($searchKeywordStand);
        $arrUser['large_image'] = $_POST['picture'];
        $arrUser['product_info_page'] = $descriptiveStand;
        // string matching
        if ($arrUser['product_info_page']) {
            $filestring = $arrUser['product_info_page'];
            $findme = 'http://';
            $pos = strpos($filestring, $findme);
            if ($pos === false) {
                $arrUser['product_info_page'] = 'http://' . $filestring;
            } else {
                $arrUser['product_info_page'] = $filestring;
            }
        }
        $arrUser['product_name'] = addslashes(mysqli_real_escape_string($conn,$productName));
        $arrUser['ean_code'] = $eanCode;
        $arrUser['is_public'] = '1';
        $arrUser['product_number'] = $productNumber;
        $arrUser['start_of_publishing'] = $startDateStand;
        $arrUser['lang'] = $lang;
        $arrUser['language'] = $_POST['lang'];
        $arrUser['dish_id'] = $_POST['select2'];
        $arrUser['preparation_Time'] = $_POST['preparationTime'];
        $arrUser['product_description'] = mysqli_real_escape_string($conn,$_POST['productDescription']);

        $arrUser['start_of_publishing'] = DateTime::createFromFormat('d/m/Y H:i', $arrUser['start_of_publishing']);
        $arrUser['start_of_publishing'] = $arrUser['start_of_publishing']->format('Y-m-d H:i:s');

        $error.= ( $arrUser['offer_slogan_lang_list'] == '') ? ERROR_TITLE_SLOGAN : '';

        $error.= ( $arrUser['start_of_publishing'] == '') ? ERROR_START_OF_PUBLISHING : '';

        $CategoryIconName = "cat_icon_" . md5(time());
        $info = pathinfo($_FILES["icon"]["name"]);
        $catImg = "";

        if (!empty($_FILES["icon"]["name"])) {
            if (!empty($_FILES["icon"]["name"])) {

                if (strtolower($info['extension']) == "png") {
                    if ($_FILES["icon"]["error"] > 0) {
                        $error.=$_FILES["icon"]["error"] . "<br />";
                    } else {
                        if($_POST['dish_image_original'] != $_FILES['icon']['name']){
                        $cat_filename = $CategoryIconName . "." . strtolower($info['extension']);
                        $fileOriginal = $_FILES['icon']['tmp_name'];
                        $crop = '5';
                        $size = 'iphone4_cat';
                        $path = UPLOAD_DIR . "category/";
                        $fileThumbnail = $path . $cat_filename;
                        createFileThumbnail($fileOriginal, $fileThumbnail, $size, $frontUpload = 0, $crop, $errorMsg);
                        $arrUser['small_image'] = $cat_filename;
                        $file1 = _UPLOAD_IMAGE_ . 'category/' . $arrUser['small_image'];
                        $dir1 = "category";                        
                        $command = IMAGE_DIR_PATH . $file1 . " " . $dir1;
                        system($command);
                        $catImg = IMAGE_AMAZON_PATH . 'category/' . $arrUser['small_image'];
                        }
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
            //print_r($_SESSION['preview']);
            //echo $_POST['smallimage']."iiiiiii".$category_image = $_POST["category_image"]; die();
            // if (!empty($category_image)) {

            //     $categoryImageName = explode(".", $category_image);
            //     $cat_filename = $CategoryIconName . "." . $categoryImageName[1];
            //     //move_uploaded_file($_FILES["icon"]["tmp_name"],UPLOAD_DIR."Category/" .$cat_filename);
            //     $fileOriginal = UPLOAD_DIR . "category_lib/" . $category_image;
            //     //$crop = '5';
            //     //$size = 'iphone4_cat';
            //     $path = UPLOAD_DIR . "category/";
            //     $fileThumbnail = $path . $cat_filename;
            //     copy($fileOriginal, $fileThumbnail);
            //     //createFileThumbnail($fileOriginal, $fileThumbnail, $size, $frontUpload = 0, $crop, $errorMsg);
            //     $arrUser['small_image'] = $cat_filename;
            // } else {
            //     if ($_SESSION['preview']['small_image'] != "") {
            //         $arrUser['small_image'] = $_SESSION['preview']['small_image'];
            //     } elseif ($_POST['smallimage'] == "") {
            //         $error.= ERROR_SMALL_IMAGE;
            //     } else {
            //         $arrUser['small_image'] = $_POST['smallimage'];
            //     }
            // }
        }

        /////////////////////////// upload smallimages into server///////////////////
        // $file1 = _UPLOAD_IMAGE_ . 'category/' . $arrUser['small_image'];
        // $dir1 = "category";
        // $command = IMAGE_DIR_PATH . $file1 . " " . $dir1;
        // system($command);
        // //echo "End UPLOAD"; die();
        // //// Upload Coupen image//////
        // $coupenName = "cpn_" . md5(time());
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

        $arrUser['large_image'] = $_SESSION['preview']['large_image'];

        $_SESSION['preview'] = $arrUser;
        if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            if ($reseller == '') {
                $url = BASE_URL . 'editStandard.php?productId=' . $productid;
                $inoutObj->reDirect($url);
                exit();
            } else {
                $url = BASE_URL . 'editStandard.php?productId=' . $productid . '&from=reseller';
                $inoutObj->reDirect($url);
                exit();
            }
        } else {
            $_SESSION['post'] = "";
        }

        $copImg = IMAGE_AMAZON_PATH . 'coupon/' . $arrUser['large_image'];

        /////////////////start date is more than current date
        $t = date("Y-m-d");
        if ($arrUser['start_of_publishing'] > $t) {
 
            $query0 = "select * from c_s_rel  where product_id = '" . $productid . "'";
            $res0 = mysqli_query($conn , $query0) or die(mysqli_error($conn));
            
            while ($rs0 = mysqli_fetch_array($res0)) {
                $couponId = $rs0['coupon_id'];

                if ($couponId) {

                    /////delete coupon
                    $query1 = "DELETE FROM coupon WHERE coupon_id = '" . $couponId . "'";
                    $res1 = mysqli_query($conn , $query1) or die(mysqli_error($conn));

                    $query2 = "select * from coupon_offer_slogan_lang_list  where coupon = '" . $couponId . "'";
                    $res2 = mysqli_query($conn , $query2) or die('1' . mysqli_error($conn));
                    while ($rs2 = mysqli_fetch_array($res2)) {
                        $offslogen = $rs2['offer_slogan_lang_list'];


                        $_SQL1 = "DELETE FROM coupon_offer_slogan_lang_list WHERE coupon = '" . $couponId . "'";
                        $res1 = mysqli_query($conn , $_SQL1) or die(mysqli_error($conn));

                      //  $_SQL2 = "DELETE FROM lang_text WHERE id = '" . $offslogen . "'";
                      //  $res2 = mysql_query($_SQL2) or die(mysql_error());
                    }

                    $query3 = "select * from coupon_offer_title_lang_list  where coupon = '" . $couponId . "'";
                    $res3 = mysqli_query($conn , $query3) or die('1' . mysqli_error($conn));
                    while ($rs3 = mysqli_fetch_array($res3)) {
                        $offtitle = $rs3['offer_title_lang_list'];

                        $_SQL8 = "DELETE FROM coupon_offer_title_lang_list WHERE coupon = '" . $couponId . "'";
                        $res8 = mysqli_query($conn , $_SQL8) or die(mysqli_error($conn));

                      //  $_SQL20 = "DELETE FROM lang_text WHERE id = '" . $offtitle . "'";
                      //  $res20 = mysql_query($_SQL20) or die(mysql_error());
                    }

                    $query4 = "select * from coupon_keywords_lang_list  where coupon = '" . $couponId . "'";
                    $res4 = mysqli_query($conn , $query4) or die('1' . mysqli_error($conn));
                    while ($rs4 = mysqli_fetch_array($res4)) {
                        $ckeyword = $rs4['keywords_lang_list'];

                        $_SQL5 = "DELETE FROM coupon_keywords_lang_list WHERE coupon = '" . $couponId . "'";
                        $res5 = mysqli_query($conn , $_SQL5) or die(mysqli_error($conn));

                      //  $_SQL6 = "DELETE FROM lang_text WHERE id = '" . $ckeyword . "'";
                      //  $res6 = mysql_query($_SQL6) or die(mysql_error());
                    }
                    //////update c_s_rel
                    $_SQL = "UPDATE c_s_rel SET activ='2', start_of_publishing = '" . $arrUser['start_of_publishing'] . "' WHERE product_id = '" . $productid . "'";
                    $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
                }
            }

            //////update product
            $query = "UPDATE product SET dish_type = '" . $arrUser['dish_id'] . "',is_sponsored = '" . $arrUser['is_sponsored'] . "',product_name = '" . $arrUser['product_name'] . "',product_info_page = '" . $arrUser['product_info_page'] . "', brand_name = '" . $arrUser['brand_name'] . "',preparation_Time = '" . $arrUser['preparation_Time'] . "',is_public = '" . $arrUser['is_public'] . "',product_description = '" . $arrUser['product_description'] . "',link = '" . $arrUser['link'] . "',start_of_publishing='" . $arrUser['start_of_publishing'] . "'  WHERE product_id = '" . $productid . "'";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

            if ($catImg <> '') {
                $query = "UPDATE product SET  small_image = '" . $catImg . "' WHERE product_id = '" . $productid . "'";
                $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
            }

            if ($_SESSION['preview']['large_image'] <> '') {
                $query = "UPDATE product SET  large_image = '" . $copImg . "' WHERE product_id = '" . $productid . "'";
                $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
            }

            //for keywords
            $query = "select lang_text.text,lang_text.id from product_keyword LEFT JOIN lang_text ON product_keyword.offer_keyword = lang_text.id  where product_keyword.product_id = '" . $productid . "' AND lang_text.lang = '" . $arrUser['language'] . "'";
            $res = mysqli_query($conn , $query) or die('1' . mysqli_error($conn));
            while ($rs = mysqli_fetch_array($res)) {
                $keyId = $rs['id'];
            }

            $query = "UPDATE lang_text SET `text` = '" . $arrUser['keywords'] . "'  WHERE id = '" . $keyId . "' AND  lang = '" . $arrUser['language'] . "' ";
            $res = mysqli_query($conn , $query) or die('3' . mysqli_error($conn));


            // for title slogen
            $query = "select lang_text.text,lang_text.id from product_offer_slogan_lang_list LEFT JOIN lang_text ON product_offer_slogan_lang_list.offer_slogan_lang_list = lang_text.id  where product_offer_slogan_lang_list.product_id = '" . $productid . "' AND lang_text.lang = '" . $arrUser['language'] . "'";
            $res = mysqli_query($conn , $query) or die('2' . mysqli_error($conn));
            while ($rs = mysqli_fetch_array($res)) {
                $titleId = $rs['id'];
            }
            $query = "UPDATE lang_text SET `text` = '" . $arrUser['offer_slogan_lang_list'] . "' WHERE id = '" . $titleId . "' AND  lang = '" . $arrUser['language'] . "'";
            $res = mysqli_query($conn , $query) or die('3' . mysqli_error($conn));

            ///////update c_s_rel
            $query = "UPDATE c_s_rel SET  start_of_publishing = '" . $arrUser['start_of_publishing'] . "'  WHERE product_id = '" . $productid . "'";
            $res = mysqli_query($conn , $query) or die('7' . mysqli_error($conn));
        }

        //////if start date less than or equal to current date///////////
        if ($arrUser['start_of_publishing'] <= $t) {

            ///////////update product
            $query = "UPDATE product SET dish_type = '" . $arrUser['dish_id'] . "',is_sponsored = '" . $arrUser['is_sponsored'] . "',product_name = '" . $arrUser['product_name'] . "',product_info_page = '" . $arrUser['product_info_page'] . "', preparation_Time = '" . $arrUser['preparation_Time'] . "',start_of_publishing = '" . $arrUser['start_of_publishing'] . "',is_public = '" . $arrUser['is_public'] . "',link = '" . $arrUser['link'] . "',start_of_publishing='" . $arrUser['start_of_publishing'] . "',product_description = '" . $arrUser['product_description'] . "',dish_type = '" . $arrUser['dish_id'] . "'  WHERE product_id = '" . $productid . "'";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

            if ($catImg <> '') {
                $query = "UPDATE product SET  small_image = '" . $catImg . "' WHERE product_id = '" . $productid . "'";
                $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
            }

            if ($_SESSION['preview']['large_image'] <> '') {
                //rename(UPLOAD_DIR . "coupon/" . $_SESSION['preview']['large_image'], UPLOAD_DIR . "coupon/" . substr($_SESSION['preview']['large_image'], 5));


                $query = "UPDATE product SET  large_image = '" . $copImg . "' WHERE product_id = '" . $productid . "'";
                $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
            }

            //for keywords
            $query = "select lang_text.text,lang_text.id from product_keyword LEFT JOIN lang_text ON product_keyword.offer_keyword = lang_text.id  where product_keyword.product_id = '" . $productid . "' AND lang_text.lang = '" . $arrUser['language'] . "'";
                        
            $res = mysqli_query($conn , $query) or die('1' . mysqli_error($conn));
            while ($rs = mysqli_fetch_array($res)) {
                $keyId = $rs['id'];
            }

            if($keyId == '' && $arrUser['keywords'] != ''){  
                $keywordId = uuid();
                $_SQL = "insert into lang_text(id,lang,text) values('" . $keywordId . "','" . $arrUser['language'] . "','" . $arrUser['keywords'] . "')";
                $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

                $_SQL = "insert into product_keyword(`product_id`,`offer_keyword`) values('" . $productid . "','" . $keywordId . "')";
                $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
            }else{
                $query = "UPDATE lang_text SET `text` = '" . $arrUser['keywords'] . "'  WHERE id = '" . $keyId . "' AND  lang = '" . $arrUser['language'] . "' ";
                $res = mysqli_query($conn , $query) or die('3' . mysqli_error($conn));
            }

            // for title slogen
            $query = "select lang_text.text,lang_text.id from product_offer_slogan_lang_list LEFT JOIN lang_text ON product_offer_slogan_lang_list.offer_slogan_lang_list = lang_text.id  where product_offer_slogan_lang_list.product_id = '" . $productid . "' AND lang_text.lang = '" . $arrUser['language'] . "'";
            $res = mysqli_query($conn , $query) or die('2' . mysqli_error($conn));
            while ($rs = mysqli_fetch_array($res)) {
                $titleId = $rs['id'];
            }
            $query = "UPDATE lang_text SET `text` = '" . $arrUser['offer_slogan_lang_list'] . "' WHERE id = '" . $titleId . "' AND  lang = '" . $arrUser['language'] . "'";
            $res = mysqli_query($conn , $query) or die('3' . mysqli_error($conn));

            //////////////update c_s_rel/////////////
            $query = "UPDATE c_s_rel SET  start_of_publishing = '" . $arrUser['start_of_publishing'] . "' WHERE product_id = '" . $productid . "'";
            $res = mysqli_query($conn , $query) or die('7' . mysqli_error($conn));

            //////////////update coupon/////////////
            $query = "select * from c_s_rel  where product_id = '" . $productid . "'";
            $res2 = mysqli_query($conn , $query) or die(mysqli_error($conn));
            while ($rs = mysqli_fetch_array($res2)) {
                $couponId = $rs['coupon_id'];


                if ($couponId) {
                    $query = "UPDATE coupon SET category = '" . $arrUser['category'] . "',is_sponsored = '" . $arrUser['spons'] . "', valid_from = '" . $arrUser['start_of_publishing'] . "', product_info_link = '" . $arrUser['product_info_page'] . "'  WHERE coupon_id = '" . $couponId . "'";
                    $res = mysqli_query($conn , $query) or die('2' . mysqli_error($conn));

                    if ($icon <> '' || $category_image <> '') {
                        $query = "UPDATE coupon SET  `small_image` = '" . $catImg . "' WHERE coupon_id= '" . $couponId . "'";
                        $res = mysqli_query($conn , $query) or die('6' . mysqli_error($conn));
                    }

                    if ($_SESSION['preview']['large_image'] <> '') {
                        $query = "UPDATE coupon SET  large_image = '" . $copImg . "' WHERE coupon_id = '" . $couponId . "'";
                        $res = mysqli_query($conn , $query) or die('7' . mysqli_error($conn));
                    }

                    //for keywords
                    $query = "select lang_text.text,lang_text.id from coupon_keywords_lang_list LEFT JOIN lang_text ON coupon_keywords_lang_list.keywords_lang_list = lang_text.id  where coupon_keywords_lang_list.coupon = '" . $couponId . "' AND lang_text.lang = '" . $arrUser['language'] . "'";
                    $res = mysqli_query($conn , $query) or die('1' . mysqli_error($conn));
                    while ($rs = mysqli_fetch_array($res)) {
                        $keyId = $rs['id'];
                    }

                    $query = "UPDATE lang_text SET `text` = '" . $arrUser['keywords'] . "'  WHERE id = '" . $keyId . "' AND  lang = '" . $arrUser['language'] . "' ";
                    $res = mysqli_query($conn , $query) or die('3' . mysqli_error($conn));

                    // for title slogen
                    $query = "select lang_text.text,lang_text.id from coupon_offer_title_lang_list LEFT JOIN lang_text ON coupon_offer_title_lang_list.offer_title_lang_list = lang_text.id  where coupon_offer_title_lang_list.coupon = '" . $couponId . "' AND lang_text.lang = '" . $arrUser['language'] . "'";
                    $res = mysqli_query($conn , $query) or die('2' . mysqli_error($conn));
                    while ($rs = mysqli_fetch_array($res)) {
                        $titleId = $rs['id'];
                    }
                    $query = "UPDATE lang_text SET `text` = '" . $arrUser['offer_slogan_lang_list'] . "' WHERE id = '" . $titleId . "' AND  lang = '" . $arrUser['language'] . "'";
                    $res = mysqli_query($conn , $query) or die('3' . mysqli_error($conn));
                }
            }
        }

        if ($reseller == '') {
            $url = BASE_URL . 'showStandard.php';
            $inoutObj->reDirect($url);
            exit();
        } else {
            $url = BASE_URL . 'showResellerStandard.php';
            $inoutObj->reDirect($url);
            exit();
        }
    }