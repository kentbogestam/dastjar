<?php

/*  File Name : addCompany.php
 *  Description : Add Company Form
 *  Author  :Himanshu Singh  Date: 23rd,Nov,2010  Creation
 */
header('Content-Type: text/html; charset=utf-8');

require_once('lib/resizer/resizer.php');

class offer extends advertiseoffer{
    /* Function Header :svrOfferDflt()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: User Campaign Offer default function
     */

//    exit("<pre>".$_REQUEST['m']."</pre>");
    function svrOfferDflt($paging_limit='0 , 10') {

        if (isset($_REQUEST['m']) && $_REQUEST['m'] != '') {
            $mode = $_REQUEST['m'];
        } else {
            $mode = '';
        }

        switch ($mode) {
            case 'saveoffer':
                $this->saveCampaignOffersDetails();
                break;

            case 'saveNewOffer':
                $reseller = $_REQUEST['reseller'];
                $this->saveNewCampaignOffersDetails($reseller);
                break;

            case 'saveStandard':
                $reseller = $_REQUEST['reseller'];
                $this->saveStandardOffersDetails($reseller);
                break;

            case 'saveNewStandard':
                $this->saveNewStandardOffersDetails();
                break;

            case 'showStandoffer':
                return $this->showStandardOffersDetails($paging_limit);
                break;

            case 'editSaveStandard':
                return $this->editSaveStandard($productid);
                break;

            case 'editSaveCampaign':
                return $this->editSaveCampaign($campaignid);
                break;

            case 'deleteCampaign':
                $this->deleteCampaign();
                break;

            case 'deleteOutdatedCampaign':
                return $this->deleteOutdatedCampaign();
                break;

            case 'showDeleteCampaign':
                return $this->showDeleteCampaign($paging_limit);
                break;

            case 'showcampoffer':
                return $this->showcampoffer($paging_limit);
                break;

            case 'deleteStandardOffer':
                $this->deleteStandardOffer();
                break;

            case 'checkBudget':
                $this->checkBudgetDetails();
                break;

            case 'saveNewCoupon':
                $this->saveNewCouponDetails();
                break;

            case 'saveNewCouponRetailer':
                $this->saveNewCouponDetailsRetailer();
                break;

            case 'saveNewCouponStandard':
                $this->saveNewCouponStandardDetails();
                break;
            case 'saveNewCouponStandDetails':
                $this->saveNewCouponStandDetails();
                break;

// Line Added  for Advertise
            case 'saveAdvertiseoffer':
                $this->saveAdvertiseOffersDetails();
                break; 
            
            
       case 'saveNewAdvertise':
        $reseller = $_REQUEST['reseller'];
                $this->saveNewAdvertiseOffersDetails($reseller);
                break;              

           case 'deleteAdvertise':                
                $this->deleteAdvertise();
                break; 
            
            case 'showDeleteAdvertise':
                return $this->showDeleteAdvertise($paging_limit);
                break;
            
            
           case 'editSaveAdvertise':
                return $this->editSaveAdvertise($advertiseid);
                break;          

            case 'deleteOutdatedAdvertise':
                return $this->deleteOutdatedAdvertise();
                break;

        
            case 'showadvtoffer':
                return $this->showadvtoffer($paging_limit);
                break;


            default:
                return $this->showCampaignOffersresellerDetails($paging_limit);
                break;
        }
    }

    /* Function Header :saveCampaignOffersDetails()
     *             Args: $emailId
     *           Errors: none
     *     Return Value: none
     *      Description: To save all the details related to the Campaign Offer in the database.
     */

    function saveCampaignOffersDetails($reseller= '') {
        //print_r($_POST); die();
        $inoutObj = new inOut();
        //$_SESSION['campaign_for_edit'] = serialize($_POST);
        $db = new db();
        $arrUser = array();
        $error = '';
        $preview = $_POST['preview'];
        //Store post data in array //
        $arrUser['offer_slogan_lang_list'] = addslashes($_POST['titleSlogan']);
        $arrUser['offer_sub_slogan_lang_list'] = addslashes($_POST['subSlogan']);
        if ($_POST['icon'] == "") {
            $arrUser['small_image'] = $_POST['category_image'];
        } else {
            $arrUser['small_image'] = $_POST['icon'];
        }
        //$arrUser['brand_name'] = $_POST['brandName'];
        $arrUser['spons'] = $_POST['sponsor'];
        $arrUser['category'] = $_POST['linkedCat'];
        $arrUser['start_of_publishing'] = $_POST['startDate'];
        $arrUser['end_of_publishing'] = $_POST['endDate'];
        $arrUser['campaign_name'] = addslashes($_POST['campaignName']);
        $arrUser['keywords'] = addslashes($_POST['searchKeyword']);
        $arrUser['discountValue'] = addslashes($_POST['discountValue']);
        
        $arrUser['start_time'] = $_POST['startDateLimitation'];
        $arrUser['end_time'] = $_POST['endDateLimitation'];
        $arrUser['valid_day'] = $_POST['limitDays'];
        $arrUser['large_image'] = $_POST['picture'];
        $arrUser['infopage'] = $_POST['descriptive'];
        $arrUser['codes'] = $_POST['codes'];
        // $arrUser['ccode'] = $_POST['ccode'];

        if ($arrUser['codes'] == '') {
            $arrUser['etanCode'] = '';
        } else {
              if($_POST['pinCode']!='')
            {
            $arrUser['etanCode'] = $_POST['pinCode'];
            }
             if($_POST['etanCode']!='')
             {
            $arrUser['etanCode'] = $_POST['etanCode'];
             }
        }

        // string matching
        if ($arrUser['infopage']) {
            $filestring = $arrUser['infopage'];
            $findme = 'http://';
            $pos = strpos($filestring, $findme);
            if ($pos === false) {
                $arrUser['infopage'] = 'http://' . $filestring;
            } else {
                $arrUser['infopage'] = $filestring;
            }
        }
        $arrUser['lang'] = $_POST['lang'];


        // Server side validation //
        $error.= ( $arrUser['offer_slogan_lang_list'] == '') ? ERROR_TITLE_SLOGAN : '';

        $error.= ( $arrUser['offer_sub_slogan_lang_list'] == '') ? ERROR_SUB_SLOGAN : '';

        //$error.= ( $arrUser['brand_name'] == '') ? ERROR_BRANDNAME : '';

        $error.= ( $arrUser['spons'] == '') ? ERROR_SPONSORS : '';

        $error.= ( $arrUser['category'] == '') ? ERROR_CATEGORY : '';

//      $error.= ( $arrUser['start_of_publishing'] == '') ? ERROR_START_OF_PUBLISHING : '';
//
//      $error.= ( $arrUser['end_of_publishing'] == '') ? ERROR_END_OF_PUBLISHING : '';

        $error.= ( $arrUser['campaign_name'] == '') ? ERROR_CAMPAIGN_NAME : '';
        $error.= ( $arrUser['discountValue'] == '') ? ERROR_DISCOUNT_VALUE : '';

        $_SESSION['post'] = "";
        
        // Upload category icon file////
        $CategoryIconName = "cat_icon_" . md5(time());
        $info = pathinfo($_FILES["icon"]["name"]);
        //echo $info;

        if (!empty($_FILES["icon"]["name"])) {
            if (!empty($_FILES["icon"]["name"])) {

                if (strtolower($info['extension']) == "png") {
                    if ($_FILES["icon"]["error"] > 0) {
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
            $category_image = $_POST["category_image"];
            if (!empty($category_image)) {

                $categoryImageName = explode(".", $category_image);
                $cat_filename = $CategoryIconName . "." . $categoryImageName[1];
                $fileOriginal = UPLOAD_DIR . "category_lib/" . $category_image;
                $path = UPLOAD_DIR . "category/";
                $fileThumbnail = $path . $cat_filename;
                copy($fileOriginal, $fileThumbnail);
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

        //// Upload Coupen image//////
        $coupenName = "cpn_" . md5(time());
        $info = pathinfo($_FILES["picture"]["name"]);

        if (!empty($_FILES["picture"]["name"])) {

            if (strtolower($info['extension']) == "jpg" || strtolower($info['extension']) == "png" || strtolower($info['extension']) == "jpeg" || $file_extension == "gif" || $file_extension == "bmp") {
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
                }
            } else {
                $error.=NOT_VALID_EXT;
            }
        } else {
            if ($_SESSION['preview']['large_image'] != "") {
                $arrUser['large_image'] = $_SESSION['preview']['large_image'];
            } elseif ($_POST['largeimage'] == "") {
                $error.=ERROR_LARGE_STANDARD_IMAGE;
            } else {
                //$arrUser['large_image'] = $_POST['largeimage'];

                if ($_SESSION['preview']['large_image'] != "") {
                    $arrUser['large_image'] = $_SESSION['preview']['large_image'];
                } elseif ($_POST['largeimage'] == "") {
                    $error.= ERROR_SMALL_IMAGE;
                } else {
                    $arrUser['large_image'] = $_POST['largeimage'];
                }
            }
        }

/////////////////////////// upload largeimages into server///////////////////
        $file2 = _UPLOAD_IMAGE_ . 'coupon/' . $arrUser['large_image'];
        $dir2 = "coupon";
        $command2 = IMAGE_DIR_PATH . $file2 . " " . $dir2;
        system($command2);
        // die();


        if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            if ($reseller == '') {
                $url = BASE_URL . 'campaignOffer.php';
                $inoutObj->reDirect($url);
                exit();
            } else {
                $url = BASE_URL . 'campaignResellerOffer.php';
                $inoutObj->reDirect($url);
                exit();
            }
        }

        $catImg = IMAGE_AMAZON_PATH . 'category/' . $arrUser['small_image'];
        $copImg = IMAGE_AMAZON_PATH . 'coupon/' . $arrUser['large_image'];
        $campaignId = uuid();
        /// Select company id of this user
        $QUE = "select company_id from company where u_id='" . $_SESSION['userid'] . "'";
        $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
        $row = mysql_fetch_array($res);
        $companyId = $row['company_id'];

        $catImg = _UPLOAD_URLDIR_ . "category/" . $arrUser['small_image'];
        $cpnImg = _UPLOAD_URLDIR_ . "coupon/" . $arrUser['large_image'];

        $arrUser['u_id'] = $_SESSION['userid'];
        $query = "INSERT INTO campaign(`campaign_id`,`company_id`,`u_id`, `small_image`,`large_image`, `spons`, `category`, `start_of_publishing`,`end_of_publishing`,`campaign_name`,`view_opt`,`infopage`,`code`,`code_type`,`value`)
                VALUES ('" . $campaignId . "','" . $companyId . "','" . $_SESSION['userid'] . "', '" . $catImg . "', '" . $copImg . "','" . $arrUser['spons'] . "','" . $arrUser['category'] . "','" . $arrUser['start_of_publishing'] . "','" . $arrUser['end_of_publishing'] . "','" . $arrUser['campaign_name'] . "','" . $arrUser['viewopt'] . "','" . $arrUser['infopage'] . "','" . $arrUser['etanCode'] . "','" . $arrUser['codes'] . "','".$arrUser['discountValue']."');";
        $res = mysql_query($query) or die("Inset campaign : " . mysqli_error($conn));

        if ($arrUser['codes'] == '') {
            $query = "update campaign set `code` = NULL,`code_type` = NULL where campaign_id = '" . $campaignId . "'";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        }

        if ($reseller != '') {
            $query = "UPDATE campaign SET `reseller_status` = 'P' WHERE campaign_id = '" . $campaignId . "'";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        }

        ////////Slogan entry///////
        $sloganLangId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $sloganLangId . "','" . $arrUser['lang'] . "','" . $arrUser['offer_slogan_lang_list'] . "')";
        $res = mysqli_query($conn , $_SQL) or die("title slogan in lang_text : " . mysqli_error($conn));

        ////////Sub Slogen entry///////
        $subSloganLangId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $subSloganLangId . "','" . $arrUser['lang'] . "','" . $arrUser['offer_sub_slogan_lang_list'] . "')";
        $res = mysqli_query($conn , $_SQL) or die("sub slogan in lang_text : " . mysqli_error($conn));

        ////////Sub Slogen entry///////
        $keywordId = uuid();
         if(trim($arrUser['keywords']) != "")
         {
        $_SQL = "insert into lang_text(id,lang,text) values('" . $keywordId . "','" . $arrUser['lang'] . "','" . $arrUser['keywords'] . "')";
        $res = mysqli_query($conn , $_SQL) or die("sub slogan in lang_text : " . mysqli_error($conn));

        
          $_SQL = "insert into campaign_keyword(`campaign_id`,`offer_keyword`) values('" . $campaignId . "','" . $keywordId . "')";
        $res = mysqli_query($conn , $_SQL) or die("keyword in relational table : " . mysqli_error($conn));
         }
         
         
 
         
         $SystemkeyId = uuid();
         $_SQL = "insert into lang_text(id,lang,text) values('" . $SystemkeyId . "','" . $arrUser['lang'] . "','" . $campaignId . "')";
         $res = mysqli_query($conn , $_SQL) or die("sub slogan in lang_text : " . mysqli_error($conn));


         $_SQL = "insert into campaign_keyword(`campaign_id`,`system_key`) values('" . $campaignId . "','" . $SystemkeyId . "')";
         $res = mysqli_query($conn , $_SQL) or die("keyword in relational table : " . mysqli_error($conn));
         
         
          $Systemkey_companyId = uuid();
         $_SQL = "insert into lang_text(id,lang,text) values('" . $Systemkey_companyId . "','" . $arrUser['lang'] . "','" . $companyId . "')";
         $res = mysqli_query($conn , $_SQL) or die("sub slogan in lang_text : " . mysqli_error($conn));


         $_SQL = "insert into campaign_keyword(`campaign_id`,`system_key`) values('" . $campaignId . "','" . $Systemkey_companyId . "')";
         $res = mysqli_query($conn , $_SQL) or die("keyword in relational table : " . mysqli_error($conn));
         
         
         
         
         
         
        ///Slogan and language table relation entry ///
        $_SQL = "insert into campaign_offer_slogan_lang_list(`campaign_id`,`offer_slogan_lang_list`) values('" . $campaignId . "','" . $sloganLangId . "')";
        $res = mysqli_query($conn , $_SQL) or die("Tital slogan id in relational table : " . mysqli_error($conn));


        ///Sub slogan and language table relation entry ///
        $_SQL = "insert into campaign_offer_sub_slogan_lang_list(`campaign_id`,`offer_sub_slogan_lang_list`) values('" . $campaignId . "','" . $subSloganLangId . "')";
        $res = mysqli_query($conn , $_SQL) or die("Sub slogan id in relational table : " . mysqli_error($conn));

        if ($arrUser['valid_day'] != '') {
///Start date and End Date and Valid days entry ///
            $limitId = uuid();
            $_SQL = "insert into limit_period(`limit_id`,`end_time`,`start_time`,`valid_day`) values('" . $limitId . "','" . $arrUser['end_time'] . "','" . $arrUser['start_time'] . "','" . $arrUser['valid_day'] . "')";
            $res = mysqli_query($conn , $_SQL) or die("Insert limit period : " . mysqli_error($conn));

            ///RElation between LImit Period list and Coupon ///
            $_SQL = "insert into campaign_limit_period_list(`campaign_id`,`limit_period_list`) values('" . $campaignId . "','" . $limitId . "')";
            $res = mysqli_query($conn , $_SQL) or die("limit id in relational table : " . mysqli_error($conn));
        }

        $query = "UPDATE user SET activ='3' WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res = mysqli_query($conn , $query) or die("Update user for status : " . mysqli_error($conn));


        $_SESSION['preview'] = "";
        $_POST = "";
        $_SESSION['MESSAGE'] = CAMPAIGN_OFFER_SUCCESS;
        $_SESSION['REG_STEP'] = 3;
        $_SESSION['active_state'] = 3;
        if ($reseller == '') {
            $url = BASE_URL . 'registrationStep.php';
            $inoutObj->reDirect($url);
            exit();
        } else {
            $url = BASE_URL . 'registrationResellerStep.php';
            $inoutObj->reDirect($url);
            exit();
        }
    }

    /* Function Header :saveNewCampaignOffersDetails()
     *             Args: $emailId
     *           Errors: none
     *     Return Value: none
     *      Description: To save all the details related to the Campaign Offer in the database.
     */

    /*    function saveNewCampaignOffersDetails() {

      //print_r($_POST); die();
      $inoutObj = new inOut();
      $db = new db();
      $arrUser = array();
      $error = '';



      $preview = $_POST['preview'];
      //Store post data in array //
      $arrUser['offer_slogan_lang_list'] = $_POST['titleSlogan'];
      $arrUser['offer_sub_slogan_lang_list'] = $_POST['subSlogan'];
      if ($_POST['icon'] == "") {
      $arrUser['small_image'] = $_POST['category_image'];
      } else {
      $arrUser['small_image'] = $_POST['icon'];
      }

      $arrUser['spons'] = $_POST['sponsor'];
      $arrUser['category'] = $_POST['linkedCat'];
      $arrUser['start_of_publishing'] = $_POST['startDate'];
      $arrUser['end_of_publishing'] = $_POST['endDate'];
      $arrUser['campaign_name'] = $_POST['campaignName'];
      $arrUser['keywords'] = $_POST['searchKeyword'];
      $arrUser['start_time'] = $_POST['startDateLimitation'];
      $arrUser['end_time'] = $_POST['endDateLimitation'];
      $arrUser['valid_day'] = $_POST['limitDays'];
      $arrUser['large_image'] = $_POST['picture'];
      $arrUser['infopage'] = $_POST['descriptive'];
      $arrUser['lang'] = $_POST['lang'];


      // Server side validation //
      $error.= ( $arrUser['offer_slogan_lang_list'] == '') ? ERROR_TITLE_SLOGAN : '';

      $error.= ( $arrUser['offer_sub_slogan_lang_list'] == '') ? ERROR_SUB_SLOGAN : '';

      $error.= ( $arrUser['spons'] == '') ? ERROR_SPONSORS : '';

      $error.= ( $arrUser['category'] == '') ? ERROR_CATEGORY : '';

      $error.= ( $arrUser['start_of_publishing'] == '') ? ERROR_START_OF_PUBLISHING : '';

      $error.= ( $arrUser['end_of_publishing'] == '') ? ERROR_END_OF_PUBLISHING : '';

      $error.= ( $arrUser['campaign_name'] == '') ? ERROR_CAMPAIGN_NAME : '';

      $_SESSION['post'] = "";

      // Url kept in the session variable..
      $_SESSION['post'] = $_POST;
      $_SESSION['URL2']=$_SERVER['PHP_SELF'];

      $query = "SELECT pre_loaded_value FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
      $res = mysql_query($query) or die(mysql_error());
      $rs_comp = mysql_fetch_array($res);
      $rs_comp['pre_loaded_value'];
      if($rs_comp['pre_loaded_value']){
      //$_SESSION['userid'];
      $pre_loaded_value = $rs_comp['pre_loaded_value'];

      }
      else
      {
      $query = "SELECT pre_loaded_value FROM user as usr
      LEFT JOIN company as camp ON       (camp.company_id=usr.company_id)
      WHERE usr.u_id='" . $_SESSION['userid'] . "'";
      $res = mysql_query($query) or die(mysql_error());
      $rs_comp = mysql_fetch_array($res);
      $pre_loaded_value = $rs_comp['pre_loaded_value'];
      //$rs['new_pre_loaded_value'];
      }
      if($_POST['sponsor']==1) {
      if (($pre_loaded_value == '0' || $pre_loaded_value == null)) {
      $_SESSION['MESSAGE'] = CRADIT_YOUR_ACCOUNT;

      $url = BASE_URL . 'createCampaign.php';
      $inoutObj->reDirect($url);
      exit();

      }
      }




      $query = "SELECT pre_loaded_value FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
      $res = mysql_query($query) or die(mysql_error());
      $rs = mysql_fetch_array($res);
      $rs['pre_loaded_value'];
      //echo $_SESSION['userid'];
      if ($arrUser['is_sponsored'] == 1 && ($rs['pre_loaded_value'] == '0' || $rs['pre_loaded_value'] == null)) {
      $_SESSION['MESSAGE'] = INSUFFICIENT_BALANCE;
      }


      # Print_r($_POST); die();
      // Upload category icon file////
      $CategoryIconName = "cat_icon_" . time();
      $info = pathinfo($_FILES["icon"]["name"]);

      if (!empty($_FILES["icon"]["name"])) {
      //echo "Cat in"; die();
      if (!empty($_FILES["icon"]["name"])) {

      if (strtolower($info['extension']) == "png") {
      if ($_FILES["icon"]["error"] > 0) {
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
      //echo "End UPLOAD"; die();
      //// Upload Coupen image//////
      $coupenName = "cpn_" . time();
      $info = pathinfo($_FILES["picture"]["name"]);

      if (!empty($_FILES["picture"]["name"])) {

      if (strtolower($info['extension']) == "jpg" || strtolower($info['extension']) == "png") {
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
      }
      } else {
      $error.=NOT_VALID_EXT;
      }
      } else {
      if ($_SESSION['preview']['large_image'] != "") {
      $arrUser['large_image'] = $_SESSION['preview']['large_image'];
      } elseif ($_POST['largeimage'] == "") {
      $error.=ERROR_LARGE_STANDARD_IMAGE;
      } else {
      //$arrUser['large_image'] = $_POST['largeimage'];

      if ($_SESSION['preview']['large_image'] != "") {
      $arrUser['large_image'] = $_SESSION['preview']['large_image'];
      } elseif ($_POST['largeimage'] == "") {
      $error.= ERROR_SMALL_IMAGE;
      } else {
      $arrUser['large_image'] = $_POST['largeimage'];
      }
      }
      }

      //        echo "<pre>"; print_r($_POST);
      //         print_r($_FILES);
      //        echo "</pre>";
      //         return;
      //        echo $error;  die();
      if ($error != '') {
      $_SESSION['MESSAGE'] = $error;
      $_SESSION['post'] = $_POST;
      $url = BASE_URL . 'createCampaignOffer.php';
      $inoutObj->reDirect($url);
      exit();
      }

      // echo "dfsdfds--".$preview; die();
      ///////////TO show the preview ////////////


      if ($preview == 1) {
      $_SESSION['preview'] = $arrUser;
      $_SESSION['post'] = $_POST;
      $url = BASE_URL . 'newCampaignOfferPreview.php';
      $inoutObj->reDirect($url);
      exit();
      }


      $catImg = _UPLOAD_URLDIR_ . 'category/' . $arrUser['small_image'];
      $copImg = _UPLOAD_URLDIR_ . 'coupon/' . $arrUser['large_image'];
      $campaignId = uuid();
      /// Select company id of this user
      $QUE = "select company_id from company where u_id='" . $_SESSION['userid'] . "'";
      $res = mysql_query($QUE) or die(mysql_error());
      $row = mysql_fetch_array($res);
      $companyId = $row['company_id'];
      $query = "INSERT INTO campaign(`campaign_id`,`company_id`,`u_id`, `small_image`,`large_image`, `spons`, `category`, `start_of_publishing`,`end_of_publishing`,`campaign_name`,`keywords`,`infopage`)
      VALUES ('" . $campaignId . "','" . $companyId . "','" . $_SESSION['userid'] . "', '" . $catImg . "', '" . $copImg . "','" . $arrUser['spons'] . "','" . $arrUser['category'] . "','" . $arrUser['start_of_publishing'] . "','" . $arrUser['end_of_publishing'] . "','" . $arrUser['campaign_name'] . "','" . $arrUser['keywords'] . "','" . $arrUser['infopage'] . "');";
      $res = mysql_query($query) or die(mysql_error());
      ////////Slogen entry///////
      $sloganLangId = uuid();
      $_SQL = "insert into lang_text(id,lang,text) values('" . $sloganLangId . "','" . $arrUser['lang'] . "','" . $arrUser['offer_slogan_lang_list'] . "')";
      $res = mysql_query($_SQL) or die(mysql_error());
      //echo"here";die();
      ////////Sub Slogen entry///////
      $subSloganLangId = uuid();
      $_SQL = "insert into lang_text(id,lang,text) values('" . $subSloganLangId . "','" . $arrUser['lang'] . "','" . $arrUser['offer_sub_slogan_lang_list'] . "')";
      $res = mysql_query($_SQL) or die(mysql_error());


      /// SLogen anf language table relation entry ////
      $_SQL = "insert into campaign_offer_slogan_lang_list(`campaign_id`,`offer_slogan_lang_list`) values('" . $campaignId . "','" . $sloganLangId . "')";
      $res = mysql_query($_SQL) or die(mysql_error());

      ///Sub slogan and language table relation entry ///
      $_SQL = "insert into campaign_offer_sub_slogan_lang_list(`campaign_id`,`offer_sub_slogan_lang_list`) values('" . $campaignId . "','" . $subSloganLangId . "')";
      $res = mysql_query($_SQL) or die(mysql_error());

      ///Start date and End Date and Valid days entry ///

      //          echo $arrUser['start_time'];
      //         echo $arrUser['end_time'];
      //          echo $arrUser['valid_day'];
      //          die();
      if ($arrUser['valid_day']!='')
      {
      $limitId = uuid();
      $_SQL = "insert into limit_period(`limit_id`,`end_time`,`start_time`,`valid_day`) values('" . $limitId . "','" . $arrUser['end_time'] . "','" . $arrUser['start_time'] . "','" . $arrUser['valid_day'] . "')";
      $res = mysql_query($_SQL) or die(mysql_error());

      ///RElation between LImit Period list and Coupon ///
      $_SQL = "insert into campaign_limit_period_list(`campaign_id`,`limit_period_list`) values('" . $campaignId . "','" . $limitId . "')";
      $res = mysql_query($_SQL) or die(mysql_error());
      }


      $_SESSION['preview'] = "";
      $_SESSION['post'] = '';
      $_POST = "";
      $_SESSION['MESSAGE'] = CAMPAIGN_OFFER_SUCCESS;
      $url = BASE_URL . 'showCampaign.php';
      $inoutObj->reDirect($url);
      exit();

      }
     */

    function saveNewCampaignOffersDetails($reseller='') {

        //print_r($_POST); die();
        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $arrUser = array();
        $error = '';



        //$preview = $_POST['preview'];
        //Store post data in array //
        $arrUser['offer_slogan_lang_list'] = addslashes($_POST['titleSlogan']);
        $arrUser['offer_sub_slogan_lang_list'] = addslashes($_POST['subSlogan']);
        if ($_POST['icon'] == "") {
            $arrUser['small_image'] = $_POST['category_image'];
        } else {
            $arrUser['small_image'] = $_POST['icon'];
        }

        $arrUser['spons'] = $_POST['sponsor'];
        $arrUser['category'] = $_POST['linkedCat'];
        $arrUser['start_of_publishing'] = $_POST['startDate'];
        $arrUser['end_of_publishing'] = $_POST['endDate'];
        $arrUser['campaign_name'] = addslashes($_POST['campaignName']);
        $arrUser['keywords'] = addslashes($_POST['searchKeyword']);
        $arrUser['discountValue'] = addslashes($_POST['discountValue']);
        
        $arrUser['start_time'] = $_POST['startDateLimitation'];
        $arrUser['end_time'] = $_POST['endDateLimitation'];
        $arrUser['valid_day'] = $_POST['limitDays'];
        $arrUser['large_image'] = $_POST['picture'];
// new viewopt Kent
        $arrUser['viewopt'] = $_POST['viewopt'];
//  end new viewopt Kent
        $arrUser['infopage'] = $_POST['descriptive'];
        $arrUser['codes'] = $_POST['codes'];
        // $arrUser['ccode'] = $_POST['ccode'];

        if ($arrUser['codes'] == '') {
            $arrUser['etanCode'] = '';
        } else {
            if($_POST['pinCode']!='')
            {
            $arrUser['etanCode'] = $_POST['pinCode'];
            }
             if($_POST['etanCode']!='')
             {
            $arrUser['etanCode'] = $_POST['etanCode'];
             }
        }
       $arrUser['etanCode'];
        // string matching
        if ($arrUser['infopage']) {
            $filestring = $arrUser['infopage'];
            $findme = 'http://';
            $pos = strpos($filestring, $findme);
            if ($pos === false) {
                $arrUser['infopage'] = 'http://' . $filestring;
            } else {
                $arrUser['infopage'] = $filestring;
            }
        }
        $arrUser['lang'] = $_POST['lang'];


        // Server side validation //
        $error.= ( $arrUser['offer_slogan_lang_list'] == '') ? ERROR_TITLE_SLOGAN : '';

        $error.= ( $arrUser['offer_sub_slogan_lang_list'] == '') ? ERROR_SUB_SLOGAN : '';

        $error.= ( $arrUser['spons'] == '') ? ERROR_SPONSORS : '';

        $error.= ( $arrUser['category'] == '') ? ERROR_CATEGORY : '';

        $error.= ( $arrUser['start_of_publishing'] == '') ? ERROR_START_OF_PUBLISHING : '';

        $error.= ( $arrUser['end_of_publishing'] == '') ? ERROR_END_OF_PUBLISHING : '';

        $error.= ( $arrUser['campaign_name'] == '') ? ERROR_CAMPAIGN_NAME : '';

        $error.= ( $arrUser['discountValue'] == '') ? ERROR_DISCOUNT_VALUE : '';

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

            if ($_POST['sponsor'] == 1) {
                if (($pre_loaded_value == '0' || $pre_loaded_value == null)) {
                    $_SESSION['MESSAGE2'] = CRADIT_YOUR_ACCOUNT;


                    $url = BASE_URL . 'createCampaign.php';
                    $inoutObj->reDirect($url);
                    exit();
                }
            }


            $query = "SELECT pre_loaded_value FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
            $res = mysqli_query($conn , $query) or die(mysql_error());
            $rs = mysqli_fetch_array($res);
            $rs['pre_loaded_value'];
            if ($arrUser['is_sponsored'] == 1 && ($rs['pre_loaded_value'] == '0' || $rs['pre_loaded_value'] == null)) {
                $_SESSION['MESSAGE'] = INSUFFICIENT_BALANCE;
            }
        }

        # Print_r($_POST); die();
        // Upload category icon file////
        $CategoryIconName = "cat_icon_" . time();
        $info = pathinfo($_FILES["icon"]["name"]);

        if (!empty($_FILES["icon"]["name"])) {
            if (!empty($_FILES["icon"]["name"])) {
                if (strtolower($info['extension']) == "png") {
                    if ($_FILES["icon"]["error"] > 0) {
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
        $coupenName = "cpn_" . time();
        $info = pathinfo($_FILES["picture"]["name"]);

        if (!empty($_FILES["picture"]["name"])) {

            if (strtolower($info['extension']) == "jpg" || strtolower($info['extension']) == "png" || strtolower($info['extension']) == "jpeg" || $file_extension == "gif" || $file_extension == "bmp") {
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
                }
            } else {
                $error.=NOT_VALID_EXT;
            }
        } else {
            if ($_SESSION['preview']['large_image'] != "") {
                $arrUser['large_image'] = $_SESSION['preview']['large_image'];
            } elseif ($_POST['largeimage'] == "") {
                $error.=ERROR_LARGE_STANDARD_IMAGE;
            } else {
                //$arrUser['large_image'] = $_POST['largeimage'];

                if ($_SESSION['preview']['large_image'] != "") {
                    $arrUser['large_image'] = $_SESSION['preview']['large_image'];
                } elseif ($_POST['largeimage'] == "") {
                    $error.= ERROR_SMALL_IMAGE;
                } else {
                    $arrUser['large_image'] = $_POST['largeimage'];
                }
            }
        }

        /////////////////////////// upload largeimages into server///////////////////
        $file2 = _UPLOAD_IMAGE_ . 'coupon/' . $arrUser['large_image'];
        $dir2 = "coupon";
        $command2 = IMAGE_DIR_PATH . $file2 . " " . $dir2;
        system($command2);


        if ($error != '') {
            if ($reseller == '') {
                $_SESSION['MESSAGE'] = $error;
                $_SESSION['post'] = $_POST;
                $url = BASE_URL . 'createCampaign.php';
                $inoutObj->reDirect($url);
                exit();
            } else {
                $_SESSION['MESSAGE'] = $error;
                $_SESSION['post'] = $_POST;
                $url = BASE_URL . 'createResellerCampaign.php';
                $inoutObj->reDirect($url);
                exit();
            }
        }


        // echo "dfsdfds--".$preview; die();
        ///////////TO show the preview ////////////

        $catImg = IMAGE_AMAZON_PATH . 'category/' . $arrUser['small_image'];
        $copImg = IMAGE_AMAZON_PATH . 'coupon/' . $arrUser['large_image'];
        $campaignId = uuid();
        /// Select company id of this user
        $QUE = "select company_id from company where u_id='" . $_SESSION['userid'] . "'";
        $res = mysqli_query($conn , $QUE) or die(mysql_error());
        $row = mysqli_fetch_array($res);
        $companyId = $row['company_id'];

        if ($companyId == '') {
            $QUE33 = "select company_id from employer where u_id='" . $_SESSION['userid'] . "'";
            $res33 = mysqli_query($conn , $QUE33) or die(mysql_error());
            $rs33 = mysqli_fetch_array($res33);
            $empCompId = $rs33['company_id'];
            $companyId = $empCompId;
        }

// New viewopt Kent
        $query = "INSERT INTO campaign(`campaign_id`,`company_id`,`u_id`, `small_image`,`large_image`, `spons`, `category`, `start_of_publishing`,`end_of_publishing`,`campaign_name`, `view_opt`,`infopage`,`code`,`code_type`,`value`)
                VALUES ('" . $campaignId . "','" . $companyId . "','" . $_SESSION['userid'] . "', '" . $catImg . "', '" . $copImg . "','" . $arrUser['spons'] . "','" . $arrUser['category'] . "','" . $arrUser['start_of_publishing'] . "','" . $arrUser['end_of_publishing'] . "','" . $arrUser['campaign_name']  . "','" . $arrUser['viewopt'] . "','" . $arrUser['infopage'] . "','" . $arrUser['etanCode'] . "','" . $arrUser['codes'] . "','".$arrUser['discountValue']."');";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
// End  New viewopt Kent

        if ($arrUser['codes'] == '') {
            $query = "update campaign set `code` = NULL,`code_type` = NULL where campaign_id = '" . $campaignId . "'";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        }


        if ($reseller != '') {
            $query = "UPDATE campaign SET `reseller_status` = 'P' WHERE campaign_id = '" . $campaignId . "'";
            $res = mysqli_query($conn , $query);
        }

        ////////Slogen entry///////
        $sloganLangId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $sloganLangId . "','" . $arrUser['lang'] . "','" . $arrUser['offer_slogan_lang_list'] . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
        ////////Sub Slogen entry///////
        $subSloganLangId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $subSloganLangId . "','" . $arrUser['lang'] . "','" . $arrUser['offer_sub_slogan_lang_list'] . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

        //////keywords
        $keywordId = uuid();
         if(trim($arrUser['keywords']) != "")
         {
        $_SQL = "insert into lang_text(id,lang,text) values('" . $keywordId . "','" . $arrUser['lang'] . "','" . $arrUser['keywords'] . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

             ///keyword
            $_SQL = "insert into campaign_keyword(`campaign_id`,`offer_keyword`) values('" . $campaignId . "','" . $keywordId . "')";
            $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
         }
         
         
         $SystemkeyId = uuid();
         $_SQL = "insert into lang_text(id,lang,text) values('" . $SystemkeyId . "','" . $arrUser['lang'] . "','" . $campaignId . "')";
         $res = mysqli_query($conn , $_SQL) or die("sub slogan in lang_text : " . mysqli_error($conn));


         $_SQL = "insert into campaign_keyword(`campaign_id`,`system_key`) values('" . $campaignId . "','" . $SystemkeyId . "')";
         echo $_SQL;
         $res = mysqli_query($conn , $_SQL) or die("keyword in relational table : " . mysqli_error($conn));
         
         
         
         
         $Systemkey_companyId = uuid();
         $_SQL = "insert into lang_text(id,lang,text) values('" . $Systemkey_companyId . "','" . $arrUser['lang'] . "','" . $companyId . "')";
         $res = mysqli_query($conn , $_SQL) or die("sub slogan in lang_text : " . mysqli_error($conn));


         $_SQL = "insert into campaign_keyword(`campaign_id`,`system_key`) values('" . $campaignId . "','" . $Systemkey_companyId . "')";
         $res = mysqli_query($conn , $_SQL) or die("keyword in relational table : " . mysql_error());
         
         
        /// SLogen anf language table relation entry ////
        $_SQL = "insert into campaign_offer_slogan_lang_list(`campaign_id`,`offer_slogan_lang_list`) values('" . $campaignId . "','" . $sloganLangId . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysql_error());

        ///Sub slogan and language table relation entry ///
        $_SQL = "insert into campaign_offer_sub_slogan_lang_list(`campaign_id`,`offer_sub_slogan_lang_list`) values('" . $campaignId . "','" . $subSloganLangId . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysql_error());


        ///Start date and End Date and Valid days entry ///
        if ($arrUser['valid_day'] != '') {
            $limitId = uuid();
            $_SQL = "insert into limit_period(`limit_id`,`end_time`,`start_time`,`valid_day`) values('" . $limitId . "','" . $arrUser['end_time'] . "','" . $arrUser['start_time'] . "','" . $arrUser['valid_day'] . "')";
            $res = mysqli_query($conn , $_SQL) or die(mysql_error());

            ///RElation between LImit Period list and Coupon ///
            $_SQL = "insert into campaign_limit_period_list(`campaign_id`,`limit_period_list`) values('" . $campaignId . "','" . $limitId . "')";
            $res = mysqli_query($conn , $_SQL) or die(mysql_error());
        }


        $_SESSION['preview'] = "";
        $_SESSION['post'] = '';
        $_POST = "";
        $_SESSION['askforstore'] = 1;

        $_SESSION['MESSAGE'] = CAMPAIGN_OFFER_SUCCESS . $custom_msg;
        if ($reseller == '') {
            $url = BASE_URL . 'showCampaign.php?campId=' . $campaignId;
            $inoutObj->reDirect($url);
            exit();
        } else {
            $url = BASE_URL . 'showResellerCampaign.php?campId=' . $campaignId;
            $inoutObj->reDirect($url);
            exit();
        }
    }

    /* Function Header :saveStandardOffersDetails()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: Save the Standard offer detils i the product table with the relationship of language table and and relationship talble
     */

    function saveStandardOffersDetails($reseller='') {
        //print_r($_POST); die();
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $error = '';
        $preview = $_POST['preview'];
        $arrUser['offer_slogan_lang_list'] = addslashes($_POST['titleSloganStand']);
        if ($_POST['icon'] == "") {
            $arrUser['small_image'] = $_POST['category_image'];
        } else {
            $arrUser['small_image'] = $_POST['icon'];
        }
        $arrUser['is_sponsored'] = $_POST['sponsStand'];
        $arrUser['category'] = $_POST['linkedCatStand'];
        $arrUser['link'] = $_POST['link'];
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
        $arrUser['large_image'] = $_POST['picture'];
        //$arrUser['product_info_page'] = $_POST['descriptiveStand'];
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
        $arrUser['product_name'] = addslashes($_POST['productName']);
        $arrUser['ean_code'] = $_POST['eanCode'];
        $arrUser['is_public'] = $_POST['publicProduct'];
        $arrUser['product_number'] = $_POST['productNumber'];
        $arrUser['start_of_publishing'] = $_POST['startDateStand'];
        $arrUser['lang'] = $_POST['lang'];


        $error.= ( $arrUser['offer_slogan_lang_list'] == '') ? ERROR_TITLE_SLOGAN : '';
        $error.= ( $arrUser['is_sponsored'] == '') ? ERROR_STANDARD_SPONSORED : '';
        $error.= ( $arrUser['category'] == '') ? ERROR_STANDARD_CATEGORY : '';


        //// Upload category icon file//////
        $CategoryIconName = "cat_icon_" . md5(time());
        $info = pathinfo($_FILES["icon"]["name"]);
        if (!empty($_FILES["icon"]["name"])) {
            if (!empty($_FILES["icon"]["name"])) {

                if (strtolower($info['extension']) == "png") {
                    if ($_FILES["icon"]["error"] > 0) {
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


        $coupenName = "cpn_" . md5(time());
        $info = pathinfo($_FILES["picture"]["name"]);

        if (!empty($_FILES["picture"]["name"])) {

            if (strtolower($info['extension']) == "jpg" || strtolower($info['extension']) == "png" || strtolower($info['extension']) == "jpeg" || $file_extension == "gif" || $file_extension == "bmp") {
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
                }
            } else {
                $error.=NOT_VALID_EXT;
            }
        } else {
            if ($_SESSION['preview']['large_image'] != "") {
                $arrUser['large_image'] = $_SESSION['preview']['large_image'];
            } elseif ($_POST['largeimage'] == "") {
                $error.=ERROR_LARGE_STANDARD_IMAGE;
            } else {
                //$arrUser['large_image'] = $_POST['largeimage'];

                if ($_SESSION['preview']['large_image'] != "") {
                    $arrUser['large_image'] = $_SESSION['preview']['large_image'];
                } elseif ($_POST['largeimage'] == "") {
                    $error.= ERROR_SMALL_IMAGE;
                } else {
                    $arrUser['large_image'] = $_POST['largeimage'];
                }
            }
        }

        /////////////////////////// upload largeimages into server///////////////////
        $file2 = _UPLOAD_IMAGE_ . 'coupon/' . $arrUser['large_image'];
        $dir2 = "coupon";
        $command2 = IMAGE_DIR_PATH . $file2 . " " . $dir2;
        system($command2);


        if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            if ($reseller == '') {
                $url = BASE_URL . 'standardOffer.php';

                $inoutObj->reDirect($url);
                exit();
            } else {
                $url = BASE_URL . 'standardResellerOffer.php';

                $inoutObj->reDirect($url);
                exit();
            }
        } else {
            $_SESSION['post'] = "";
        }

        $catImg = IMAGE_AMAZON_PATH . 'category/' . $arrUser['small_image'];
        $copImg = IMAGE_AMAZON_PATH . 'coupon/' . $arrUser['large_image'];

        $standUniqueId = uuid();
        /// Select company id of this user
        $QUE = "select company_id from company where u_id='" . $_SESSION['userid'] . "'";
        $res = mysql_query($QUE) or die(mysql_error());
        $row = mysql_fetch_array($res);
        $companyId = $row['company_id'];
        $query = "INSERT INTO product(`product_id`,`u_id`,`company_id`, `small_image`,`product_name`,`is_sponsored`, `category`,`large_image`,`ean_code`,`product_number`,`link`,`is_public`,`start_of_publishing`,`product_info_page`)
        VALUES ('" . $standUniqueId . "','" . $_SESSION['userid'] . "','" . $companyId . "', '" . $catImg . "','" . $arrUser['product_name'] . "','" . $arrUser['is_sponsored'] . "','" . $arrUser['category'] . "'
            ,'" . $copImg . "','" . $arrUser['ean_code'] . "','" . $arrUser['product_number'] . "','" . $arrUser['link'] . "','" . $arrUser['is_public'] . "','" . $arrUser['start_of_publishing'] . "','" . $arrUser['product_info_page'] . "');";
        $res = mysql_query($query) or die(mysql_error());

        if ($reseller != '') {
            $query = "UPDATE product SET `reseller_status` = 'P' WHERE product_id = '" . $standUniqueId . "'";
            $res = mysql_query($query);
        }

        ////////Slogen entry///////
        $sloganLangId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $sloganLangId . "','" . $arrUser['lang'] . "','" . $arrUser['offer_slogan_lang_list'] . "')";
        $res = mysql_query($_SQL) or die(mysql_error());

        /// SLogen anf language table relation entry ////
        $_SQL = "insert into product_offer_slogan_lang_list(`product_id`,`offer_slogan_lang_list`) values('" . $standUniqueId . "','" . $sloganLangId . "')";
        $res = mysql_query($_SQL) or die(mysql_error());


        ////////keyword entry///////
         if(trim($arrUser['keywords']) != "")
         {
        $keywordId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $keywordId . "','" . $arrUser['lang'] . "','" . $arrUser['keywords'] . "')";
        $res = mysql_query($_SQL) or die(mysql_error());

        $_SQL = "insert into product_keyword(`product_id`,`offer_keyword`) values('" . $standUniqueId . "','" . $keywordId . "')";
        $res = mysql_query($_SQL) or die(mysql_error());
         }

         $SystemkeyId = uuid();
            $_SQL = "insert into lang_text(id,lang,text) values('" . $SystemkeyId . "','" . $arrUser['lang'] . "','" . $standUniqueId . "')";
            $res = mysql_query($_SQL) or die(mysql_error());

            $_SQL = "insert into product_keyword(`product_id`,`system_key`) values('" . $standUniqueId . "','" . $SystemkeyId . "')";
            $res = mysql_query($_SQL) or die(mysql_error());
         
         $Systemkey_companyId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $Systemkey_companyId . "','" . $arrUser['lang'] . "','" . $companyId . "')";
        $res = mysql_query($_SQL) or die(mysql_error());

        $_SQL = "insert into product_keyword(`product_id`,`system_key`) values('" . $standUniqueId . "','" . $Systemkey_companyId . "')";
        $res = mysql_query($_SQL) or die(mysql_error());
         
      
            
            
            

        ///////Update user table activ field/////////////////////////////
        $query = "UPDATE user SET activ='3' WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res = mysql_query($query) or die(mysql_error());

        $_SESSION['MESSAGE'] = STANDARD_OFFER_SUCCESS;
        $_SESSION['REG_STEP'] = 4;
        $_SESSION['active_state'] = 3;
        if ($reseller == '') {
            $url = BASE_URL . 'registrationStep.php';
            $inoutObj->reDirect($url);
            exit();
        } else {
            $url = BASE_URL . 'registrationResellerStep.php';
            $inoutObj->reDirect($url);
            exit();
        }
    }

    function editTypeofdishsave(){
        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
        $arrUser = array();
        $arrUser['dishid'] = $_POST['dishid'];
        $arrUser['dishName'] = mysqli_real_escape_string($conn,$_POST['dishName']);
        $arrUser['lang'] = $_POST['lang'];
       

        $query = "UPDATE dish_type SET
                    dish_lang='" .  $arrUser['lang'] . "',dish_name = '" .  $arrUser['dishName'] . "'
                    WHERE dish_id='" . $arrUser['dishid'] . "' ";
        $res = mysqli_query($conn, $query) or die(mysql_error());
        $url = BASE_URL . 'showDishes.php';
        $inoutObj->reDirect($url);

        exit();
    }


    function addDishes(){

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

        $arrUser['lang'] = $_POST['lang'];
        $arrUser['dishType'] = mysqli_real_escape_string($conn,$_POST['dishName']);

        $query = "SELECT * FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
        $res = mysqli_query($conn , $query) or die(mysql_error());
        $rs_comp = mysqli_fetch_array($res);

        if($rs_comp['company_id'] != ''){
            $query = "INSERT INTO dish_type(`dish_lang`,`dish_name`,`company_id`, `u_id`)
        VALUES ('" . $arrUser['lang'] . "','" . $arrUser['dishType'] . "','" . $rs_comp['company_id'] . "', '" . $_SESSION['userid'] . "');";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

        $_SESSION['MESSAGE'] = DISH_TYPE_SUCCESS;
   
        $url = BASE_URL . 'showDishes.php';
        $inoutObj->reDirect($url);
        exit();
        }
    }

    public function listDishes(){
        $db = new db();
        $db->makeConnection();
        $q = $db->query("SELECT dish_id,dish_name FROM dish_type WHERE u_id = '" . $_SESSION['userid'] . "' AND  dish_activate='1'");
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }

    public function getTypeOfDishDetail($dishId){
        $db = new db();
        $db->makeConnection();
        $q = $db->query("SELECT dish_name,dish_lang FROM dish_type WHERE dish_id = '" . $dishId . "' ");
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }

        /* Function Header :saveNewStandardOffersDetails()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: Save the Standard offer detils i the product table with the relationship of language table and and relationship talble
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

            if ($arrUser['is_sponsored'] == 1 && ($rs['pre_loaded_value'] == '0' || $rs['pre_loaded_value'] == null)) {
                $_SESSION['MESSAGE'] = INSUFFICIENT_BALANCE;
            }
        }


        $CategoryIconName = "cat_icon_" . md5(time());
        $info = pathinfo($_FILES["icon"]["name"]);
        //print_r($info); die();
        // Opload images related to
        if (!empty($_FILES["icon"]["name"])) {
            //echo "Cat in"; die();
            if (!empty($_FILES["icon"]["name"])) {
                $file_extension = strtolower($info['extension']);
                if ($file_extension == "png" || $file_extension == "jpg" || $file_extension == "jpeg" || $file_extension == "gif" || $file_extension == "bmp") {      
                    if ($_FILES["icon"]["error"] > 0) {
                        $error.=$_FILES["icon"]["error"] . "<br />";
                    } else {
                        $cat_filename = $CategoryIconName . "." . strtolower($info['extension']);
                        // move_uploaded_file($_FILES["icon"]["tmp_name"],UPLOAD_DIR."category/" .$cat_filename);
                        $fileOriginal = $_FILES['icon']['tmp_name'];
                        $crop = '5';
                        $size = 'iphone4_cat';
                        $path = UPLOAD_DIR . "category/";
                        $fileThumbnail = $path . $cat_filename;
                        createFileThumbnail($fileOriginal, $fileThumbnail, $size, $frontUpload = 0, $crop, $errorMsg);

                        $arrUser['small_image'] = $cat_filename;
                    }
                } else {
                    $error.=NOT_VALID_EXT;
                }
            } else {
                if ($_SESSION['preview']['small_image'] != "") {
                    $arrUser['small_image'] = $_SESSION['preview']['small_image'];
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

    /* Function Header :getCategoryList()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: Find all record of category from the server library
     */

    function getCategoryList($selectedId=0, $lang='eng') {

        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        if ($lang == '') {
            $lang = 'ENG';
        }


        $options = "";
        $query = "SELECT cat.category_id, ltext.text, cat.small_image FROM category as cat left join category_names_lang_list as cat_lang
            ON (cat.category_id = cat_lang.category)
            LEFT JOIN lang_text as ltext ON (cat_lang.names_lang_list = ltext.id) WHERE ltext.lang='" . $lang . "' ";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        while ($rs = mysqli_fetch_array($res)) {
            $data[] = $rs;

            if ($selectedId == $rs['category_id']) {
                $selected = "selected='selected'";
            } else {
                $selected = "";
            }
            $options.="<option value='" . $rs['category_id'] . "' " . $selected . " >" . $rs['text'] . "</option>";
        }
        return $options;
    }

    function getSingleCategoryList($selectedId=0, $lang='eng') {
        $db = new db();

        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $query = "SELECT ltext.text FROM category as cat left join category_names_lang_list as cat_lang
            ON (cat.category_id = cat_lang.category)
            LEFT JOIN lang_text as ltext ON (cat_lang.names_lang_list = ltext.id) WHERE ltext.lang='" . $lang . "' AND cat.category_id = '" . $selectedId . "' ";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        $rs = mysqli_fetch_array($res);
        $data = $rs[text];



        return $data;
    }

//   function getLangList() {
//
//        $options = "";
//     $query = "SELECT  ltext.lang FROM category as cat left join category_names_lang_list as cat_lang
//            ON (cat.category_id = cat_lang.category)
//            LEFT JOIN lang_text as ltext ON (cat_lang.names_lang_list = ltext.id) ";
//        $res = mysql_query($query) or die(mysql_error());
//        while ($rs = mysql_fetch_array($res)) {
//            $data[] = $rs;
//
//            if ($selectedId == $rs['category_id']) {
//                $selected = "selected='selected'";
//            } else {
//                $selected = "";
//            }
//            $options.="<option value='" . $rs['category_id'] . "' " . $selected . " >" . $rs['lang'] . "</option>";
//        }
//
//        return $options;
//
//    }






    /* Function Header :showCampaignOffersDetails()
     *             Args: $emailId
     *           Errors: none
     *     Return Value: none
     *      Description: To show all the details related to the Campaign Offer in the database.
     */

    function showCampaignOffersResellerDetails($paging_limit='0 , 10') {
        $db = new db();
        $db->makeConnection();
        $data = array();

        $q = $this->searchResellerCampaign($paging_limit);

        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }

    function showCampaignOffersDetailsResellerRows() {
        $db = new db();
        $db->makeConnection();
        $data = array();

        $res = $this->searchResellerCampaign();

        $total_records = $db->numRows($res);

        return $total_records;
    }

//////////////////////////////for show campaign
    function showCampaignOffersDetails($paging_limit='0 , 10') {
        $db = new db();
        $db->makeConnection();
        $data = array();

        $q = $this->searchCampaign($paging_limit);

        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }

    function showCampaignOffersDetailsRows() {
        $db = new db();
        $db->makeConnection();
        $data = array();

        $res = $this->searchCampaign();

        $total_records = $db->numRows($res);

        return $total_records;
    }

    function searchCampaign($paging_limit=0) {

        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['ke'])) {
            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'keyw.text LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
            if ($_REQUEST['key']) {
                $set_keywords.= 'subsloganT.text LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }
            if ($_REQUEST['ke']) {
                $set_keywords.= 'sloganT.text LIKE "%' . trim($_REQUEST['ke']) . '%" AND ';
            }
        }
        else
            $set_keywords = " 1 AND ";

        if ($paging_limit)
            $limit = "limit " . $paging_limit;

        $query = "select * from employer where u_id = '" . $_SESSION['userid'] . "'";
        $res = mysqli_query($conn , $query);
        $rs = mysqli_fetch_array($res);
        $companyId = $rs['company_id'];

     

        if ($_REQUEST['m'] == "showcampoffer") {
            $QUE = "SELECT campaign.*,sloganT.text as slogan,subsloganT.text as subslogen,keyw.text as keywordss, campaign.infopage,lang_text.text as category  FROM campaign
                        LEFT JOIN   campaign_offer_slogan_lang_list ON  campaign_offer_slogan_lang_list.campaign_id = campaign.campaign_id
                        LEFT JOIN   campaign_offer_sub_slogan_lang_list  ON  campaign_offer_sub_slogan_lang_list.campaign_id = campaign.campaign_id
                        LEFT JOIN   campaign_keyword  ON  campaign_keyword.campaign_id = campaign.campaign_id
                        LEFT JOIN   lang_text as sloganT ON  campaign_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
                        LEFT JOIN   lang_text as subsloganT ON campaign_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = subsloganT.id
                        LEFT JOIN   lang_text as keyw ON campaign_keyword.offer_keyword = keyw.id
                        LEFT JOIN  category  ON category.category_id = campaign.category
                        LEFT JOIN  category_names_lang_list  ON category.category_id = category_names_lang_list.category
                        LEFT JOIN  lang_text   ON lang_text.id = category_names_lang_list.names_lang_list
                        WHERE
                        campaign.company_id='" . $companyId . "' AND $set_keywords  end_of_publishing < CURDATE() AND s_activ!='2' AND (reseller_status = 'A' OR reseller_status = '') GROUP BY campaign_id " . $limit;
// Removed AND lang_text.lang = subsloganT.lang
        } else {

            //$QUE = "SELECT campaign.* FROM campaign WHERE(campaign.company_id='23fe56ea-0b2f-ae7f-8afe-26fcd0ab3fc7')" . $limit;

            $QUE = "SELECT campaign.*,sloganT.text as slogan,subsloganT.text as subslogen,keyw.text as keyword, campaign.infopage,lang_text.text as category  FROM campaign
                        LEFT JOIN   campaign_offer_slogan_lang_list ON  campaign_offer_slogan_lang_list.campaign_id = campaign.campaign_id
                        LEFT JOIN   campaign_offer_sub_slogan_lang_list  ON  campaign_offer_sub_slogan_lang_list.campaign_id = campaign.campaign_id
                        LEFT JOIN   campaign_keyword  ON  campaign_keyword.campaign_id = campaign.campaign_id
                        LEFT JOIN   lang_text as sloganT ON  campaign_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
                        LEFT JOIN   lang_text as subsloganT ON campaign_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = subsloganT.id
                        LEFT JOIN   lang_text as keyw ON campaign_keyword.offer_keyword = keyw.id
                        LEFT JOIN  category  ON (category.category_id = campaign.category)
                        LEFT JOIN  category_names_lang_list  ON (category.category_id = category_names_lang_list.category)
                        LEFT JOIN  lang_text   ON lang_text.id = category_names_lang_list.names_lang_list

                        WHERE
                        campaign.company_id='" . $companyId . "' OR $set_keywords 1 AND end_of_publishing >= CURDATE() AND (s_activ='0' or s_activ='3') AND (reseller_status = 'A' OR reseller_status = '') GROUP BY campaign_id " . $limit;

                          //echo $QUE;
                          //die();

                        //echo $QUE;
                        
// Removed AND lang_text.lang = subsloganT.lang
        }
        /*
          (campaign.u_id='".$_SESSION['userid']."' AND ".$set_keywords.") OR
          (campaign.u_id='".$_SESSION['userid']."' AND ".$set_keywords.") OR
          (campaign.u_id='".$_SESSION['userid']."' AND ".$set_keywords.")";
         */


        $res = mysqli_query($conn , $QUE);

        return $res;
    }

    ///////////////////////////////////


    function showStandardOffersDetailsResellerRows() {

        //$inoutObj = new inOut();
        $db = new db();
        $db->makeConnection();
        $data = array();

        $res = $this->searchResellerStandard();

        $total_records = $db->numRows($res);

        return $total_records;
    }

    function showStandardOffersResellerDetails($paging_limit='0 , 10') {

        //$inoutObj = new inOut();
        $db = new db();
        $db->makeConnection();
        $data = array();

        $q = $this->searchResellerStandard($paging_limit);

        while ($rs = mysql_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }

//////////////////////for show standard

    function showStandardOffersDetailsRows() {
        $db = new db();
        $db->makeConnection();
        $data = array();

        $res = $this->searchStandard();

        $total_records = $db->numRows($res);

        return $total_records;
    }

    function showStandardOffersDetails($paging_limit='0 , 10') {

        //$inoutObj = new inOut();
        $db = new db();
        $db->makeConnection();
        $data = array();

        $q = $this->searchStandard($paging_limit);

        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }

    function searchStandard($paging_limit=0) {

        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['ke'])) {
            // $qstr1 = " store_name REGEXP '[[:<:]]".trim($_REQUEST['keyword'])."[[:>:]]' ";
            // $qstr2 = " email REGEXP '[[:<:]]".trim($_REQUEST['key'])."[[:>:]]' ";

            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'lang_text.text LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
            if ($_REQUEST['key']) {
                $set_keywords.= 'keyw.text LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }

            // $set_keywords = "(u_id='".$_SESSION['userid']."' AND ".$qstr1.") OR
            //                  (u_id='".$_SESSION['userid']."' AND ".$qstr2.")";
            //$set_keywords = trim($set_keywords, " AND ");
        } else {
            ////////////////////////////////////////////
            $set_keywords = " 1 AND";
        }

        if ($paging_limit)
            $limit = "limit " . $paging_limit;

        $query = "select * from employer where u_id = '" . $_SESSION['userid'] . "'";
        $res = mysqli_query($conn , $query);
        $rs = mysqli_fetch_array($res);
        $companyId = $rs['company_id'];

        $QUE = "SELECT product.*, lang_text.text as slogen,keyw.text as keyword,cat.text as category FROM product
            LEFT JOIN          user                     ON   product.u_id = user.u_id
            LEFT JOIN    product_offer_slogan_lang_list  ON   product_offer_slogan_lang_list.product_id = product.product_id
            LEFT JOIN    product_keyword  ON   product_keyword.product_id = product.product_id
            LEFT JOIN        lang_text                  ON   product_offer_slogan_lang_list.offer_slogan_lang_list  = lang_text.id
             LEFT JOIN        lang_text as keyw    ON   product_keyword.offer_keyword  = keyw.id
            LEFT JOIN  category  ON category.category_id = product.category
            LEFT JOIN  category_names_lang_list  ON category.category_id = category_names_lang_list.category
            LEFT JOIN  lang_text as cat  ON cat.id = category_names_lang_list.names_lang_list
           WHERE product.company_id='" . $companyId . "' AND s_activ='0' GROUP BY product_id " . $limit;


// $QUE = "select * from lang_text";

        $res = mysqli_query($conn ,$QUE);

        // $k=0;
        // while ($row = mysqli_fetch_array($res)) {
        //     # code...
        //     if($k == 1){
                    // echo '<pre>';
                    // print_r($row);
                    // echo '</pre>';
//die();
        //     }
        //     $k++;

        // }

        return $res;
    }

    //////////////////////////////////////
    function showDeleteStandardOffersDetailsResellerRows() {

        //$inoutObj = new inOut();
        $db = new db();
        $db->makeConnection();
        $data = array();

        $res = $this->searchDeleteResellerStandard();

        $total_records = $db->numRows($res);

        return $total_records;
    }

    function showDeleteResellerStandard($paging_limit='0 , 10') {

        //$inoutObj = new inOut();
        $db = new db();
        $db->makeConnection();
        $data = array();

        $q = $this->searchDeleteResellerStandard($paging_limit);

        while ($rs = mysql_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }

///////////////////////////////for showDeleteStandard
    function showDeleteStandardOffersDetailsRows() {

        //$inoutObj = new inOut();
        $db = new db();
        $db->makeConnection();
        $data = array();

        $res = $this->searchDeleteStandard();

        $total_records = $db->numRows($res);

        return $total_records;
    }

    function showDeleteStandard($paging_limit='0 , 10') {

        //$inoutObj = new inOut();
        $db = new db();
        $db->makeConnection();
        $data = array();

        $q = $this->searchDeleteStandard($paging_limit);

        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }

    function searchDeleteStandard($paging_limit=0) {

        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        /////////////////
        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['ke'])) {
            // $qstr1 = " store_name REGEXP '[[:<:]]".trim($_REQUEST['keyword'])."[[:>:]]' ";
            // $qstr2 = " email REGEXP '[[:<:]]".trim($_REQUEST['key'])."[[:>:]]' ";

            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'lang_text.text LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
            if ($_REQUEST['key']) {
                $set_keywords.= 'keyw.text LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }

            // $set_keywords = "(u_id='".$_SESSION['userid']."' AND ".$qstr1.") OR
            //                  (u_id='".$_SESSION['userid']."' AND ".$qstr2.")";
            //$set_keywords = trim($set_keywords, " AND ");
        } else {

            $set_keywords = " 1 AND";
            //echo"here";die();
        }

        if ($paging_limit)
            $limit = "limit " . $paging_limit;

        $query = "select * from employer where u_id = '" . $_SESSION['userid'] . "'";
        $res = mysqli_query($conn , $query);
        $rs = mysqli_fetch_array($res);
        $companyId = $rs['company_id'];

        // $QUE = "SELECT product.*, lang_text.text as slogen,keyw.text as keyword,cat.text as category FROM product
        //     LEFT JOIN          user                     ON   product.u_id = user.u_id
        //     LEFT JOIN    product_offer_slogan_lang_list  ON   product_offer_slogan_lang_list.product_id = product.product_id
        //     LEFT JOIN    product_keyword  ON   product_keyword.product_id = product.product_id
        //     LEFT JOIN        lang_text                  ON   product_offer_slogan_lang_list.offer_slogan_lang_list  = lang_text.id
        //     LEFT JOIN        lang_text as keyw    ON   product_keyword.offer_keyword  = keyw.id
        //     LEFT JOIN  category  ON category.category_id = product.category
        //     LEFT JOIN  category_names_lang_list  ON category.category_id = category_names_lang_list.category
        //     LEFT JOIN  lang_text as cat  ON cat.id = category_names_lang_list.names_lang_list
        //    WHERE product.company_id='" . $companyId . "' AND $set_keywords  s_activ='2' AND cat.lang = lang_text.lang";
        $QUE = "SELECT product.* FROM product WHERE product.company_id='" . $companyId . "' AND $set_keywords  s_activ='2'";
        $res = mysqli_query($conn ,$QUE);

        return $res;
    }

    /////////////////////////////////////////////
    function showAllPublicStandardOffers() {

        //$inoutObj = new inOut();
        $db = new db();
        $db->makeConnection();
        $is_Public = array();

        $res = $this->searchPublicStandardOffers();

        $total_records1 = $db->numRows($res);

        return $total_records1;
    }

    function showAllPublicCampaignOffers() {

        //$inoutObj = new inOut();
        $db = new db();
        $db->makeConnection();
        $is_Public = array();

        $res = $this->searchPublicCampaignOffers();

        $total_records1 = $db->numRows($res);

        return $total_records1;
    }

    function searchPublicCampaignOffers($paging_l=0) {

        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['ke'])) {
            // $qstr1 = " store_name REGEXP '[[:<:]]".trim($_REQUEST['keyword'])."[[:>:]]' ";
            // $qstr2 = " email REGEXP '[[:<:]]".trim($_REQUEST['key'])."[[:>:]]' ";
            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'campaign.keywords LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }

            // $set_keywords = "(u_id='".$_SESSION['userid']."' AND ".$qstr1.") OR
        }
        else
            $set_keywords = " 1 AND ";

        if ($paging_l)
            $limit = "limit " . $paging_l;


        $QUE = "SELECT c_s_rel.*,campaign.* FROM c_s_rel
                        left join store on(c_s_rel.store_id=store.store_id)
                        left join campaign on(c_s_rel.campaign_id=campaign.campaign_id)
                         WHERE store.u_id='" . $_SESSION['userid'] . "' AND $set_keywords 1 AND campaign.s_activ='0' AND c_s_rel.activ='1'  AND campaign.u_id!='" . $_SESSION['userid'] . "'";
        /*
          (campaign.u_id='".$_SESSION['userid']."' AND ".$set_keywords.") OR
          (campaign.u_id='".$_SESSION['userid']."' AND ".$set_keywords.") OR
          (campaign.u_id='".$_SESSION['userid']."' AND ".$set_keywords.")";
         */


        $res = mysqli_query($conn ,$QUE);

        return $res;
    }

    function showAllPublicCampaignOffersDetails($paging_l='0 , 10') {

        //$inoutObj = new inOut();
        $db = new db();
        $db->makeConnection();
        $is_Public = array();

        $q = $this->searchPublicCampaignOffers($paging_l);

        while ($rs = mysqli_fetch_array($q)) {
            $is_Public[] = $rs;
        }
        return $is_Public;
    }

    function searchPublicStandardOffers($paging_l=0) {

        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}



        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['ke'])) {
            // $qstr1 = " store_name REGEXP '[[:<:]]".trim($_REQUEST['keyword'])."[[:>:]]' ";
            // $qstr2 = " email REGEXP '[[:<:]]".trim($_REQUEST['key'])."[[:>:]]' ";

            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'lang_text.text LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
            if ($_REQUEST['key']) {
                $set_keywords.= 'product_name LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }

            // $set_keywords = "(u_id='".$_SESSION['userid']."' AND ".$qstr1.") OR
            //                  (u_id='".$_SESSION['userid']."' AND ".$qstr2.")";
            //$set_keywords = trim($set_keywords, " AND ");
        } else {

            $set_keywords = " 1 AND";
            //echo"here";die();
        }

        if ($paging_l)
            $limit = "limit " . $paging_l;

        $QUE = "SELECT product.*, lang_text.text as slogen FROM product
            LEFT JOIN          user                     ON   product.u_id = user.u_id
            LEFT JOIN    product_offer_slogan_lang_list  ON   product_offer_slogan_lang_list.product_id = product.product_id
            LEFT JOIN        lang_text                  ON   product_offer_slogan_lang_list.offer_slogan_lang_list  = lang_text.id
           WHERE  is_public='1' AND  product.u_id !='" . $_SESSION['userid'] . "' AND $set_keywords 1 ";
        $res = mysqli_query($conn ,$QUE);

        return $res;
    }

    function showAllPublicStandardOffersDetails($paging_l='0 , 10') {

        //$inoutObj = new inOut();
        $db = new db();
        $db->makeConnection();
        $is_Public = array();

        $q = $this->searchPublicStandardOffers($paging_l);

        while ($rs = mysqli_fetch_array($q)) {
            $is_Public[] = $rs;
        }
        return $is_Public;
    }

// function showAllPublicStandardOffersDetails($paging_l='0 , 10') {
//
//        $db = new db();
//        $db->makeConnection();
//        $is_Public = array();
//        $error = '';
//
//        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['ke'])) {
//            // $qstr1 = " store_name REGEXP '[[:<:]]".trim($_REQUEST['keyword'])."[[:>:]]' ";
//            // $qstr2 = " email REGEXP '[[:<:]]".trim($_REQUEST['key'])."[[:>:]]' ";
//            $set_keywords = "";
//            if ($_REQUEST['keyword']) {
//                $set_keywords.= 'lang_text.text LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
//            }
//            if ($_REQUEST['key']) {
//                $set_keywords.= 'product_name LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
//            }
//
//            // $set_keywords = "(u_id='".$_SESSION['userid']."' AND ".$qstr1.") OR
//            //                  (u_id='".$_SESSION['userid']."' AND ".$qstr2.")";
//            //$set_keywords = trim($set_keywords, " AND ");
//        }
//        else
//            $set_keywords = " 1 AND ";
//
//
//        $query = "SELECT product.*, lang_text.text as slogen FROM product
//            LEFT JOIN          user                     ON   product.u_id = user.u_id
//            LEFT JOIN    product_offer_slogan_lang_list  ON   product_offer_slogan_lang_list.product_id = product.product_id
//            LEFT JOIN        lang_text                  ON   product_offer_slogan_lang_list.offer_slogan_lang_list  = lang_text.id
//            WHERE is_public='1' AND  product.u_id !='" . $_SESSION['userid'] . "' AND $set_keywords 1 LIMIT {$paging_l} ";
//
//        $q = $db->query($query);
//        while ($rs = mysql_fetch_array($q)) {
//            $is_Public[] = $rs;
//        }
//        return $is_Public;
//    }



    function searchDeleteResellerStandard($paging_limit=0) {

        /////////////////
        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['ke'])) {
            // $qstr1 = " store_name REGEXP '[[:<:]]".trim($_REQUEST['keyword'])."[[:>:]]' ";
            // $qstr2 = " email REGEXP '[[:<:]]".trim($_REQUEST['key'])."[[:>:]]' ";

            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'lang_text.text LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
            if ($_REQUEST['key']) {
                $set_keywords.= 'keyw.text LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }

            // $set_keywords = "(u_id='".$_SESSION['userid']."' AND ".$qstr1.") OR
            //                  (u_id='".$_SESSION['userid']."' AND ".$qstr2.")";
            //$set_keywords = trim($set_keywords, " AND ");
        } else {

            $set_keywords = " 1 AND";
            //echo"here";die();
        }

        if ($paging_limit)
            $limit = "limit " . $paging_limit;



        $QUE = "SELECT product.*, lang_text.text as slogen,keyw.text as keyword,cat.text as category FROM product
            LEFT JOIN          user                     ON   product.u_id = user.u_id
            LEFT JOIN    product_offer_slogan_lang_list  ON   product_offer_slogan_lang_list.product_id = product.product_id
            LEFT JOIN    product_keyword  ON   product_keyword.product_id = product.product_id
            LEFT JOIN        lang_text                  ON   product_offer_slogan_lang_list.offer_slogan_lang_list  = lang_text.id
            LEFT JOIN        lang_text as keyw    ON   product_keyword.offer_keyword  = keyw.id
            LEFT JOIN  category  ON category.category_id = product.category
            LEFT JOIN  category_names_lang_list  ON category.category_id = category_names_lang_list.category
            LEFT JOIN  lang_text as cat  ON cat.id = category_names_lang_list.names_lang_list
           WHERE product.u_id='" . $_SESSION['userid'] . "' AND $set_keywords  s_activ='2' AND cat.lang = lang_text.lang GROUP BY product_id " . $limit;
        $res = mysql_query($QUE);

        return $res;
    }

    /* Function Header : viewStandardDetailById()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: Find record of Standard offers for a particular User
     */

    function viewStandardDetailById($productid, $lang='ENG') {
        // print_r($data); die("dssdada");
        // echo $lang;die();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $data = array();
        $error = '';
        
        /*$query = "SELECT product.*, lang_text.text as slogen, keyw.text as keyword,cat.text as categoryName FROM product
            LEFT JOIN          user                     ON   product.u_id = user.u_id
            LEFT JOIN    product_offer_slogan_lang_list  ON   product_offer_slogan_lang_list.product_id = product.product_id
             LEFT JOIN    product_keyword  ON   product_keyword.product_id = product.product_id
            LEFT JOIN        lang_text                  ON   product_offer_slogan_lang_list.offer_slogan_lang_list  = lang_text.id
            LEFT JOIN        lang_text as keyw     ON   product_keyword.offer_keyword   = keyw.id
            LEFT JOIN  category  ON category.category_id = product.category
            LEFT JOIN  category_names_lang_list  ON category.category_id = category_names_lang_list.category
            LEFT JOIN  lang_text as cat  ON cat.id = category_names_lang_list.names_lang_list
           WHERE product.product_id='" . $productid . "' 
           AND  cat.lang = '" . $lang . "' AND cat.lang = lang_text.lang
               AND cat.lang = keyw.lang AND cat.lang = lang_text.lang  
               GROUP BY product.product_id";*/

        $query = "SELECT product.*, lang_text.text as slogen, keyw.text as keyword,cat.text as categoryName FROM product
            LEFT JOIN          user                     ON   product.u_id = user.u_id
            LEFT JOIN    product_offer_slogan_lang_list  ON   product_offer_slogan_lang_list.product_id = product.product_id
             LEFT JOIN    product_keyword  ON   product_keyword.product_id = product.product_id
            LEFT JOIN        lang_text                  ON   product_offer_slogan_lang_list.offer_slogan_lang_list  = lang_text.id
            LEFT JOIN        lang_text as keyw     ON   product_keyword.offer_keyword   = keyw.id
            LEFT JOIN  category  ON category.category_id = product.category
            LEFT JOIN  category_names_lang_list  ON category.category_id = category_names_lang_list.category
            LEFT JOIN  lang_text as cat  ON cat.id = category_names_lang_list.names_lang_list
           WHERE product.product_id='" . $productid . "' 
               GROUP BY product.product_id";

        $q = $db->query($query);
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
        }


        $QUE = "select store.*,product_price_list.text from store left join c_s_rel
        on(c_s_rel.store_id = store.store_id)
        left join product_price_list
        on(store.store_id = product_price_list.store_id) AND (c_s_rel.product_id = product_price_list.product_id)
        where c_s_rel.product_id ='" . $productid . "' AND activ='1'";
        $res = mysqli_query($conn , $QUE) or die(mysqli_error($conn));
        while ($row = mysqli_fetch_array($res)) {
            $storeDetails[] = $row;
        }
        $data['storeDetails'] = $storeDetails;
        //print_r($data['storeDetails']);
        //echo $_SESSION['userid'];
        return $data;
    }

    /* Function Header : getProductDetailById()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: Find record of Product for a particular User
     */

    function getProductDetailById($productid) {
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $data = array();
        $query = "SELECT product.*, lang_text.text as slogen,keyw.text as keyword,cat.text as categoryName FROM product
            LEFT JOIN          user                     ON   product.u_id = user.u_id
            LEFT JOIN    product_offer_slogan_lang_list  ON   product_offer_slogan_lang_list.product_id = product.product_id
            LEFT JOIN    product_keyword  ON   product_keyword.product_id = product.product_id
            LEFT JOIN        lang_text     ON   product_offer_slogan_lang_list.offer_slogan_lang_list  = lang_text.id
             LEFT JOIN        lang_text as keyw     ON   product_keyword.offer_keyword   = keyw.id
            LEFT JOIN  category  ON category.category_id = product.category
            LEFT JOIN  category_names_lang_list  ON category.category_id = category_names_lang_list.category
            LEFT JOIN  lang_text as cat  ON cat.id = category_names_lang_list.names_lang_list
            WHERE user.u_id='" . $_SESSION['userid'] . "' AND product.product_id='" . $productid . "' AND cat.lang = lang_text.lang ";

        $q = $db->query($query);
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }

    /* Function Header : editSaveStandard()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: To fetch values of a particular standard offer for editing.
     */

    function editSaveStandard($productid) {

        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $arrUser = array();
        $error = '';


        $arrUser['offer_slogan_lang_list'] = $_POST['titleSlogan'];
        $arrUser['offer_sub_slogan_lang_list'] = $_POST['subSlogan'];
        $arrUser['small_image'] = $_POST['icon'];
        $arrUser['brand_name'] = $_POST['brandName'];
        $arrUser['spons'] = $_POST['sponsor'];
        $arrUser['category'] = $_POST['linkedCat'];
        $arrUser['start_of_publishing'] = $_POST['startDate'];
        $arrUser['end_of_publishing'] = $_POST['endDate'];
        $arrUser['campaign_name'] = $_POST['campaignName'];
        $arrUser['keywords'] = $_POST['searchKeyword'];
        $arrUser['start_time'] = $_POST['startDateLimitation'];
        $arrUser['discountValue'] = addslashes($_POST['discountValue']);
        
        $arrUser['end_time'] = $_POST['endDateLimitation'];
        $arrUser['large_image'] = $_POST['picture'];
        $arrUser['infopage'] = $_POST['descriptive'];
        $arrUser['valid_day'] = $_POST['limitDays'];
        $arrUser['lang'] = $_POST['lang'];


        $error.= ( $arrUser['offer_slogan_lang_list'] == '') ? ERROR_TITLE_SLOGAN : '';

        $error.= ( $arrUser['offer_sub_slogan_lang_list'] == '') ? ERROR_SUB_SLOGAN : '';

        $error.= ( $arrUser['brand_name'] == '') ? ERROR_BRANDNAME : '';

        $error.= ( $arrUser['spons'] == '') ? ERROR_SPONSORS : '';

        $error.= ( $arrUser['category'] == '') ? ERROR_CATEGORY : '';

        $error.= ( $arrUser['start_of_publishing'] == '') ? ERROR_START_OF_PUBLISHING : '';

        $error.= ( $arrUser['end_of_publishing'] == '') ? ERROR_END_OF_PUBLISHING : '';

        $error.= ( $arrUser['campaign_name'] == '') ? ERROR_CAMPAIGN_NAME : '';

        $error.= ( $arrUser['start_time'] == '') ? ERROR_START_DATE : '';

        $error.= ( $arrUser['end_time'] == '') ? ERROR_END_DATE : '';

        $error.= ( $arrUser['valid_day'] == '') ? ERROR_LIMIT_DAYS : '';
        $error.= ( $arrUser['discountValue'] == '') ? ERROR_DISCOUNT_VALUE : '';
        //echo $error; die();

        $_SESSION['post'] = "";
        //echo $_FILES['icon']['size']."_".(500*1024); die();
        //
        //// Upload category icon file//////
        $CategoryIconName = "cat_icon_" . md5(time());
        $info = pathinfo($_FILES["icon"]["name"]);
//echo $_FILES["icon"]["name"]; die();
        if (!empty($_FILES["icon"]["name"])) {

            if (strtolower($info['extension']) == "png") {
                if ($_FILES["icon"]["error"] > 0) {
                    $error.=$_FILES["icon"]["error"] . "<br />";
                } else {
                    $cat_filename = $CategoryIconName . "." . strtolower($info['extension']);
                    //move_uploaded_file($_FILES["icon"]["tmp_name"],UPLOAD_DIR."Category/" .$cat_filename);
                    $fileOriginal = $_FILES['icon']['tmp_name'];
                    $crop = '5';
                    $size = 'iphone4_cat';
                    $path = UPLOAD_DIR . "Category/";
                    $fileThumbnail = $path . $coupon_filename;
                    createFileThumbnail($fileOriginal, $fileThumbnail, $size, $frontUpload = 0, $crop, $errorMsg);
                    $arrUser['small_image'] = $cat_filename;
                }
            } else {
                $error.=NOT_VALID_EXT;
            }
        } else {
            $error.= ERROR_SMALL_IMAGE;
        }
        //// Upload Coupen image//////
        $coupenName = "cpn_" . md5(time());
        $info = pathinfo($_FILES["picture"]["name"]);
        if (!empty($_FILES["picture"]["name"])) {
            if (strtolower($info['extension']) == "jpg" || strtolower($info['extension']) == "jpeg" || $file_extension == "gif" || $file_extension == "bmp") {
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
                }
            } else {
                $error.=NOT_VALID_EXT;
            }
        } else {
            $error.=ERROR_SMALL_IMAGE;
        }
        if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            $url = BASE_URL . 'campaignOffer.php';

            $inoutObj->reDirect($url);
            exit();
        }
        $catImg = _UPLOAD_URLDIR_ . 'category/' . $arrUser['small_image'];
        $copImg = _UPLOAD_URLDIR_ . 'coupon/' . $arrUser['large_image'];

        $campaignId = uuid();
        $arrUser['coupon_id'] = uuid();
        /// Select company id of this user
        $QUE = "select company_id from company where u_id='" . $_SESSION['userid'] . "'";
        $res = mysqli_query($conn , $QUE) or die(mysqli_error($conn));
        $row = mysqli_fetch_array($res);
        $companyId = $row['company_id'];
        ///Select store id from the table on the basis of company id
        $QUE = "select store_id from store where u_id='" . $_SESSION['userid'] . "'";
        $res = mysqli_query($conn , $QUE) or die(mysqli_error($conn));
        $row = mysqli_fetch_array($res);
        $storeId = $row['store_id'];

        $arrUser['u_id'] = $_SESSION['userid'];
// New viewopt Kent
        $query = "INSERT INTO campaign(`campaign_id`,`company_id`,`u_id`, `small_image`,`large_image`, `spons`, `category`, `start_of_publishing`,`end_of_publishing`,`campaign_name`,`view_opt`,`keywords`,`infopage`,`value`)
                VALUES ('" . $campaignId . "','" . $companyId . "','" . $_SESSION['userid'] . "', '" . $catImg . "', '" . $copImg . "','" . $arrUser['spons'] . "','" . $arrUser['category'] . "','" . $arrUser['start_of_publishing'] . "','" . $arrUser['end_of_publishing'] . "','" . $arrUser['campaign_name'] . "','" . $arrUser['viewopt'] . "','" . $arrUser['keywords'] . "','" . $arrUser['infopage'] . "','".$arrUser['discountValue']."');";
//  End New viewopt Kent
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        ////////Slogen entry///////
        $sloganLangId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $sloganLangId . "','" . $arrUser['lang'] . "','" . $arrUser['offer_slogan_lang_list'] . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

        ////////Slogen entry///////
        $sloganLangId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $sloganLangId . "','" . $arrUser['lang'] . "','" . $arrUser['offer_slogan_lang_list'] . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
        ////////Sub Slogen entry///////
        $subSloganLangId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $subSloganLangId . "','" . $arrUser['lang'] . "','" . $arrUser['offer_sub_slogan_lang_list'] . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

        $couponId = uuid();
        // $query = "INSERT INTO coupon(`coupon_id`,`campaign_id`,`store_id`,`brand_name`, `small_image`, `large_image`, `is_sponsored`, `startValidity`, `endOfPublishing`, `offer_type`)
        //          VALUES ('".$couponId."','".$campaignId."','".$storeId."','".$arrUser['brand_name']."', '".$arrUser['small_image']."','".$arrUser['large_image']."','".$arrUser['spons']."','".$arrUser['start_time']."','".$arrUser['end_time']."','0');";
//  New viewopt Kent
        $query = "INSERT INTO coupon(`coupon_id`,`campaign_id`,`brand_name`, `small_image`, `large_image`, `is_sponsored`, `startValidity`, `endOfPublishing`,`view_opt`, `offer_type`)
                 VALUES ('" . $couponId . "','" . $campaignId . "','" . $arrUser['brand_name'] . "', '" . $catImg . "','" . $copImg . "','" . $arrUser['spons'] . "','" . $arrUser['start_of_publishing'] . "','" . $arrUser['end_of_publishing']  . "','" . $arrUser['viewopt'] . "','0');";
//  End New viewopt Kent

        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

        /// SLogen anf language table relation entry ////
        $_SQL = "insert into coupon_slogan_lang_list(`coupon_id`,`slogan_lang_list`) values('" . $couponId . "','" . $sloganLangId . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

        ///Sub slogan and language table relation entry ///
        $_SQL = "insert into coupon_sub_slogan_lang_list(`coupon_id`,`sub_slogan_lang_list`) values('" . $couponId . "','" . $subSloganLangId . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

        $_SESSION['MESSAGE'] = CAMPAIGN_OFFER_SUCCESS;
        //$_SESSION['REG_STEP'] = 3;
        $url = BASE_URL . 'main.php';
        $inoutObj->reDirect($url);
        exit();
    }

    /* Function Header : viewcampaignDetailById()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: View campaign Details related to a particular User.
     */

    function viewcampaignDetailById($campaignid, $lang='ENG') {
//echo "here ";echo $campaignid; echo "*".$lang ;die;
        $db = new db();

        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
        $data = array();
        $error = '';

        $q = $db->query("SELECT campaign.*,sloganT.text as slogan,subsloganT.text as subslogen,keyw.text as keyword, campaign.infopage,limit_period.*,lang_text.text as categoryName  FROM campaign
                        LEFT JOIN  campaign_offer_slogan_lang_list   ON  campaign_offer_slogan_lang_list.campaign_id = campaign.campaign_id
                        LEFT JOIN  campaign_keyword    ON  campaign_keyword.campaign_id = campaign.campaign_id
                        LEFT JOIN    campaign_offer_sub_slogan_lang_list    ON  campaign_offer_sub_slogan_lang_list.campaign_id = campaign.campaign_id
                        LEFT JOIN  lang_text as sloganT             ON  campaign_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
                        LEFT JOIN    lang_text as subsloganT        ON  campaign_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = subsloganT.id
                        LEFT JOIN  lang_text as keyw             ON  campaign_keyword.offer_keyword  = keyw.id
                        LEFT JOIN  campaign_limit_period_list       ON campaign_limit_period_list.campaign_id =  campaign.campaign_id
                        LEFT JOIN limit_period                      ON limit_period.limit_id=campaign_limit_period_list.limit_period_list
                        LEFT JOIN  category  ON category.category_id = campaign.category
                        LEFT JOIN  category_names_lang_list  ON category.category_id = category_names_lang_list.category
                        LEFT JOIN  lang_text  ON lang_text.id = category_names_lang_list.names_lang_list

                        WHERE  campaign.campaign_id='" . $campaignid . "' AND lang_text.lang = '" . $lang . "' AND lang_text.lang = subsloganT.lang AND lang_text.lang = subsloganT.lang AND
                         lang_text.lang = keyw.lang  GROUP BY campaign.campaign_id");
// Removed And restored ND lang_text.lang = subsloganT.lang
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
            // print_r($data);
        }

        $QUE = "select store.* from store left join c_s_rel
        on(c_s_rel.store_id = store.store_id)
        where c_s_rel.campaign_id ='" . $campaignid . "' AND activ='1'";
        $res = mysqli_query($conn , $QUE) or die(mysqli_error($conn));
        while ($row = mysqli_fetch_array($res)) {
            $storeDetails[] = $row;
        }
        $data['storeDetails'] = $storeDetails;
        //print_r($data['storeDetails']);
        //echo $_SESSION['userid'];
        return $data;
        // print_r ($data); die("hg");
    }

    function getUserAcceptName($acceptId='') {
        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $arrUser = array();
        $error = '';


        $query = "select * from user where u_id  = '" . $acceptId . "'";
        $res = mysqli_query($query);
        $rs = mysqli_fetch_array($res);
        $acceptname = $rs['fname'];
        return $acceptname;
    }

    function viewPublicCampaignDetailById($campaignid, $lang='ENG') {
//echo "here";echo $campaignid;die;
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $data = array();
        $error = '';

        $q = $db->query("SELECT campaign.*,sloganT.text as slogan,subsloganT.text as subslogen,keyw.text as keyword, campaign.infopage,limit_period.*,lang_text.text as categoryName  FROM campaign
                        LEFT JOIN  campaign_offer_slogan_lang_list   ON  campaign_offer_slogan_lang_list.campaign_id = campaign.campaign_id
                        LEFT JOIN  campaign_keyword    ON  campaign_keyword.campaign_id = campaign.campaign_id
                        LEFT JOIN    campaign_offer_sub_slogan_lang_list    ON  campaign_offer_sub_slogan_lang_list.campaign_id = campaign.campaign_id
                        LEFT JOIN  lang_text as sloganT             ON  campaign_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
                        LEFT JOIN    lang_text as subsloganT        ON  campaign_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = subsloganT.id
                        LEFT JOIN  lang_text as keyw             ON  campaign_keyword.offer_keyword  = keyw.id
                        LEFT JOIN  campaign_limit_period_list       ON campaign_limit_period_list.campaign_id =  campaign.campaign_id
                        LEFT JOIN limit_period                      ON limit_period.limit_id=campaign_limit_period_list.limit_period_list
                        LEFT JOIN  category  ON category.category_id = campaign.category
                        LEFT JOIN  category_names_lang_list  ON category.category_id = category_names_lang_list.category
                        LEFT JOIN  lang_text  ON lang_text.id = category_names_lang_list.names_lang_list

                        WHERE  campaign.campaign_id='" . $campaignid . "' AND lang_text.lang = '" . $lang . "' AND lang_text.lang = subsloganT.lang AND
                         lang_text.lang = sloganT.lang AND lang_text.lang = keyw.lang  GROUP BY campaign.campaign_id");
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
            // print_r($data);
        }

        $QUE = "select store.* from store left join c_s_rel
        on(c_s_rel.store_id = store.store_id)
        where c_s_rel.campaign_id ='" . $campaignid . "' AND activ='1' AND u_id ='" . $_SESSION['userid'] . "'";
        $res = mysqli_query($conn , $QUE) or die(mysqli_error($conn));
        while ($row = mysqli_fetch_array($res)) {
            $storeDetails[] = $row;
        }
        $data['storeDetails'] = $storeDetails;
        //print_r($data['storeDetails']);
        //echo $_SESSION['userid'];
        return $data;
        // print_r ($data); die("hg");
    }

    /* Function Header :editSaveCampaign()
     *             Args: $emailId
     *           Errors: none
     *     Return Value: none
     *      Description: To update all the details related to the Campaign Offer in the database.
     */

    function get_slogan($campaign_id, $slogan='slogan') {
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        //return  $campaign_id. $slogan;".$campaign_id."
        # $s = "SELECT * FROM `campaign_offer_slogan_lang_list` WHERE campaign_id = '4d19d77957782'";

        if ($slogan == 'subslogan') {
            $s = "SELECT offer_sub_slogan_lang_list FROM `campaign` c inner join campaign_offer_sub_slogan_lang_list cssll on
            c.campaign_id = cssll.campaign_id where c.campaign_id = '" . $campaign_id . "'";
            $q = $db->query($s);
            $rs = mysqli_fetch_array($q);
            return $rs['offer_sub_slogan_lang_list'];
        } else {
            $s = "SELECT offer_slogan_lang_list FROM `campaign` c inner join campaign_offer_slogan_lang_list cssll on
            c.campaign_id = cssll.campaign_id where c.campaign_id = '" . $campaign_id . "'";
            $q = $db->query($s);
            $rs = mysqli_fetch_array($q);
            return $rs['offer_slogan_lang_list'];
        }
    }

    /* Function Header :editSaveCampaignPreview()
     *             Args: $campaignid
     *           Errors: none
     *     Return Value: none
     *      Description: To edit and show preview for campaign.
     */

    function editSaveCampaignPreview($campaignid, $reseller='') {

        $db = new db();

        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $inoutObj = new inOut();

        // Url kept in the session variable..
        $_SESSION['postPayment'] = $_POST;
        $_SESSION['URL2'] = $_SERVER['PHP_SELF'] . "?campaignId=" . $campaignid;

        if ($reseller == '') {
            $query = "SELECT pre_loaded_value FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
            $rs_comp = mysqli_fetch_array($res);
            $rs_comp['pre_loaded_value'];
            if ($rs_comp['pre_loaded_value']) {
                //$_SESSION['userid'];
                $pre_loaded_value = $rs_comp['pre_loaded_value'];
            } else {
                $query = "SELECT pre_loaded_value FROM user as usr
          LEFT JOIN company as camp ON       (camp.company_id=usr.company_id)
         WHERE usr.u_id='" . $_SESSION['userid'] . "'";
                $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
                $rs_comp = mysqli_fetch_array($res);
                $pre_loaded_value = $rs_comp['pre_loaded_value'];
                //$rs['new_pre_loaded_value'];
            }

            if ($_POST['sponsor'] == 1) {
                if (($pre_loaded_value == '0' || $pre_loaded_value == null)) {
                    $_SESSION['MESSAGE2'] = CRADIT_YOUR_ACCOUNT;


                    $url = BASE_URL . 'editCampaign.php?campaignId=' . $campaignid . "&ldacc=1";
                    $inoutObj->reDirect($url);
                    exit();
                }
            }
        }


        $_SESSION['campaign_for_edit'] = serialize($_POST);

        if ($_FILES['picture']['name'] <> '') {
            #$_SESSION['preview']['edit_large_image'] = '1';
            // $_SESSION['preview']['large_image'] = $_FILES['picture']['name']; //<> '' ? $_FILES['picture']['name'] : $_POST['largeimage']['name'] ;
        }
        $_SESSION['preview']['campaignId'] = $_POST['campaignId'];

        $_SESSION['preview']['lang'] = $_POST['lang'];
        $_SESSION['preview']['offer_slogan_lang_list'] = $_POST['titleSlogan'];
        $_SESSION['preview']['offer_sub_slogan_lang_list'] = $_POST['subSlogan'];
        $_SESSION['preview']['campaignId'] = $campaignid;
        $_SESSION['preview']['linkedCat'] = $_POST['linkedCat'];
        $_SESSION['preview']['startDateLimitation'] = $_POST['startDateLimitation'];
        $_SESSION['preview']['endDateLimitation'] = $_POST['endDateLimitation'];

        //// Upload Coupen image//////
        $CategoryIconName = "cat_icon_" . md5(time());
        $info = pathinfo($_FILES["icon"]["name"]);
        if (!empty($_FILES["icon"]["name"])) {
            // echo "Cat in";
            // die();
            if (!empty($_FILES["icon"]["name"])) {

                if (strtolower($info['extension']) == "png") {
                    if ($_FILES["icon"]["error"] > 0) {
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
            $category_image = $_POST["category_image"];
            if (!empty($category_image)) {

                $categoryImageName = explode(".", $category_image);
                $cat_filename = $CategoryIconName . "." . $categoryImageName[1];
                $fileOriginal = UPLOAD_DIR . "category_lib/" . $category_image;
                $path = UPLOAD_DIR . "category/";
                $fileThumbnail = $path . $cat_filename;
                copy($fileOriginal, $fileThumbnail);
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
        //echo $_FILES["picture"]["name"]; die();
/////////////////////////// upload smallimages into server///////////////////
        $file1 = _UPLOAD_IMAGE_ . 'category/' . $arrUser['small_image'];
        $dir1 = "category";
        $command = IMAGE_DIR_PATH . $file1 . " " . $dir1;
        system($command);


        $coupenName = "cpn_" . md5(time());
        $info = pathinfo($_FILES["picture"]["name"]);
        if (!empty($_FILES["picture"]["name"])) {

            if (strtolower($info['extension']) == "jpg" || strtolower($info['extension']) == "png" || strtolower($info['extension']) == "jpeg" || $file_extension == "gif" || $file_extension == "bmp") {
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
                }  //echo  $_SESSION['preview']['large_image']; die();
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
        $q = $this->editSaveCampaign($campaignid, $reseller);

//        //echo $_SESSION['preview']['large_image']; die();
//        $url = BASE_URL . 'editCampaignPreview.php?campaignId=' . $campaignid;
//        $inoutObj->reDirect($url);
        // exit();
    }

    function editSaveCampaign($campaignid, $reseller='') {
        //echo "tttt";die;
        extract(((unserialize($_SESSION['campaign_for_edit']))));
        // extract(((unserialize($_SESSION['campaign_for_edit_image']))));
        //echo "sasadas"; die();
        $inoutObj = new inOut();
        $db = new db();

        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
        $arrUser = array();
        $error = '';


        $arrUser['offer_slogan_lang_list'] = addslashes($titleSlogan);
        $arrUser['offer_sub_slogan_lang_list'] = addslashes($subSlogan);
        #$arrUser['small_image'] = $icon;
        if ($_POST['icon'] == "") {
            $arrUser['small_image'] = $_POST['category_image'];
        } else {
            $arrUser['small_image'] = $_POST['icon'];
        }
        $arrUser['spons'] = $sponsor;
        $arrUser['category'] = $linkedCat;
        $arrUser['start_of_publishing'] = $startDate;
        $arrUser['end_of_publishing'] = $endDate;
        $arrUser['campaign_name'] = addslashes($campaignName);
        $arrUser['keywords'] = addslashes($searchKeyword);
        $arrUser['start_time'] = $startDateLimitation;
        $arrUser['end_time'] = $endDateLimitation;
        $arrUser['infopage'] = $descriptive;
        $arrUser['language'] = $_POST['lang'];
        // string matching
        if ($arrUser['infopage']) {
            $filestring = $arrUser['infopage'];
            $findme = 'http://';
            $pos = strpos($filestring, $findme);
            if ($pos === false) {
                $arrUser['infopage'] = 'http://' . $filestring;
            } else {
                $arrUser['infopage'] = $filestring;
            }
        }
        $arrUser['valid_day'] = $limitDays;
        $arrUser['lang'] = $lang;


        $arrUser['codes'] = $_POST['codes'];
        //$arrUser['ccode'] = $_POST['ccode'];

        if ($arrUser['codes'] == '') {
            $arrUser['etanCode'] = '';
        } else {
             if(($_POST['pinCode']!='') && ($arrUser['codes'] == 'PINCODE'))
            {
            $arrUser['etanCode'] = $_POST['pinCode'];
            }
             if(($_POST['etanCode']!='') && ($arrUser['codes'] == 'GTIN13'))
             {
            $arrUser['etanCode'] = $_POST['etanCode'];
             }
        }
//echo $arrUser['etanCode'];die();


//    echo $arrUser['start_time'];
//    echo $arrUser['end_time'];
//    echo $arrUser['valid_day'];
//    die();

        $error.= ( $arrUser['offer_slogan_lang_list'] == '') ? ERROR_TITLE_SLOGAN : '';

        $error.= ( $arrUser['offer_sub_slogan_lang_list'] == '') ? ERROR_SUB_SLOGAN : '';

        $error.= ( $arrUser['spons'] == '') ? ERROR_SPONSORS : '';

        $error.= ( $arrUser['category'] == '') ? ERROR_CATEGORY : '';

        $error.= ( $arrUser['start_of_publishing'] == '') ? ERROR_START_OF_PUBLISHING : '';

        $error.= ( $arrUser['end_of_publishing'] == '') ? ERROR_END_OF_PUBLISHING : '';

        $error.= ( $arrUser['campaign_name'] == '') ? ERROR_CAMPAIGN_NAME : '';

//        $error.= ( $arrUser['start_time'] == '') ? ERROR_START_DATE : '';
//
//        $error.= ( $arrUser['end_time'] == '') ? ERROR_END_DATE : '';
//
//        $error.= ( $arrUser['valid_day'] == '') ? ERROR_LIMIT_DAYS : '';
        //echo $error; die();

        $_SESSION['post'] = "";
        //echo $_FILES['icon']['size']."_".(500*1024); die();


        $CategoryIconName = "cat_icon_" . md5(time());
        $info = pathinfo($_FILES["icon"]["name"]);

        if (!empty($_FILES["icon"]["name"])) {

            if (!empty($_FILES["icon"]["name"])) {

                if (strtolower($info['extension']) == "png") {
                    if ($_FILES["icon"]["error"] > 0) {
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

            //print_r($_SESSION['preview']);
            //echo $_POST['smallimage']."iiiiiii".$category_image = $_POST["category_image"]; die();
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
            //echo "Cat Resp icon"; die();
        }

        /////////////////////////// upload smallimages into server///////////////////
        $file1 = _UPLOAD_IMAGE_ . 'category/' . $arrUser['small_image'];
        $dir1 = "category";
        $command = IMAGE_DIR_PATH . $file1 . " " . $dir1;
        system($command);

        //echo "End UPLOAD"; die();
        //// Upload Coupen image//////
        $coupenName = "cpn_" . md5(time());
        $info = pathinfo($_FILES["picture"]["name"]);


        //echo "Cat in".$_SESSION['preview']['large_image']; die();
        $arrUser['large_image'] = $_SESSION['preview']['large_image'];
        $_SESSION['preview'] = $arrUser;
        //echo $arrUser['small_image'].$error;  die();
        if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            if ($reseller == '') {
                $url = BASE_URL . 'editCampaign.php?campaignId=' . $campaignid;
                $inoutObj->reDirect($url);
                exit();
            } else {
                $url = BASE_URL . 'editCampaign.php?campaignId=' . $campaignid . "&from=reseller";
                $inoutObj->reDirect($url);
                exit();
            }
        }
//        $preview = 0;
//        if ($preview == 1) {
//            $_SESSION['preview'] = $arrUser;
//            $_SESSION['post'] = $_POST;
//            $url = BASE_URL . 'editCampaignPreview.php?campaignId=' . $campaignid;
//            $inoutObj->reDirect($url);
//            exit();
//        }
        $catImg = IMAGE_AMAZON_PATH . 'category/' . $arrUser['small_image'];
        $copImg = IMAGE_AMAZON_PATH . 'coupon/' . $arrUser['large_image'];

        ////////////////start date is more than current date
        $t = date("Y-m-d");

        if ($arrUser['start_of_publishing'] > $t) {

            $query = "select * from c_s_rel  where campaign_id = '" . $campaignid . "'";
            $res1 = mysqli_query($conn , $query) or die(mysqli_error($conn));
            while ($rs = mysqli_fetch_array($res1)) {
                $couponId = $rs['coupon_id'];

                if ($couponId) {

                    /////delete coupon
                    $query = "DELETE FROM coupon WHERE coupon_id = '" . $couponId . "'";
                    $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

                    $query = "select * from coupon_limit_period_list  where coupon = '" . $couponId . "'";
                    $res = mysqli_query($conn , $query) or die('1' . mysqli_error($conn));
                    $rs = mysqli_fetch_array($res);
                    $limitId = $rs['limit_period_list'];


                    $_SQL = "DELETE FROM coupon_limit_period_list WHERE coupon = '" . $couponId . "' AND limit_period_list = '" . $limitId . "' ";
                    $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

                  //  $_SQL = "DELETE FROM limit_period WHERE limit_id = '" . $limitId . "'";
                  //  $res = mysql_query($_SQL) or die(mysql_error());

                    $query = "select * from coupon_offer_slogan_lang_list  where coupon = '" . $couponId . "'";
                    $res = mysqli_query($conn , $query) or die('1' . mysqli_error($conn));
                    while ($rs = mysqli_fetch_array($res)) {
                        $offslogen = $rs['offer_slogan_lang_list'];

                        $_SQL1 = "DELETE FROM coupon_offer_slogan_lang_list WHERE coupon = '" . $couponId . "'";
                        $res1 = mysqli_query($conn , $_SQL1) or die(mysqli_error($conn));

                       // $_SQL2 = "DELETE FROM lang_text WHERE id = '" . $offslogen . "'";
                       // $res2 = mysql_query($_SQL2) or die(mysql_error());
                    }


                    $query = "select * from coupon_offer_title_lang_list  where coupon = '" . $couponId . "'";
                    $res = mysqli_query($conn , $query) or die('1' . mysqli_error($conn));
                    while ($rs = mysqli_fetch_array($res)) {
                        $offtitle = $rs['offer_title_lang_list'];

                        $_SQL1 = "DELETE FROM coupon_offer_title_lang_list WHERE coupon = '" . $couponId . "'";
                        $res1 = mysqli_query($conn , $_SQL1) or die(mysqli_error($conn));

                      //  $_SQL2 = "DELETE FROM lang_text WHERE id = '" . $offtitle . "'";
                      //  $res2 = mysql_query($_SQL2) or die(mysql_error());
                    }

                    $query = "select * from coupon_keywords_lang_list  where coupon = '" . $couponId . "'";
                    $res = mysqli_query($conn , $query) or die('1' . mysqli_error($conn));
                    while ($rs = mysqli_fetch_array($res)) {
                        $ckeyword = $rs['keywords_lang_list'];

                        $_SQL1 = "DELETE FROM coupon_keywords_lang_list WHERE coupon = '" . $couponId . "'";
                        $res1 = mysqli_query($conn , $_SQL1) or die(mysqli_error($conn));

                     //   $_SQL2 = "DELETE FROM lang_text WHERE id = '" . $ckeyword . "'";
                     //   $res2 = mysql_query($_SQL2) or die(mysql_error());
                    }

                    //////update c_s_rel
                    $_SQL = "UPDATE c_s_rel SET activ='2', start_of_publishing = '" . $arrUser['start_of_publishing'] . "', `end_of_publishing` = '" . $arrUser['end_of_publishing'] . "' WHERE campaign_id = '" . $campaignId . "'";
                    $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
                }
            }
            //////update campaign
            //common function update


            $query = "select * from campaign_limit_period_list  where campaign_id = '" . $campaignid . "'";
            $res = mysqli_query($conn , $query) or die('1' . mysqli_error($conn));
            $rs = mysqli_fetch_array($res);
            $limitId = $rs['limit_period_list'];
            $query = "UPDATE campaign SET category = '" . $arrUser['category'] . "',spons = '" . $arrUser['spons'] . "',campaign_name = '" . $arrUser['campaign_name'] . "',infopage = '" . $arrUser['infopage'] . "', start_of_publishing = '" . $arrUser['start_of_publishing'] . "', end_of_publishing = '" . $arrUser['end_of_publishing'] . "', code = '" . $arrUser['etanCode'] . "', code_type = '" . $arrUser['codes'] . "'  WHERE campaign_id = '" . $campaignid . "'";
            $res = mysqli_query($conn , $query) or die('2' . mysqli_error($conn));

            if ($arrUser['codes'] == '') {
                $query = "update campaign set `code` = NULL,`code_type` = NULL where campaign_id = '" . $campaignId . "'";
                $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
            }


            if ($arrUser['valid_day'] != '') {
                if ($limitId) {
                    $query = "UPDATE limit_period SET `end_time` = '" . $arrUser['end_time'] . "', `start_time` = '" . $arrUser['start_time'] . "', `valid_day` = '" . $arrUser['valid_day'] . "'  WHERE limit_id = '" . $limitId . "'";
                    $res = mysqli_query($conn , $query) or die('5' . mysqli_error($conn));
                } else {

                    $limitId = uuid();
                    $_SQL = "insert into limit_period(`limit_id`,`end_time`,`start_time`,`valid_day`) values('" . $limitId . "','" . $arrUser['end_time'] . "','" . $arrUser['start_time'] . "','" . $arrUser['valid_day'] . "')";
                    $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

                    ///RElation between LImit Period list and Coupon ///
                    $_SQL = "insert into campaign_limit_period_list(`campaign_id`,`limit_period_list`) values('" . $campaignId . "','" . $limitId . "')";
                    $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
                }
            } else {
                $_SQL = "DELETE FROM campaign_limit_period_list WHERE campaign_id = '" . $campaignId . "'";
                $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

                $_SQL = "DELETE FROM limit_period WHERE limit_id = '" . $limitId . "'";
                $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
            }


            //echo $icon; die();
            if ($icon <> '' || $category_image <> '') {
                // rename(UPLOAD_DIR . "coupon/" . $_SESSION['preview']['small_image'], UPLOAD_DIR . "category/" . substr($_SESSION['preview']['small_image'], 5));


                $query = "UPDATE campaign SET  `small_image` = '" . $catImg . "' WHERE campaign_id= '" . $campaignid . "'";
                $res = mysqli_query($conn , $query) or die('6' . mysqli_error($conn));
            }

            //echo $_SESSION['preview']['large_image']; die();
            if ($_SESSION['preview']['large_image'] <> '') {
                //rename(UPLOAD_DIR . "coupon/" . $_SESSION['preview']['large_image'], UPLOAD_DIR . "coupon/" . substr($_SESSION['preview']['large_image'], 5));


                $query = "UPDATE campaign SET  large_image = '" . $copImg . "' WHERE campaign_id = '" . $campaignid . "'";
                $res = mysqli_query($conn , $query) or die('7' . mysqli_error($conn));
            }

            ////diferent language function update
            //for keywords
            $query = "select lang_text.text,lang_text.id from campaign_keyword LEFT JOIN lang_text ON campaign_keyword.offer_keyword = lang_text.id  where campaign_keyword.campaign_id = '" . $campaignid . "' AND lang_text.lang = '" . $arrUser['language'] . "'";
            $res = mysqli_query($conn , $query) or die('1' . mysqli_error($conn));
            while ($rs = mysqli_fetch_array($res)) {
                $keyId = $rs['id'];
            }

            //echo $keyId;
            //echo $keyText;die();
            $query = "UPDATE lang_text SET `text` = '" . $arrUser['keywords'] . "'  WHERE id = '" . $keyId . "' AND  lang = '" . $arrUser['language'] . "' ";
            $res = mysqli_query($conn , $query) or die('3' . mysqli_error($conn));

            // for title slogen


            $query = "select lang_text.text,lang_text.id from campaign_offer_slogan_lang_list LEFT JOIN lang_text ON campaign_offer_slogan_lang_list.offer_slogan_lang_list = lang_text.id  where campaign_offer_slogan_lang_list.campaign_id = '" . $campaignid . "' AND lang_text.lang = '" . $arrUser['language'] . "'";
            $res = mysqli_query($conn , $query) or die('2' . mysqli_error($conn));
            while ($rs = mysqli_fetch_array($res)) {
                $titleId = $rs['id'];
            }
            $query = "UPDATE lang_text SET `text` = '" . $arrUser['offer_slogan_lang_list'] . "' WHERE id = '" . $titleId . "' AND  lang = '" . $arrUser['language'] . "'";
            $res = mysqli_query($conn , $query) or die('3' . mysqli_error($conn));

            // for sub slogen

            $query = "select lang_text.text,lang_text.id from campaign_offer_sub_slogan_lang_list LEFT JOIN lang_text ON campaign_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = lang_text.id  where campaign_offer_sub_slogan_lang_list.campaign_id = '" . $campaignid . "' AND lang_text.lang = '" . $arrUser['language'] . "'";
            $res = mysqli_query($conn , $query) or die('2' . mysqli_error($conn));
            while ($rs = mysqli_fetch_array($res)) {
                $subSlogenId = $rs['id'];
            }
            $query = "UPDATE lang_text SET `text` = '" . $arrUser['offer_sub_slogan_lang_list'] . "' WHERE id = '" . $subSlogenId . "' AND  lang = '" . $arrUser['language'] . "'";
            $res = mysqli_query($conn , $query) or die('3' . mysqli_error($conn));




            ///////update c_s_rel



            $query = "UPDATE c_s_rel SET  start_of_publishing = '" . $arrUser['start_of_publishing'] . "', `end_of_publishing` = '" . $arrUser['end_of_publishing'] . "'  WHERE campaign_id = '" . $campaignid . "'";
            $res = mysqli_query($conn , $query) or die('7' . mysqli_error($conn));
        }

        //////if start date less than or equal to current date///////////
        if ($arrUser['start_of_publishing'] <= $t) {

            ///////////update campaign
            //common function update


            $query = "select * from campaign_limit_period_list  where campaign_id = '" . $campaignid . "'";
            $res = mysqli_query($conn , $query) or die('1' . mysqli_error($conn));
            $rs = mysqli_fetch_array($res);
            $limitId = $rs['limit_period_list'];
            $query = "UPDATE campaign SET category = '" . $arrUser['category'] . "',spons = '" . $arrUser['spons'] . "',campaign_name = '" . $arrUser['campaign_name'] . "',infopage = '" . $arrUser['infopage'] . "', start_of_publishing = '" . $arrUser['start_of_publishing'] . "', end_of_publishing = '" . $arrUser['end_of_publishing'] . "', code = '" . $arrUser['etanCode'] . "', code_type = '" . $arrUser['codes'] . "'  WHERE campaign_id = '" . $campaignid . "'";
            $res = mysqli_query($conn , $query) or die('2' . mysqli_error($conn));

            if ($arrUser['codes'] == '') {
                $query = "update campaign set `code` = NULL,`code_type` = NULL where campaign_id = '" . $campaignId . "'";
                $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
            }



            if ($arrUser['valid_day'] != '') {
                if ($limitId) {

                    $query = "UPDATE limit_period SET `end_time` = '" . $arrUser['end_time'] . "', `start_time` = '" . $arrUser['start_time'] . "', `valid_day` = '" . $arrUser['valid_day'] . "'  WHERE limit_id = '" . $limitId . "'";
                    $res = mysqli_query($conn , $query) or die('5' . mysqli_error($conn));
                } else {

                    $limitId = uuid();
                    $_SQL = "insert into limit_period(`limit_id`,`end_time`,`start_time`,`valid_day`) values('" . $limitId . "','" . $arrUser['end_time'] . "','" . $arrUser['start_time'] . "','" . $arrUser['valid_day'] . "')";
                    $res = mysqli_query($conn , $_SQL) or die(mysql_error($conn));

                    ///RElation between LImit Period list and Coupon ///
                    $_SQL = "insert into campaign_limit_period_list(`campaign_id`,`limit_period_list`) values('" . $campaignId . "','" . $limitId . "')";
                    $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
                }
            } else {
                $_SQL = "DELETE FROM campaign_limit_period_list WHERE campaign_id = '" . $campaignId . "'";
                $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

                $_SQL = "DELETE FROM limit_period WHERE limit_id = '" . $limitId . "'";
                $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
            }


            //echo $icon; die();
            if ($icon <> '' || $category_image <> '') {
                // rename(UPLOAD_DIR . "coupon/" . $_SESSION['preview']['small_image'], UPLOAD_DIR . "category/" . substr($_SESSION['preview']['small_image'], 5));


                $query = "UPDATE campaign SET  `small_image` = '" . $catImg . "' WHERE campaign_id= '" . $campaignid . "'";
                $res = mysqli_query($conn , $query) or die('6' . mysqli_error($conn));
            }

            //echo $_SESSION['preview']['large_image']; die();
            if ($_SESSION['preview']['large_image'] <> '') {
                //rename(UPLOAD_DIR . "coupon/" . $_SESSION['preview']['large_image'], UPLOAD_DIR . "coupon/" . substr($_SESSION['preview']['large_image'], 5));


                $query = "UPDATE campaign SET  large_image = '" . $copImg . "' WHERE campaign_id = '" . $campaignid . "'";
                $res = mysqli_query($conn , $query) or die('7' . mysqli_error($conn));
            }

            ////diferent language function update
            //for keywords
            $query = "select lang_text.text,lang_text.id from campaign_keyword LEFT JOIN lang_text ON campaign_keyword.offer_keyword = lang_text.id  where campaign_keyword.campaign_id = '" . $campaignid . "' AND lang_text.lang = '" . $arrUser['language'] . "'";
            $res = mysqli_query($conn , $query) or die('1' . mysqli_error($conn));
            while ($rs = mysqli_fetch_array($res)) {
                $keyId = $rs['id'];
                $query = "UPDATE lang_text SET `text` = '" . $arrUser['keywords'] . "'  WHERE id = '" . $keyId . "' AND  lang = '" . $arrUser['language'] . "' ";
                $res = mysqli_query($conn , $query) or die('3' . mysqli_error($conn));
            }
            // for title slogen


            $query = "select lang_text.text,lang_text.id from campaign_offer_slogan_lang_list LEFT JOIN lang_text ON campaign_offer_slogan_lang_list.offer_slogan_lang_list = lang_text.id  where campaign_offer_slogan_lang_list.campaign_id = '" . $campaignid . "' AND lang_text.lang = '" . $arrUser['language'] . "'";
            $res = mysqli_query($conn , $query) or die('2' . mysqli_error($conn));
            while ($rs = mysqli_fetch_array($res)) {
                $titleId = $rs['id'];


                $query = "UPDATE lang_text SET `text` = '" . $arrUser['offer_slogan_lang_list'] . "' WHERE id = '" . $titleId . "' AND  lang = '" . $arrUser['language'] . "'";
                $res = mysqli_query($conn , $query) or die('3' . mysqli_error($conn));
            }
            // for sub slogen

            $query = "select lang_text.text,lang_text.id from campaign_offer_sub_slogan_lang_list LEFT JOIN lang_text ON campaign_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = lang_text.id  where campaign_offer_sub_slogan_lang_list.campaign_id = '" . $campaignid . "' AND lang_text.lang = '" . $arrUser['language'] . "'";
            $res = mysqli_query($conn , $query) or die('2' . mysqli_error($conn));
            while ($rs = mysqli_fetch_array($res)) {
                $subSlogenId = $rs['id'];


                $query = "UPDATE lang_text SET `text` = '" . $arrUser['offer_sub_slogan_lang_list'] . "' WHERE id = '" . $subSlogenId . "' AND  lang = '" . $arrUser['language'] . "'";
                $res = mysqli_query($conn , $query) or die('3' . mysqli_error($conn));
            }



            //////////////update c_s_rel/////////////

            $query = "UPDATE c_s_rel SET  start_of_publishing = '" . $arrUser['start_of_publishing'] . "', `end_of_publishing` = '" . $arrUser['end_of_publishing'] . "'  WHERE campaign_id = '" . $campaignid . "'";
            $res = mysqli_query($conn , $query) or die('7' . mysqli_error($conn));

            //////////////update coupon/////////////
            //common function update coupon
//            $query = "select * from c_s_rel  where campaign_id = '" . $campaignid . "'";
//            $res1 = mysql_query($query) or die(mysql_error());
//            $rs = mysql_fetch_array($res1);
//            $couponId = $rs['coupon_id'];


            $query = "select * from c_s_rel  where campaign_id = '" . $campaignid . "'";
            $res1 = mysqli_query($conn , $query) or die(mysqli_error($conn));
            while ($rs1 = mysqli_fetch_array($res1)) {
                $couponId = $rs1['coupon_id'];

                //echo $couponId;echo '-------';

                $query = "select * from coupon_limit_period_list  where coupon = '" . $couponId . "'";
                $res = mysqli_query($conn , $query) or die('1' . mysqli_error($conn));
                $rs = mysqli_fetch_array($res);
                $limitId = $rs['limit_period_list'];

                $query = "UPDATE coupon SET category = '" . $arrUser['category'] . "',is_sponsored = '" . $arrUser['spons'] . "', valid_from = '" . $arrUser['start_of_publishing'] . "', end_of_publishing = '" . $arrUser['end_of_publishing'] . "', product_info_link = '" . $arrUser['infopage'] . "', code = '" . $arrUser['etanCode'] . "', code_type = '" . $arrUser['codes'] . "'  WHERE coupon_id = '" . $couponId . "'";
                $res = mysqli_query($conn , $query) or die('2' . mysqli_error($conn));

                if ($arrUser['codes'] == '') {
                    $query = "update coupon set `code` = NULL,`code_type` = NULL where coupon_id = '" . $couponId . "'";
                    $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
                }


                if ($arrUser['valid_day'] != '') {
                    if ($limitId) {
                        $query = "UPDATE limit_period SET `end_time` = '" . $arrUser['end_time'] . "', `start_time` = '" . $arrUser['start_time'] . "', `valid_day` = '" . $arrUser['valid_day'] . "'  WHERE limit_id = '" . $limitId . "'";
                        $res = mysqli_query($conn, $query) or die('5' . mysqli_error($conn));
                    } else {

                        //                           $limitId = uuid();
                        $_SQL = "select limit_period_list from campaign_limit_period_list where campaign_id = '" . $campaignid . "'";
                        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
                        $rs = mysqli_fetch_array($res);
                        $limitId = $rs['limit_period_list'];

                        ///RElation between LImit Period list and Coupon ///
                        $_SQL = "insert into coupon_limit_period_list(`coupon`,`limit_period_list`) values('" . $couponId . "','" . $limitId . "')";
                        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
                    }
                } else {
                    $_SQL = "DELETE FROM coupon_limit_period_list WHERE coupon = '" . $couponId . "'";
                    $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

                    $_SQL = "DELETE FROM limit_period WHERE limit_id = '" . $limitId . "'";
                    $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
                }


                //echo $icon; die();
                if ($icon <> '' || $category_image <> '') {
                    // rename(UPLOAD_DIR . "coupon/" . $_SESSION['preview']['small_image'], UPLOAD_DIR . "category/" . substr($_SESSION['preview']['small_image'], 5));


                    $query = "UPDATE coupon SET  `small_image` = '" . $catImg . "' WHERE coupon_id= '" . $couponId . "'";
                    $res = mysqli_query($conn , $query) or die('6' . mysqli_error($conn));
                }

                //echo $_SESSION['preview']['large_image']; die();
                if ($_SESSION['preview']['large_image'] <> '') {
                    //rename(UPLOAD_DIR . "coupon/" . $_SESSION['preview']['large_image'], UPLOAD_DIR . "coupon/" . substr($_SESSION['preview']['large_image'], 5));


                    $query = "UPDATE coupon SET  large_image = '" . $copImg . "' WHERE coupon_id = '" . $couponId . "'";
                    $res = mysqli_query($conn , $query) or die('7' . mysqli_error($conn));
                }

                ////diferent language function update in coupon
                //update keywords for coupon
                $query = "select lang_text.text,lang_text.id from coupon_keywords_lang_list LEFT JOIN lang_text ON coupon_keywords_lang_list.keywords_lang_list = lang_text.id  where coupon_keywords_lang_list.coupon = '" . $couponId . "' AND lang_text.lang = '" . $arrUser['language'] . "'";
                $res = mysqli_query($conn , $query) or die('1' . mysqli_error($conn));
                while ($rs = mysqli_fetch_array($res)) {
                    $keyId = $rs['id'];
                }

                $query = "UPDATE lang_text SET `text` = '" . $arrUser['keywords'] . "'  WHERE id = '" . $keyId . "' AND  lang = '" . $arrUser['language'] . "' ";
                $res = mysqli_query($conn , $query) or die('3' . mysqli_error($conn));

                // for title slogen for coupon


                $query = "select lang_text.text,lang_text.id from coupon_offer_title_lang_list LEFT JOIN lang_text ON coupon_offer_title_lang_list.offer_title_lang_list = lang_text.id  where coupon_offer_title_lang_list.coupon = '" . $couponId . "' AND lang_text.lang = '" . $arrUser['language'] . "'";
                $res = mysqli_query($conn , $query) or die('2' . mysqli_error($conn));
                while ($rs = mysqli_fetch_array($res)) {
                    $titleId = $rs['id'];
                }
                $query = "UPDATE lang_text SET `text` = '" . $arrUser['offer_slogan_lang_list'] . "' WHERE id = '" . $titleId . "' AND  lang = '" . $arrUser['language'] . "'";
                $res = mysqli_query($conn , $query) or die('3' . mysqli_error($conn));

                // for sub slogen for coupon

                $query = "select lang_text.text,lang_text.id from coupon_offer_slogan_lang_list LEFT JOIN lang_text ON coupon_offer_slogan_lang_list.offer_slogan_lang_list = lang_text.id  where coupon_offer_slogan_lang_list.coupon = '" . $couponId . "' AND lang_text.lang = '" . $arrUser['language'] . "'";
                $res = mysqli_query($conn , $query) or die('2' . mysqli_error($conn));
                while ($rs = mysqli_fetch_array($res)) {
                    $subSlogenId = $rs['id'];
                }
                $query = "UPDATE lang_text SET `text` = '" . $arrUser['offer_sub_slogan_lang_list'] . "' WHERE id = '" . $subSlogenId . "' AND  lang = '" . $arrUser['language'] . "'";
                $res = mysqli_query($conn , $query) or die('3' . mysqli_error($conn));
            }
        }

        $_SESSION['MESSAGE'] = CAMPAIGN_OFFER_SUCCESS;
        
       
        if ($reseller == '') {
            $url = BASE_URL . 'showCampaign.php';
            // $url = BASE_URL.'editCampaignPreview.php?campaignId='.$campaignid;
            $inoutObj->reDirect($url);
            exit();
        } else {
            $url = BASE_URL . 'showResellerCampaign.php';
            // $url = BASE_URL.'editCampaignPreview.php?campaignId='.$campaignid;
            $inoutObj->reDirect($url);
            exit();
        }
    }

    function editSaveProductPreview($productid, $reseller='') {
        //echo $productid;die;
        //print_r($_POST);die();
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
                //$rs['new_pre_loaded_value'];
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
//echo 'k';die();
            if (strtolower($info['extension']) == "jpg" || strtolower($info['extension']) == "png" || strtolower($info['extension']) == "jpeg" || $file_extension == "gif" || $file_extension == "bmp") {
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
        //echo $file2;die();
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

            $file_extension = strtolower($info['extension']);
                if ($file_extension == "png" || $file_extension == "jpg" || $file_extension == "jpeg" || $file_extension == "gif" || $file_extension == "bmp") {
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

    function deleteCampaign() {
        ///////////////////

        $campaignid = $_REQUEST['campaignId'];
        $reseller = $_REQUEST['reseller'];
        $db = new db();

        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
        $inoutObj = new inOut();




        $query16 = "select * from c_s_rel  where campaign_id = '" . $campaignid . "'";
        $res16 = mysqli_query($conn , $query16) or die(mysqli_error($conn));
        while ($rs16 = mysqli_fetch_array($res16)) {
            $couponId = $rs16['coupon_id'];
            $campaignId = $rs16['campaign_id'];
            $storeId = $rs16['store_id'];

            if ($campaignId) {
                $_SQL14 = "UPDATE c_s_rel SET activ='2' WHERE campaign_id = '" . $campaignId . "'";
                $res14 = mysqli_query($conn , $_SQL14) or die(mysqli_error($conn));
            }

            if ($couponId) {
                /////delete coupon
                $query1 = "DELETE FROM coupon WHERE coupon_id = '" . $couponId . "'";
                $res1 = mysqli_query($conn , $query1) or die(mysqli_error($conn));

                $query2 = "select * from coupon_limit_period_list  where coupon = '" . $couponId . "'";
                $res2 = mysqli_query($conn , $query2) or die('1' . mysqli_error($conn));
                $rs2 = mysqli_fetch_array($res2);
                $limitId = $rs2['limit_period_list'];


                $_SQL3 = "DELETE FROM coupon_limit_period_list WHERE coupon = '" . $couponId . "' AND limit_period_list = '" . $limitId . "' ";
                $res3 = mysqli_query($conn , $_SQL3) or die(mysqli_error($conn));

                $query5 = "select * from coupon_offer_slogan_lang_list  where coupon = '" . $couponId . "'";
                $res5 = mysqli_query($conn , $query5) or die('1' . mysqli_error($conn));
                while ($rs5 = mysqli_fetch_array($res5)) {
                    $offslogen = $rs5['offer_slogan_lang_list'];
                    $_SQL6 = "DELETE FROM coupon_offer_slogan_lang_list WHERE coupon = '" . $couponId . "'";
                    $res6 = mysqli_query($conn , $_SQL6) or die(mysqli_error($conn));
                }


                $query8 = "select * from coupon_offer_title_lang_list  where coupon = '" . $couponId . "'";
                $res8 = mysqli_query($conn , $query8) or die('1' . mysqli_error($conn));
                while ($rs8 = mysqli_fetch_array($res8)) {
                    $offtitle = $rs8['offer_title_lang_list'];

                    $_SQL9 = "DELETE FROM coupon_offer_title_lang_list WHERE coupon = '" . $couponId . "'";
                    $res9 = mysqli_query($conn , $_SQL9) or die(mysqli_error($conn));
                }

                $query11 = "select * from coupon_keywords_lang_list  where coupon = '" . $couponId . "'";
                $res11 = mysqli_query($conn , $query11) or die('1' . mysqli_error($conn));
                while ($rs11 = mysqli_fetch_array($res11)) {
                    $ckeyword = $rs11['keywords_lang_list'];

                    $_SQL12 = "DELETE FROM coupon_keywords_lang_list WHERE coupon = '" . $couponId . "'";
                    $res12 = mysqli_query($conn , $_SQL12) or die(mysqli_error($conn));
                }
            }
        }

        $_SQL15 = "UPDATE campaign SET s_activ='2' WHERE campaign_id='" . $campaignid . "'";
        $q = $db->query($_SQL15);
        if ($reseller == '') {
            $url = BASE_URL . 'showCampaign.php';
        } else {
            $url = BASE_URL . 'showResellerCampaign.php';
        }
        $inoutObj->reDirect($url);
        exit();
    }

    function showcampoffer($paging_limit='0 , 10') {
        $db = new db();

        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
        $data = array();

        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['ke'])) {
            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'campaign.keywords LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
            if ($_REQUEST['key']) {
                $set_keywords.= 'subsloganT.text LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }
            if ($_REQUEST['ke']) {
                $set_keywords.= 'sloganT.text LIKE "%' . trim($_REQUEST['ke']) . '%" AND ';
            }
        }
        else
            $set_keywords = " 1 AND";


        $QUE = "SELECT campaign.*,sloganT.text as slogan,subsloganT.text as subslogen,keyw.text as keyword, campaign.infopage,lang_text.text as category  FROM campaign
                        LEFT JOIN   campaign_offer_slogan_lang_list ON  campaign_offer_slogan_lang_list.campaign_id = campaign.campaign_id
                        LEFT JOIN   campaign_offer_sub_slogan_lang_list  ON  campaign_offer_sub_slogan_lang_list.campaign_id = campaign.campaign_id
                        LEFT JOIN   campaign_keyword  ON  campaign_keyword.campaign_id = campaign.campaign_id
                        LEFT JOIN   lang_text as sloganT ON  campaign_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
                        LEFT JOIN   lang_text as subsloganT ON campaign_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = subsloganT.id
                        LEFT JOIN   lang_text as keyw ON campaign_keyword.offer_keyword = keyw.id
                        LEFT JOIN  category  ON category.category_id = campaign.category
                        LEFT JOIN  category_names_lang_list  ON category.category_id = category_names_lang_list.category
                        LEFT JOIN  lang_text   ON lang_text.id = category_names_lang_list.names_lang_list
                        WHERE
                        campaign.u_id='" . $_SESSION['userid'] . "' AND $set_keywords  end_of_publishing < CURDATE() AND s_activ!='2' AND lang_text.lang = subsloganT.lang GROUP BY campaign_id " . $limit;


        $res = mysqli_query($conn , $QUE);
        while ($rs = mysqli_fetch_array($res)) {

            $data[] = $rs;
        }
        return $data;
    }

    function deleteStandardOffer() {
        $productid = $_REQUEST['productId'];
        $reseller = $_REQUEST['reseller'];

        $db = new db();

        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
        $inoutObj = new inOut();

        $query1 = "select * from c_s_rel  where product_id = '" . $productId . "'";
        $res1 = mysqli_query($conn , $query1) or die(mysqli_error($conn));
        while ($rs1 = mysqli_fetch_array($res1)) {
            $productId = $rs1['product_id'];
            $couponId = $rs1['coupon_id'];
            $storeId = $rs1['store_id'];

            if ($productId) {
                $_SQL2 = "UPDATE c_s_rel SET activ='2' WHERE product_id = '" . $productId . "'";
                $res2 = mysqli_query($conn , $_SQL2) or die(mysqli_error($conn));
            }

            if ($couponId) {
                $query3 = "DELETE FROM coupon WHERE coupon_id = '" . $couponId . "'";
                $res3 = mysqli_query($conn , $query3) or die(mysqli_error($conn));

                $query4 = "select * from coupon_offer_slogan_lang_list  where coupon = '" . $couponId . "'";
                $res4 = mysqli_query($conn , $query4) or die('1' . mysqli_error($conn));
                while ($rs4 = mysqli_fetch_array($res4)) {
                    $offslogen = $rs4['offer_slogan_lang_list'];
                    $_SQL5 = "DELETE FROM coupon_offer_slogan_lang_list WHERE coupon = '" . $couponId . "'";
                    $res5 = mysqli_query($conn , $_SQL5) or die(mysqli_error($conn));
                }

                $query7 = "select * from coupon_offer_title_lang_list  where coupon = '" . $couponId . "'";
                $res7 = mysqli_query($conn , $query7) or die('1' . mysqli_error($conn));
                while ($rs7 = mysqli_fetch_array($res7)) {
                    $offtitle = $rs7['offer_title_lang_list'];
                    $_SQL8 = "DELETE FROM coupon_offer_title_lang_list WHERE coupon = '" . $couponId . "'";
                    $res8 = mysqli_query($conn , $_SQL8) or die(mysqli_error($conn));
                }

                $query10 = "select * from coupon_keywords_lang_list  where coupon = '" . $couponId . "'";
                $res10 = mysqli_query($conn , $query10) or die('1' . mysqli_error($conn));
                while ($rs10 = mysqli_fetch_array($res10)) {
                    $ckeyword = $rs10['keywords_lang_list'];
                    $_SQL11 = "DELETE FROM coupon_keywords_lang_list WHERE coupon = '" . $couponId . "'";
                    $res11 = mysqli_query($conn , $_SQL11) or die(mysqli_error($conn));
                }
            }
        }

        $_SQL13 = "UPDATE product SET s_activ='2' WHERE  product_id='" . $productid . "'";
        $q = $db->query($_SQL13);
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

    function deleteOutdatedCampaign() {
        $campaignid = $_REQUEST['campaignId'];
        $db = new db();

        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $subslogan_id = $this->get_slogan($campaignid, 'subslogan');
        $slogan_id = $this->get_slogan($campaignid);

        $query = "select * from campaign  where u_id = '" . $_SESSION['userid'] . "'";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        $rs = mysqli_fetch_array($res);
        $campaignId = $rs['campaign_id'];

        $query = "UPDATE `cumbari_admin`.`campaign` SET  `status` = '1' WHERE `campaign`.`campaign_id` = '" . $campaignId . "'";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

        $inoutObj = new inOut();
        $url = BASE_URL . 'showCampaign.php?m=showcampoffer';
        $inoutObj->reDirect($url);
        exit();
    }

    function get_titleslogan($productid) {
        $db = new db();

        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $s = "SELECT offer_slogan_lang_list FROM product_offer_slogan_lang_list left join product on
            product.product_id = product_offer_slogan_lang_list.product_id where product.product_id = '" . $productid . "'";
        $q = $db->query($s);
        $rs = mysqli_fetch_array($q);
        return $rs;
    }

    /* Function Header :searchCampaign()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: To generate search query string
     */

    function searchResellerCampaign($paging_limit=0) {

        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['ke'])) {
            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'keyw.text LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
            if ($_REQUEST['key']) {
                $set_keywords.= 'subsloganT.text LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }
            if ($_REQUEST['ke']) {
                $set_keywords.= 'sloganT.text LIKE "%' . trim($_REQUEST['ke']) . '%" AND ';
            }
        }
        else
            $set_keywords = " 1 AND ";

        if ($paging_limit)
            $limit = "limit " . $paging_limit;

        if ($_REQUEST['m'] == "showcampoffer") {
            $QUE = "SELECT campaign.*,sloganT.text as slogan,subsloganT.text as subslogen,keyw.text as keywordss, campaign.infopage,lang_text.text as category,company.company_name  FROM campaign
                        LEFT JOIN   campaign_offer_slogan_lang_list ON  campaign_offer_slogan_lang_list.campaign_id = campaign.campaign_id
                        LEFT JOIN   campaign_offer_sub_slogan_lang_list  ON  campaign_offer_sub_slogan_lang_list.campaign_id = campaign.campaign_id
                        LEFT JOIN   campaign_keyword  ON  campaign_keyword.campaign_id = campaign.campaign_id
                        LEFT JOIN   lang_text as sloganT ON  campaign_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
                        LEFT JOIN   lang_text as subsloganT ON campaign_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = subsloganT.id
                        LEFT JOIN   lang_text as keyw ON campaign_keyword.offer_keyword = keyw.id
                        LEFT JOIN  category  ON category.category_id = campaign.category
                        LEFT JOIN  category_names_lang_list  ON category.category_id = category_names_lang_list.category
                        LEFT JOIN  lang_text   ON lang_text.id = category_names_lang_list.names_lang_list
                        LEFT JOIN  company   ON company.company_id = campaign.company_id
                        WHERE
                        campaign.u_id='" . $_SESSION['userid'] . "' AND $set_keywords  end_of_publishing < CURDATE() AND s_activ!='2' AND lang_text.lang = subsloganT.lang ";
        } else {
            $QUE = "SELECT campaign.*,sloganT.text as slogan,subsloganT.text as subslogen,keyw.text as keyword, campaign.infopage,lang_text.text as category,company.company_name  FROM campaign
                        LEFT JOIN   campaign_offer_slogan_lang_list ON  campaign_offer_slogan_lang_list.campaign_id = campaign.campaign_id
                        LEFT JOIN   campaign_offer_sub_slogan_lang_list  ON  campaign_offer_sub_slogan_lang_list.campaign_id = campaign.campaign_id
                        LEFT JOIN   campaign_keyword  ON  campaign_keyword.campaign_id = campaign.campaign_id
                        LEFT JOIN   lang_text as sloganT ON  campaign_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
                        LEFT JOIN   lang_text as subsloganT ON campaign_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = subsloganT.id
                        LEFT JOIN   lang_text as keyw ON campaign_keyword.offer_keyword = keyw.id
                        LEFT JOIN  category  ON (category.category_id = campaign.category)
                        LEFT JOIN  category_names_lang_list  ON (category.category_id = category_names_lang_list.category)
                        LEFT JOIN  lang_text   ON lang_text.id = category_names_lang_list.names_lang_list
                        LEFT JOIN  company   ON company.company_id = campaign.company_id
                        
                        WHERE
                        campaign.u_id='" . $_SESSION['userid'] . "' AND $set_keywords 1 AND end_of_publishing >= CURDATE() AND (s_activ='0' or s_activ='3') AND lang_text.lang = subsloganT.lang";
        }

        $res = mysqli_query($conn,$QUE);

        return $res;
    }

    function searchResellerStandard($paging_limit=0) {
        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['ke'])) {
            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'lang_text.text LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
            if ($_REQUEST['key']) {
                $set_keywords.= 'keyw.text LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }
        } else {
            ////////////////////////////////////////////
            $set_keywords = " 1 AND";
            //echo"here";die();
        }

        if ($paging_limit)
            $limit = "limit " . $paging_limit;

        $QUE = "SELECT product.*, lang_text.text as slogen,keyw.text as keyword,cat.text as category FROM product
            LEFT JOIN          user                     ON   product.u_id = user.u_id
            LEFT JOIN    product_offer_slogan_lang_list  ON   product_offer_slogan_lang_list.product_id = product.product_id
            LEFT JOIN    product_keyword  ON   product_keyword.product_id = product.product_id
            LEFT JOIN        lang_text                  ON   product_offer_slogan_lang_list.offer_slogan_lang_list  = lang_text.id
             LEFT JOIN        lang_text as keyw    ON   product_keyword.offer_keyword  = keyw.id
            LEFT JOIN  category  ON category.category_id = product.category
            LEFT JOIN  category_names_lang_list  ON category.category_id = category_names_lang_list.category
            LEFT JOIN  lang_text as cat  ON cat.id = category_names_lang_list.names_lang_list
           WHERE product.u_id='" . $_SESSION['userid'] . "' AND $set_keywords s_activ='0' AND cat.lang = lang_text.lang GROUP BY product_id " . $limit;



        $res = mysql_query($QUE);

        return $res;
    }

    function checkBudgetDetails() {
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $error = '';

        $query = "SELECT pre_loaded_value FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
        $res = mysql_query($query) or die(mysql_error());
        $rs = mysql_fetch_array($res);
        $rs['pre_loaded_value'];
        $_SESSION['userid'];
        if ($rs['pre_loaded_value'] == '0' || $rs['pre_loaded_value'] == null) {
            $_SESSION['MESSAGE'] = 'You have insufficient balance to add a Sponsored Offer.';
        } else {

        }
    }

    /////////////////////////////////////////////

    function saveNewCouponDetails() {
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $error = '';
        $preview = $_POST['preview'];

        $arrUser['store_id'] = $_POST['selectStore'];

        $_SESSION['post'] = "";


        if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            $url = BASE_URL . 'addCoupon.php?campaignId=' . $_GET['campaignId'];
            $inoutObj->reDirect($url);
            exit();
        }

        $campaignId = $_GET['campaignId'];


        $QUE = "select * from c_s_rel where campaign_id='" . $campaignId . "' AND store_id='" . $arrUser['store_id'] . "' AND activ = '1'";
        $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
        $row = mysql_fetch_array($res);
        $campaignid = $row['campaign_id'];

        if ($campaignid) {
            $_SESSION['MESSAGE'] = STORE_NOT_SUCCESS;
            $url = BASE_URL . 'showCampaign.php';
            $inoutObj->reDirect($url);
            exit();
        } else {
            $QUE = "select start_of_publishing from campaign where campaign_id='" . $campaignId . "'";
            $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
            $row = mysql_fetch_array($res);
            $startdate = $row['start_of_publishing'];

            $QUE = "select end_of_publishing from campaign where campaign_id='" . $campaignId . "'";
            $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
            $row = mysql_fetch_array($res);
            $enddate = $row['end_of_publishing'];

            if ($startdate < date('Y-m-d')) {
                $finStartDate = date('Y-m-d');
            } else if ($startdate > date('Y-m-d')) {
                $finStartDate = $startdate;
            }
            
            $_SQL = "insert into c_s_rel(`campaign_id`,`store_id`,`start_of_publishing`,`end_of_publishing`,`activ`) values('" . $campaignId . "','" . $arrUser['store_id'] . "','" . $finStartDate . "','" . $enddate . "','1')";
            $res = mysql_query($_SQL) or die("limitttt id in relational table : " . mysql_error());


            $_SESSION['MESSAGE'] = COUPON_OFFER_SUCCESS;
            $url = BASE_URL . 'showCampaign.php';
            $inoutObj->reDirect($url);
            exit();
        }
    }

    ///////////////
    function saveNewCouponStandDetails() {
        // echo "In function"; die();
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $error = '';
        $preview = $_POST['preview'];

        $arrUser['price'] = $_POST['price'];
        $arrUser['store_id'] = $_POST['selectStore'];

        $_SESSION['post'] = "";

        if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            $url = BASE_URL . 'addCouponStandStore.php?productId=' . $_GET['productId'];
            $inoutObj->reDirect($url);
            exit();
        }

        $productId = $_GET['productId'];

        $QUE = "select * from c_s_rel where product_id='" . $productId . "' AND store_id='" . $arrUser['store_id'] . "'";
        $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
        $row = mysql_fetch_array($res);
        $productid = $row['product_id'];

        if ($productid) {
            $_SESSION['MESSAGE'] = STORE_NOT_SUCCESS;
            $url = BASE_URL . 'showStandard.php';
            $inoutObj->reDirect($url);
            exit();
        } else {
            $QUE = "select start_of_publishing from product where product_id='" . $productId . "'";
            $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
            $row = mysql_fetch_array($res);
            $startdate = $row['start_of_publishing'];

            $_SQL = "insert into c_s_rel(`product_id`,`store_id`,`start_of_publishing`,`activ`) values('" . $productId . "','" . $arrUser['store_id'] . "','" . $startdate . "','SE')";
            $res = mysql_query($_SQL) or die("limitttt id in relational table : " . mysql_error());

            $_SQL = "insert into product_price_list(`product_id`,`store_id`,`text`,`lang`) values('" . $productId . "','" . $arrUser['store_id'] . "','" . $arrUser['price'] . "','1')";
            $res = mysql_query($_SQL) or die(mysql_error());

            $_SESSION['MESSAGE'] = COUPON_OFFER_SUCCESS;
            $url = BASE_URL . 'showStandard.php';
            $inoutObj->reDirect($url);
            exit();
        }
    }

    function saveNewCouponDetailsRetailer() {
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $error = '';
        $preview = $_POST['preview'];

        $arrUser['store_id'] = $_POST['selectStore'];


        $_SESSION['post'] = "";

        if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            $url = BASE_URL . 'addCouponStore.php?campaignId=' . $_GET['campaignId'];
            $inoutObj->reDirect($url);
            exit();
        }

        $campaignId = $_GET['campaignId'];

        $QUE = "select * from c_s_rel where campaign_id='" . $campaignId . "' AND store_id='" . $arrUser['store_id'] . "'";
        $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
        $row = mysql_fetch_array($res);
        $campaignid = $row['campaign_id'];

        if ($campaignid) {
            $_SESSION['MESSAGE'] = STORE_NOT_SUCCESS;
            $url = BASE_URL . 'showCampaign.php';
            $inoutObj->reDirect($url);
            exit();
        } else {
            $QUE = "select start_of_publishing from campaign where campaign_id='" . $campaignId . "'";
            $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
            $row = mysql_fetch_array($res);
            $startdate = $row['start_of_publishing'];

            $QUE = "select end_of_publishing from campaign where campaign_id='" . $campaignId . "'";
            $res = mysql_query($QUE) or die("Get Company : " . mysql_error());
            $row = mysql_fetch_array($res);
            $enddate = $row['end_of_publishing'];


            $_SQL = "insert into c_s_rel(`campaign_id`,`store_id`,`start_of_publishing`,`end_of_publishing`,`activ`) values('" . $campaignId . "','" . $arrUser['store_id'] . "','" . $arrUser['start_of_publishing'] . "','" . $arrUser['end_of_publishing'] . "','1')";
            $res = mysql_query($_SQL) or die("limitttt id in relational table : " . mysql_error());


            $_SESSION['MESSAGE'] = COUPON_OFFER_SUCCESS;
            $url = BASE_URL . 'showCampaign.php';
            $inoutObj->reDirect($url);
            exit();
        }
    }

    function getCategoryNameById($categoryid) {  //echo $categoryid;
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $error = '';

        $query = "SELECT lang_text.text as categoryName  FROM category
                        LEFT JOIN  category_names_lang_list  ON category.category_id = category_names_lang_list.category
                        LEFT JOIN  lang_text  ON lang_text.id = category_names_lang_list.names_lang_list
                        WHERE  category.category_id='" . $categoryid . "'";


        $res = mysql_query($query);
        $data = mysql_fetch_array($res);
        return $data;
    }

//////////////////////////////////////////////////////////////
    function saveNewCouponStandardDetails() {
        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $arrUser = array();
        $error = '';
        $preview = $_POST['preview'];

        $q = $db->query("SELECT company.currencies as currency FROM user
             LEFT JOIN  company  ON  company.u_id  = user.u_id

                 WHERE user.u_id ='" . $_SESSION['userid'] . "' ");
        while ($rs = mysqli_fetch_array($q)) {
            $datas = $rs;
        }

        $arrUser['price'] = trim($_POST['price']);
        $arrUser['store_id'] = $_POST['selectStore'];
        $arrUser['price_nor'] = trim($_POST['price']);
        $_SESSION['post'] = "";

        if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            $url = BASE_URL . 'addStandCoupon.php?productId=' . $_GET['productId'];
            $inoutObj->reDirect($url);
            exit();
        }

        $productId = $_GET['productId'];

        $query = "SELECT lang_text.lang as language  FROM product
                        LEFT JOIN  product_offer_slogan_lang_list  ON product.product_id = product_offer_slogan_lang_list.product_id
                        LEFT JOIN  lang_text  ON lang_text.id = product_offer_slogan_lang_list.offer_slogan_lang_list
                        WHERE  product.product_id='" . $productId . "'";

        $q = $db->query($query);
        while ($rs = mysqli_fetch_array($q)) {
            $data = $rs;
        }


        $QUE = "select * from c_s_rel where product_id='" . $productId . "' AND store_id='" . $arrUser['store_id'] . "' AND activ='1'";
        $res = mysqli_query($conn , $QUE) or die("Get Company : " . mysqli_error($conn));
        $row = mysqli_fetch_array($res);
        $productid = $row['product_id'];

        if ($productid) {
            $_SESSION['MESSAGE'] = STORE_NOT_SUCCESS;
            $url = BASE_URL . 'showStandard.php';
            $inoutObj->reDirect($url);
            exit();
        } else {

            if ($row[lang] == ENG) {
                $arrUser['price'] = 'Price:' . $arrUser['price'] . 'Rupee';
            } else {
                $arrUser['price'] = 'Pris:' . $arrUser['price'] . 'Kr';
            }


            $QUE = "select start_of_publishing from product where product_id='" . $productId . "'";
            $res = mysqli_query($conn , $QUE) or die("Get Company : " . mysqli_error($conn));
            $row = mysqli_fetch_array($res);
            $startdate = $row['start_of_publishing'];

            $_SQL = "insert into c_s_rel(`product_id`,`store_id`,`start_of_publishing`,`activ`) values('" . $productId . "','" . $arrUser['store_id'] . "','" . $startdate . "','1')";
            $res = mysqli_query($conn , $_SQL) or die("limitttt id in relational table : " . mysqli_error($conn));

            $publishing_start_date = DateTime::createFromFormat('d/m/Y H:i', $_POST['publishing_start_date']);
            $publishing_start_date = $publishing_start_date->format('Y-m-d H:i:s');

            $publishing_end_date = DateTime::createFromFormat('d/m/Y H:i', $_POST['publishing_end_date']);
            $publishing_end_date = $publishing_end_date->format('Y-m-d H:i:s');
    
            $_SQL = "insert into product_price_list(`product_id`,`store_id`,`text`,`price`,`lang`,`publishing_start_date`,`publishing_end_date`) values('" . $productId . "','" . $arrUser['store_id'] . "','" . $arrUser['price'] . "','" . $arrUser['price_nor'] . "','" . $row['lang'] . "','" . 
            $publishing_start_date . "','" . $publishing_end_date . "')";

            $res = mysqli_query($conn , $_SQL) or die("Error in product_price_list : " . mysqli_error($conn));


            $_SESSION['MESSAGE'] = COUPON_OFFER_SUCCESS;
            $url = BASE_URL . 'showStandard.php';
            $inoutObj->reDirect($url);
            exit();
        }
    }

    function uploadImages() {
        if ($_POST['icon'] != "") {
            if (!empty($_FILES["icon"]["name"])) {

                if (strtolower($info['extension']) == "png") {
                    if ($_FILES["icon"]["error"] > 0) {
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

        //// Upload Coupen image//////
        $coupenName = "cpn_" . md5(time());
        $info = pathinfo($_FILES["picture"]["name"]);

        if (!empty($_FILES["picture"]["name"])) {

            if (strtolower($info['extension']) == "jpg" || strtolower($info['extension']) == "jpeg" || $file_extension == "gif" || $file_extension == "bmp") {
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
                }
            } else {
                $error.=NOT_VALID_EXT;
            }
        } else {
            if ($_SESSION['preview']['large_image'] != "") {
                $arrUser['large_image'] = $_SESSION['preview']['large_image'];
            } elseif ($_POST['largeimage'] == "") {
                $error.=ERROR_LARGE_STANDARD_IMAGE;
            } else {
                if ($_SESSION['preview']['large_image'] != "") {
                    $arrUser['large_image'] = $_SESSION['preview']['large_image'];
                } elseif ($_POST['largeimage'] == "") {
                    $error.= ERROR_SMALL_IMAGE;
                } else {
                    $arrUser['large_image'] = $_POST['largeimage'];
                }
            }
        }
    }

    function getStoreNameById($storeId) {  //echo $categoryid;
        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $arrUser = array();
        $error = '';

        $query = "SELECT store_name,street,city FROM store
                    WHERE  store.store_id='" . $storeId . "'";


        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        $data = mysqli_fetch_array($res);
        return $data;
    }

    function showDeleteResellerCampaign($paging_limit='0 , 10') {

        //echo kjasd;die();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $is_Public = array();
        $error = '';
        $inoutObj = new inOut();
        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['ke'])) {
            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'keyw.text LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
            if ($_REQUEST['key']) {
                $set_keywords.= 'subsloganT.text LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }
            if ($_REQUEST['ke']) {
                $set_keywords.= 'sloganT.text LIKE "%' . trim($_REQUEST['ke']) . '%" AND ';
            }
        }
        else
            $set_keywords = " 1 AND ";



        $Query = "SELECT campaign.*,sloganT.text as slogan,subsloganT.text as subslogen,keyw.text as keyword, campaign.infopage,lang_text.text as category FROM campaign
                        LEFT JOIN   campaign_offer_slogan_lang_list ON  campaign_offer_slogan_lang_list.campaign_id = campaign.campaign_id
                        LEFT JOIN   campaign_offer_sub_slogan_lang_list  ON  campaign_offer_sub_slogan_lang_list.campaign_id = campaign.campaign_id
                         LEFT JOIN   campaign_keyword  ON  campaign_keyword.campaign_id = campaign.campaign_id
                        LEFT JOIN   lang_text as sloganT ON  campaign_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
                        LEFT JOIN   lang_text as subsloganT ON campaign_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = subsloganT.id
                        LEFT JOIN   lang_text as keyw ON campaign_keyword.offer_keyword = keyw.id
                        LEFT JOIN  category  ON (category.category_id = campaign.category)
                        LEFT JOIN  category_names_lang_list  ON (category.category_id = category_names_lang_list.category)
                        LEFT JOIN  lang_text  ON lang_text.id = category_names_lang_list.names_lang_list
                        WHERE campaign.u_id = '" . $_SESSION['userid'] . "' AND $set_keywords s_activ='2' AND lang_text.lang = subsloganT.lang GROUP BY campaign_id LIMIT {$paging_limit}";

        $q = $db->query($Query);

        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
        }

        return $data;
    }

    function showDeleteCampaignDetailsResellerRows() {
        //echo kajdhs;die();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $is_Public = array();
        $error = '';
        $inoutObj = new inOut();
        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['ke'])) {
            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'keyw.text LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
            if ($_REQUEST['key']) {
                $set_keywords.= 'subsloganT.text LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }
            if ($_REQUEST['ke']) {
                $set_keywords.= 'sloganT.text LIKE "%' . trim($_REQUEST['ke']) . '%" AND ';
            }
        }
        else
            $set_keywords = " 1 AND ";

        $Query = "SELECT campaign.*,sloganT.text as slogan,subsloganT.text as subslogen,keyw.text as keyword, campaign.infopage,lang_text.text as category FROM campaign
                        LEFT JOIN   campaign_offer_slogan_lang_list ON  campaign_offer_slogan_lang_list.campaign_id = campaign.campaign_id
                        LEFT JOIN   campaign_offer_sub_slogan_lang_list  ON  campaign_offer_sub_slogan_lang_list.campaign_id = campaign.campaign_id
                        LEFT JOIN   campaign_keyword  ON  campaign_keyword.campaign_id = campaign.campaign_id
                        LEFT JOIN   lang_text as sloganT ON  campaign_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
                        LEFT JOIN   lang_text as subsloganT ON campaign_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = subsloganT.id
                        LEFT JOIN   lang_text as keyw ON campaign_keyword.offer_keyword = keyw.id
                        LEFT JOIN  category  ON (category.category_id = campaign.category)
                        LEFT JOIN  category_names_lang_list  ON (category.category_id = category_names_lang_list.category)
                        LEFT JOIN  lang_text  ON lang_text.id = category_names_lang_list.names_lang_list
                        WHERE campaign.u_id = '" . $_SESSION['userid'] . "' AND $set_keywords s_activ='2' AND lang_text.lang = subsloganT.lang GROUP BY campaign_id ";

        $res = mysqli_query($conn , $Query) or die(mysqli_error($conn));
        $total_records = $db->numRows($res);

        return $total_records;
    }

    ////////////////////for showDeleteCampaign
    function showDeleteCampaignDetailsRows() {
        $db = new db();
        $conn = $db->makeConnection();

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $is_Public = array();
        $error = '';
        $inoutObj = new inOut();

        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['ke'])) {
            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'keyw.text LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
            if ($_REQUEST['key']) {
                $set_keywords.= 'subsloganT.text LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }
            if ($_REQUEST['ke']) {
                $set_keywords.= 'sloganT.text LIKE "%' . trim($_REQUEST['ke']) . '%" AND ';
            }
        }
        else
            $set_keywords = " 1 AND ";

        $query = "select * from employer where u_id = '" . $_SESSION['userid'] . "'";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        $rs = mysqli_fetch_array($res);
        $companyId = $rs['company_id'];

        $Query = "SELECT campaign.*,sloganT.text as slogan,subsloganT.text as subslogen,keyw.text as keyword, campaign.infopage,lang_text.text as category FROM campaign
                        LEFT JOIN   campaign_offer_slogan_lang_list ON  campaign_offer_slogan_lang_list.campaign_id = campaign.campaign_id
                        LEFT JOIN   campaign_offer_sub_slogan_lang_list  ON  campaign_offer_sub_slogan_lang_list.campaign_id = campaign.campaign_id
                        LEFT JOIN   campaign_keyword  ON  campaign_keyword.campaign_id = campaign.campaign_id
                        LEFT JOIN   lang_text as sloganT ON  campaign_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
                        LEFT JOIN   lang_text as subsloganT ON campaign_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = subsloganT.id
                        LEFT JOIN   lang_text as keyw ON campaign_keyword.offer_keyword = keyw.id
                        LEFT JOIN  category  ON (category.category_id = campaign.category)
                        LEFT JOIN  category_names_lang_list  ON (category.category_id = category_names_lang_list.category)
                        LEFT JOIN  lang_text  ON lang_text.id = category_names_lang_list.names_lang_list
                        WHERE campaign.company_id = '" . $companyId . "' AND $set_keywords s_activ='2' AND lang_text.lang = subsloganT.lang AND (reseller_status = 'A' OR reseller_status = '') GROUP BY campaign_id ";

        $res = mysqli_query($conn , $Query) or die(mysqli_error($conn));
        $total_records = $db->numRows($res);

        return $total_records;
    }

    function showDeleteCampaign($paging_limit='0 , 10') {
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $is_Public = array();
        $error = '';
        $inoutObj = new inOut();
        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['ke'])) {
            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'keyw.text LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
            if ($_REQUEST['key']) {
                $set_keywords.= 'subsloganT.text LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }
            if ($_REQUEST['ke']) {
                $set_keywords.= 'sloganT.text LIKE "%' . trim($_REQUEST['ke']) . '%" AND ';
            }
            // $set_keywords = "(u_id='".$_SESSION['userid']."' AND ".$qstr1.") OR
        }
        else
            $set_keywords = " 1 AND ";

        $query = "select * from employer where u_id = '" . $_SESSION['userid'] . "'";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        $rs = mysqli_fetch_array($res);
        $companyId = $rs['company_id'];

        $Query = "SELECT campaign.*,sloganT.text as slogan,subsloganT.text as subslogen,keyw.text as keyword, campaign.infopage,lang_text.text as category FROM campaign
                        LEFT JOIN   campaign_offer_slogan_lang_list ON  campaign_offer_slogan_lang_list.campaign_id = campaign.campaign_id
                        LEFT JOIN   campaign_offer_sub_slogan_lang_list  ON  campaign_offer_sub_slogan_lang_list.campaign_id = campaign.campaign_id
                         LEFT JOIN   campaign_keyword  ON  campaign_keyword.campaign_id = campaign.campaign_id
                        LEFT JOIN   lang_text as sloganT ON  campaign_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
                        LEFT JOIN   lang_text as subsloganT ON campaign_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = subsloganT.id
                        LEFT JOIN   lang_text as keyw ON campaign_keyword.offer_keyword = keyw.id
                        LEFT JOIN  category  ON (category.category_id = campaign.category)
                        LEFT JOIN  category_names_lang_list  ON (category.category_id = category_names_lang_list.category)
                        LEFT JOIN  lang_text  ON lang_text.id = category_names_lang_list.names_lang_list
                        WHERE campaign.company_id = '" . $companyId . "' AND $set_keywords s_activ='2' AND lang_text.lang = subsloganT.lang AND (reseller_status = 'A' OR reseller_status = '') GROUP BY campaign_id LIMIT {$paging_limit}";



        $q = $db->query($Query);

        //$res = mysql_query($query) or die(mysql_error());

        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
        }
        // print_r($data); die("dssdada");
        return $data;
    }

    /////////////////////////////////////////

    function viewDeleteCampaignDetailById($campaignid) {
//echo "here";echo $campaignid;die;
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $data = array();
        $error = '';




        $q = $db->query("SELECT campaign.*,sloganT.text as slogan,subsloganT.text as subslogen,keyw.text as keyword, campaign.infopage,limit_period.*,lang_text.text as categoryName  FROM campaign
                        LEFT JOIN  campaign_offer_slogan_lang_list          ON  campaign_offer_slogan_lang_list.campaign_id = campaign.campaign_id
                        LEFT JOIN  campaign_keyword    ON  campaign_keyword.campaign_id = campaign.campaign_id
                        LEFT JOIN    campaign_offer_sub_slogan_lang_list    ON  campaign_offer_sub_slogan_lang_list.campaign_id = campaign.campaign_id
                        LEFT JOIN  lang_text as sloganT             ON  campaign_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
                        LEFT JOIN  lang_text as keyw             ON  campaign_keyword.offer_keyword  = keyw.id
                        LEFT JOIN    lang_text as subsloganT        ON  campaign_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = subsloganT.id
                        LEFT JOIN  campaign_limit_period_list       ON campaign_limit_period_list.campaign_id =  campaign.campaign_id
                        LEFT JOIN limit_period                      ON limit_period.limit_id=campaign_limit_period_list.limit_period_list
                        LEFT JOIN  category  ON category.category_id = campaign.category
                        LEFT JOIN  category_names_lang_list  ON category.category_id = category_names_lang_list.category
                        LEFT JOIN  lang_text  ON lang_text.id = category_names_lang_list.names_lang_list
                        WHERE  campaign.campaign_id='" . $campaignid . "' AND lang_text.lang = subsloganT.lang");
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
            // print_r($data);
        }

        $QUE = "select store.* from store left join c_s_rel
        on(c_s_rel.store_id = store.store_id)
        where c_s_rel.campaign_id ='" . $campaignid . "' AND activ='1'";
        $res = mysqli_query($conn , $QUE) or die(mysqli_error($conn));
        while ($row = mysqli_fetch_array($res)) {
            $storeDetails[] = $row;
        }
        $data['storeDetails'] = $storeDetails;
        //print_r($data['storeDetails']);
        //echo $_SESSION['userid'];
        return $data;
        // print_r ($data); die("hg");
    }

    function editDeleteCampaignPreview($campaignid, $reseller='') {
        //echo "here";echo $campaignid;die;
        //echo $campaignid;die;
        //echo $reseller;die();
        $inoutObj = new inOut();

        $_SESSION['campaign_for_edit'] = serialize($_POST);

        if ($_FILES['picture']['name'] <> '') {
            #$_SESSION['preview']['edit_large_image'] = '1';
            // $_SESSION['preview']['large_image'] = $_FILES['picture']['name']; //<> '' ? $_FILES['picture']['name'] : $_POST['largeimage']['name'] ;
        }
        $_SESSION['preview']['campaignId'] = $_POST['campaignId'];
        $_SESSION['preview']['offer_slogan_lang_list'] = $_POST['titleSlogan'];
        $_SESSION['preview']['offer_sub_slogan_lang_list'] = $_POST['subSlogan'];
        $_SESSION['preview']['campaignId'] = $campaignid;
        $_SESSION['preview']['linkedCat'] = $_POST['linkedCat'];
        $_SESSION['preview']['startDateLimitation'] = $_POST['startDateLimitation'];
        $_SESSION['preview']['endDateLimitation'] = $_POST['endDateLimitation'];

        //// Upload Coupen image//////
        $coupenName = "cpn_" . md5(time());
        $info = pathinfo($_FILES["picture"]["name"]);
        /*  if ($_POST['icon'] != "") {
          //echo "Cat in"; die();
          if (!empty($_FILES["icon"]["name"])) {

          if (strtolower($info['extension']) == "png") {
          if ($_FILES["icon"]["error"] > 0) {
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
          $category_image = $_POST["category_image"];
          if (!empty($category_image)) {

          $categoryImageName = explode(".", $category_image);
          $cat_filename = $CategoryIconName . "." . $categoryImageName[1];
          $fileOriginal = UPLOAD_DIR . "category_lib/" . $category_image;
          $path = UPLOAD_DIR . "category/";
          $fileThumbnail = $path . $cat_filename;
          copy($fileOriginal, $fileThumbnail);
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
          } */

        if (!empty($_FILES["picture"]["name"])) {

            if (strtolower($info['extension']) == "jpg" || strtolower($info['extension']) == "png" || strtolower($info['extension']) == "jpeg" || $file_extension == "gif" || $file_extension == "bmp") {
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
        extract(((unserialize($_SESSION['campaign_for_edit']))));
        // extract(((unserialize($_SESSION['campaign_for_edit_image']))));
        //echo "sasadas"; die();
        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $arrUser = array();
        $error = '';


        $arrUser['offer_slogan_lang_list'] = addslashes($titleSlogan);
        $arrUser['offer_sub_slogan_lang_list'] = addslashes($subSlogan);
        #$arrUser['small_image'] = $icon;
        if ($_POST['icon'] == "") {
            $arrUser['small_image'] = $_POST['category_image'];
        } else {
            $arrUser['small_image'] = $_POST['icon'];
        }
        $arrUser['spons'] = $sponsor;
        $arrUser['category'] = $linkedCat;
        $arrUser['start_of_publishing'] = $startDate;
        $arrUser['end_of_publishing'] = $endDate;
        $arrUser['campaign_name'] = addslashes($campaignName);
        $arrUser['keywords'] = addslashes($searchKeyword);
        $arrUser['discountValue'] = addslashes($_POST['discountValue']);
        
        $arrUser['start_time'] = $startDateLimitation;
        $arrUser['end_time'] = $endDateLimitation;
        $arrUser['infopage'] = $descriptive;
        $arrUser['lang'] = $_POST['lang'];

        $arrUser['codes'] = $_POST['codes'];

        if ($arrUser['codes'] == '') {
            $arrUser['etanCode'] = '';
        } else {
            if(($_POST['pinCode']!='') && ($arrUser['codes'] == 'PINCODE'))
            {
            $arrUser['etanCode'] = $_POST['pinCode'];
            }
             if(($_POST['etanCode']!='') && ($arrUser['codes'] == 'GTIN13'))
             {
            $arrUser['etanCode'] = $_POST['etanCode'];
             }
        }

        // string matching
        if ($arrUser['infopage']) {
            $filestring = $arrUser['infopage'];
            $findme = 'http://';
            $pos = strpos($filestring, $findme);
            if ($pos === false) {
                $arrUser['infopage'] = 'http://' . $filestring;
            } else {
                $arrUser['infopage'] = $filestring;
            }
        }
        $arrUser['valid_day'] = $limitDays;

        $error.= ( $arrUser['offer_slogan_lang_list'] == '') ? ERROR_TITLE_SLOGAN : '';

        $error.= ( $arrUser['offer_sub_slogan_lang_list'] == '') ? ERROR_SUB_SLOGAN : '';

        $error.= ( $arrUser['spons'] == '') ? ERROR_SPONSORS : '';

        $error.= ( $arrUser['category'] == '') ? ERROR_CATEGORY : '';

        $error.= ( $arrUser['start_of_publishing'] == '') ? ERROR_START_OF_PUBLISHING : '';

        $error.= ( $arrUser['end_of_publishing'] == '') ? ERROR_END_OF_PUBLISHING : '';

        $error.= ( $arrUser['campaign_name'] == '') ? ERROR_CAMPAIGN_NAME : '';
        $error.= ( $arrUser['discountValue'] == '') ? ERROR_DISCOUNT_VALUE : '';


        $_SESSION['post'] = "";

         if ($reseller == '') {

            $query = "SELECT pre_loaded_value FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
            $rs_comp = mysqli_fetch_array($res);
            $rs_comp['pre_loaded_value'];
            if ($rs_comp['pre_loaded_value']) {
                //$_SESSION['userid'];
                $pre_loaded_value = $rs_comp['pre_loaded_value'];
            } else {
                $query = "SELECT pre_loaded_value FROM user as usr
          LEFT JOIN company as camp ON       (camp.company_id=usr.company_id)
         WHERE usr.u_id='" . $_SESSION['userid'] . "'";
                $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
                $rs_comp = mysqli_fetch_array($res);
                $pre_loaded_value = $rs_comp['pre_loaded_value'];
                //$rs['new_pre_loaded_value'];
            }

            if ($_POST['sponsor'] == 1) {
                if (($pre_loaded_value == '0' || $pre_loaded_value == null)) {
                    $_SESSION['MESSAGE2'] = CRADIT_YOUR_ACCOUNT;


                    $url = BASE_URL . 'editDeleteCampaign.php?campaignId='.$campaignid;
                    $inoutObj->reDirect($url);
                    exit();
                }
            }


            $query = "SELECT pre_loaded_value FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
            $rs = mysqli_fetch_array($res);
            $rs['pre_loaded_value'];
            if ($arrUser['is_sponsored'] == 1 && ($rs['pre_loaded_value'] == '0' || $rs['pre_loaded_value'] == null)) {
                $_SESSION['MESSAGE'] = INSUFFICIENT_BALANCE;
            }
        }


        $CategoryIconName = "cat_icon_" . md5(time());
        $info = pathinfo($_FILES["icon"]["name"]);

        if ($_POST['icon'] != "") {

            if (!empty($_FILES["icon"]["name"])) {

                if (strtolower($info['extension']) == "png") {
                    if ($_FILES["icon"]["error"] > 0) {
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

            //echo $_POST['smallimage']."iiiiiii".$category_image = $_POST["category_image"]; die();
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
            //echo "Cat Resp icon"; die();
        }

        /////////////////////////// upload smallimages into server///////////////////
        $file1 = _UPLOAD_IMAGE_ . 'category/' . $arrUser['small_image'];
        $dir1 = "category";
        $command = IMAGE_DIR_PATH . $file1 . " " . $dir1;
        system($command);

        //// Upload Coupen image//////
        $coupenName = "cpn_" . md5(time());
        $info = pathinfo($_FILES["picture"]["name"]);


        $arrUser['large_image'] = $_SESSION['preview']['large_image'];

        $_SESSION['preview'] = $arrUser;
        if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            if ($reseller == '') {
                $url = BASE_URL . 'editDeleteCampaign.php?campaignId=' . $campaignid;
                $inoutObj->reDirect($url);
                exit();
            } else {
                $url = BASE_URL . 'editDeleteCampaign.php?campaignId=' . $campaignid . 'from=' . $reseller;
                $inoutObj->reDirect($url);
                exit();
            }
        }

        ///////////////////////////

        $campaignId = uuid();
        /// Select company id of this user
        $QUE = "select company_id from company where u_id='" . $_SESSION['userid'] . "'";
        $res = mysqli_query($conn , $QUE) or die("Get Company : " . mysqli_error($conn));
        $row = mysqli_fetch_array($res);
        $companyId = $row['company_id'];

        if ($companyId == '') {
            $QUE33 = "select company_id from employer where u_id='" . $_SESSION['userid'] . "'";
            $res33 = mysqli_query($conn , $QUE33) or die(mysqli_error($conn));
            $rs33 = mysqli_fetch_array($res33);
            $empCompId = $rs33['company_id'];
            $companyId = $empCompId;
        }

        $catImg = IMAGE_AMAZON_PATH . 'category/' . $arrUser['small_image'];
        $copImg = IMAGE_AMAZON_PATH . 'coupon/' . $arrUser['large_image'];

        $arrUser['u_id'] = $_SESSION['userid'];
// New viewopt Kent
        $query = "INSERT INTO campaign(`campaign_id`,`company_id`,`u_id`, `small_image`,`large_image`, `spons`, `category`, `start_of_publishing`,`end_of_publishing`,`campaign_name`,`view_opt`,`infopage`,`s_activ`,`code`,`code_type`,`value`)
                VALUES ('" . $campaignId . "','" . $companyId . "','" . $_SESSION['userid'] . "', '" . $catImg . "', '" . $copImg . "','" . $arrUser['spons'] . "','" . $arrUser['category'] . "','" . $arrUser['start_of_publishing'] . "','" . $arrUser['end_of_publishing'] . "','" . $arrUser['campaign_name'] . "','" . $arrUser['viewopt']  . "','" . $arrUser['infopage'] . "','0','" . $arrUser['etanCode'] . "','" . $arrUser['codes'] . "','".$arrUser['discountValue']."');";
//  End New viewopt Kent
        $res = mysqli_query($conn , $query) or die("Inset campaign : " . mysqli_error($conn));


        if ($arrUser['codes'] == '') {
            $query = "update campaign set `code` = NULL,`code_type` = NULL where campaign_id = '" . $campaignId . "'";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        }


        if ($reseller != '') {
            $query = "UPDATE campaign SET `reseller_status` = 'P' WHERE campaign_id = '" . $campaignId . "'";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        }

        ////////Slogan entry///////
        $sloganLangId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $sloganLangId . "','" . $arrUser['lang'] . "','" . $arrUser['offer_slogan_lang_list'] . "')";
        $res = mysqli_query($conn , $_SQL) or die("title slogan in lang_text : " . mysqli_error($conn));

        ////////category entry///////
//        $categoryId = uuid();
//        $_SQL = "insert into lang_text(id,lang,text) values('" . $categoryId . "','ENG','" . $arrUser['category'] . "')";
//        $res = mysql_query($_SQL) or die("category in lang_text : " . mysql_error());
//
//        ////////category icon  entry///////
//        $categoryIconId = uuid();
//        $_SQL = "insert into category(category_id ,small_image) values('" . $categoryIconId . "','" . $category_image . "')";
//        $res = mysql_query($_SQL) or die("category in lang_text : " . mysql_error());
//
//        ////////category and category icon entry///////
//        $_SQL = "insert into category_names_lang_list(category_id ,names_lang_list) values('" . $categoryIconId . "','" . $categoryId . "')";
//        $res = mysql_query($_SQL) or die("category in lang_text : " . mysql_error());
        ////////Sub Slogen entry///////
        $subSloganLangId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $subSloganLangId . "','" . $arrUser['lang'] . "','" . $arrUser['offer_sub_slogan_lang_list'] . "')";
        $res = mysqli_query($conn , $_SQL) or die("sub slogan in lang_text : " . mysqli_error($conn));


        ////keyword
        $keywordId = uuid();
         if(trim($arrUser['keywords']) != "")
         {
        $_SQL = "insert into lang_text(id,lang,text) values('" . $keywordId . "','" . $arrUser['lang'] . "','" . $arrUser['keywords'] . "')";
        $res = mysqli_query($conn, $_SQL) or die("title slogan in lang_text : " . mysqli_error($conn));

         ///keyword ///
        $_SQL = "insert into campaign_keyword(`campaign_id`,`offer_keyword`) values('" . $campaignId . "','" . $keywordId . "')";
        $res = mysqli_query($conn, $_SQL) or die("Sub slogan id in relational table : " . mysqli_error($conn));
         }
         
         
           $SystemkeyId = uuid();
         $_SQL = "insert into lang_text(id,lang,text) values('" . $SystemkeyId . "','" . $arrUser['lang'] . "','" . $campaignId . "')";
         $res = mysqli_query($conn , $_SQL) or die("sub slogan in lang_text : " . mysqli_error($conn));


         $_SQL = "insert into campaign_keyword(`campaign_id`,`system_key`) values('" . $campaignId . "','" . $SystemkeyId . "')";
         $res = mysqli_query($conn , $_SQL) or die("keyword in relational table : " . mysqli_error($conn));
         
         
         $Systemkey_companyId = uuid();
         $_SQL = "insert into lang_text(id,lang,text) values('" . $Systemkey_companyId . "','" . $arrUser['lang'] . "','" . $companyId . "')";
         $res = mysqli_query($conn , $_SQL) or die("sub slogan in lang_text : " . mysqli_error($conn));


         $_SQL = "insert into campaign_keyword(`campaign_id`,`system_key`) values('" . $campaignId . "','" . $Systemkey_companyId . "')";
         $res = mysqli_query($conn , $_SQL) or die("keyword in relational table : " . mysqli_error($conn));
         
        ///Slogan and language table relation entry ///
        $_SQL = "insert into campaign_offer_slogan_lang_list(`campaign_id`,`offer_slogan_lang_list`) values('" . $campaignId . "','" . $sloganLangId . "')";
        $res = mysqli_query($conn , $_SQL) or die("Tital slogan id in relational table : " . mysqli_error($conn));


        ///Sub slogan and language table relation entry ///
        $_SQL = "insert into campaign_offer_sub_slogan_lang_list(`campaign_id`,`offer_sub_slogan_lang_list`) values('" . $campaignId . "','" . $subSloganLangId . "')";
        $res = mysqli_query($conn , $_SQL) or die("Sub slogan id in relational table : " . mysqli_error($conn));


        ///Start date and End Date and Valid days entry ///

        if ($arrUser['valid_day'] != '') {
            $limitId = uuid();
            $_SQL = "insert into limit_period(`limit_id`,`end_time`,`start_time`,`valid_day`) values('" . $limitId . "','" . $arrUser['end_time'] . "','" . $arrUser['start_time'] . "','" . $arrUser['valid_day'] . "')";
            $res = mysqli_query($conn , $_SQL) or die("Insert limit period : " . mysqli_error($conn));

            ///RElation between LImit Period list and Coupon ///
            $_SQL = "insert into campaign_limit_period_list(`campaign_id`,`limit_period_list`) values('" . $campaignId . "','" . $limitId . "')";
            $res = mysqli_query($conn , $_SQL) or die("limit id in relational table : " . mysqli_error($conn));
        }



        $_SESSION['MESSAGE'] = CAMPAIGN_OFFER_SUCCESS;
        if ($reseller == '') {
            $url = BASE_URL . 'showCampaign.php';
            // $url = BASE_URL.'editCampaignPreview.php?campaignId='.$campaignid;
            $inoutObj->reDirect($url);
            exit();
        } else {
            $url = BASE_URL . 'showResellerCampaign.php';
            $inoutObj->reDirect($url);
            exit();
        }
    }

    function editDeleteCampaign($campaignid) {
        extract(((unserialize($_SESSION['campaign_for_edit']))));
        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $arrUser = array();
        $error = '';

        $arrUser['offer_slogan_lang_list'] = $titleSlogan;
        $arrUser['offer_sub_slogan_lang_list'] = $subSlogan;
        if ($_POST['icon'] == "") {
            $arrUser['small_image'] = $_POST['category_image'];
        } else {
            $arrUser['small_image'] = $_POST['icon'];
        }
        $arrUser['spons'] = $sponsor;
        $arrUser['category'] = $linkedCat;
        $arrUser['start_of_publishing'] = $startDate;
        $arrUser['end_of_publishing'] = $endDate;
        $arrUser['campaign_name'] = $campaignName;
        $arrUser['keywords'] = $searchKeyword;
        $arrUser['discountValue'] = addslashes($_POST['discountValue']);
        
        $arrUser['start_time'] = $startDateLimitation;
        $arrUser['end_time'] = $endDateLimitation;
        $arrUser['infopage'] = $descriptive;
        $arrUser['valid_day'] = $limitDays;
        $arrUser['lang'] = $_POST['lang'];

        $error.= ( $arrUser['offer_slogan_lang_list'] == '') ? ERROR_TITLE_SLOGAN : '';
        $error.= ( $arrUser['offer_sub_slogan_lang_list'] == '') ? ERROR_SUB_SLOGAN : '';
        $error.= ( $arrUser['spons'] == '') ? ERROR_SPONSORS : '';
        $error.= ( $arrUser['category'] == '') ? ERROR_CATEGORY : '';
        $error.= ( $arrUser['start_of_publishing'] == '') ? ERROR_START_OF_PUBLISHING : '';
        $error.= ( $arrUser['end_of_publishing'] == '') ? ERROR_END_OF_PUBLISHING : '';
        $error.= ( $arrUser['campaign_name'] == '') ? ERROR_CAMPAIGN_NAME : '';
        $error.= ( $arrUser['discountValue'] == '') ? ERROR_DISCOUNT_VALUE : '';

        $_SESSION['post'] = "";

        $CategoryIconName = "cat_icon_" . md5(time());
        $info = pathinfo($_FILES["icon"]["name"]);

        if ($_POST['icon'] != "") {

            if (!empty($_FILES["icon"]["name"])) {

                if (strtolower($info['extension']) == "png") {
                    if ($_FILES["icon"]["error"] > 0) {
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

            //echo $_POST['smallimage']."iiiiiii".$category_image = $_POST["category_image"]; die();
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

        //// Upload Coupen image//////
        $coupenName = "cpn_" . md5(time());
        $info = pathinfo($_FILES["picture"]["name"]);


        //echo "Cat in".$_SESSION['preview']['large_image']; die();
        $arrUser['large_image'] = $_SESSION['preview']['large_image'];

        $_SESSION['preview'] = $arrUser;
        //echo $arrUser['small_image'].$error;  die();
        if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            $url = BASE_URL . 'editDeleteCampaign.php?campaignId=' . $campaignid;
            $inoutObj->reDirect($url);
            exit();
        }
        $preview = 0;
        if ($preview == 1) {
            $_SESSION['preview'] = $arrUser;
            $_SESSION['post'] = $_POST;
            $url = BASE_URL . 'editDeleteCampaignPreview.php?campaignId=' . $campaignid;
            $inoutObj->reDirect($url);
            exit();
        }


        ///////////////////////////

        $campaignId = uuid();
        /// Select company id of this user
        $QUE = "select company_id from company where u_id='" . $_SESSION['userid'] . "'";
        $res = mysqli_query($conn ,$QUE) or die("Get Company : " . mysqli_error($conn));
        $row = mysqli_fetch_array($res);
        $companyId = $row['company_id'];

        $catImg = IMAGE_AMAZON_PATH . 'category/' . $arrUser['small_image'];
        $copImg = IMAGE_AMAZON_PATH . 'coupon/' . $arrUser['large_image'];

        $arrUser['u_id'] = $_SESSION['userid'];
        $query = "INSERT INTO campaign(`campaign_id`,`company_id`,`u_id`, `small_image`,`large_image`, `spons`, `category`, `start_of_publishing`,`end_of_publishing`,`campaign_name`,`keywords`,`infopage`,`s_activ`,`value`)
                VALUES ('" . $campaignId . "','" . $companyId . "','" . $_SESSION['userid'] . "', '" . $catImg . "', '" . $copImg . "','" . $arrUser['spons'] . "','" . $arrUser['category'] . "','" . $arrUser['start_of_publishing'] . "','" . $arrUser['end_of_publishing'] . "','" . $arrUser['campaign_name'] . "','" . $arrUser['keywords'] . "','" . $arrUser['infopage'] . "','0', '".$arrUser['discountValue']."');";
        $res = mysqli_query($conn , $query) or die("Inset campaign : " . mysqli_error($conn));

        
         $SystemkeyId = uuid();
         $_SQL = "insert into lang_text(id,lang,text) values('" . $SystemkeyId . "','" . $arrUser['lang'] . "','" . $campaignId . "')";
         $res = mysqli_query($conn , $_SQL) or die("sub slogan in lang_text : " . mysqli_error($conn));


         $_SQL = "insert into campaign_keyword(`campaign_id`,`system_key`) values('" . $campaignId . "','" . $SystemkeyId . "')";
         $res = mysqli_query($conn ,$_SQL) or die("keyword in relational table : " . mysqli_error($conn));        


    
         $Systemkey_companyId = uuid();
         $_SQL = "insert into lang_text(id,lang,text) values('" . $Systemkey_companyId . "','" . $arrUser['lang'] . "','" . $companyId . "')";
         $res = mysqli_query($conn , $_SQL) or die("sub slogan in lang_text : " . mysqli_error($conn));


         $_SQL = "insert into campaign_keyword(`campaign_id`,`system_key`) values('" . $campaignId . "','" . $Systemkey_companyId . "')";
         $res = mysqli_query($conn , $_SQL) or die("keyword in relational table : " . mysqli_error($conn));

        ////////Slogan entry///////
        $sloganLangId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $sloganLangId . "','" . $arrUser['lang'] . "','" . $arrUser['offer_slogan_lang_list'] . "')";
        $res = mysqli_query($conn ,$_SQL) or die("title slogan in lang_text : " . mysqli_error($conn));

        ////////Sub Slogen entry///////
        $subSloganLangId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $subSloganLangId . "','" . $arrUser['lang'] . "','" . $arrUser['offer_sub_slogan_lang_list'] . "')";
        $res = mysqli_query($conn , $_SQL) or die("sub slogan in lang_text : " . mysqli_error($conn));

        ///Slogan and language table relation entry ///
        $_SQL = "insert into campaign_offer_slogan_lang_list(`campaign_id`,`offer_slogan_lang_list`) values('" . $campaignId . "','" . $sloganLangId . "')";
        $res = mysqli_query($conn , $_SQL) or die("Tital slogan id in relational table : " . mysqli_error($conn));


        ///Sub slogan and language table relation entry ///
        $_SQL = "insert into campaign_offer_sub_slogan_lang_list(`campaign_id`,`offer_sub_slogan_lang_list`) values('" . $campaignId . "','" . $subSloganLangId . "')";
        $res = mysqli_query($conn ,$_SQL) or die("Sub slogan id in relational table : " . mysqli_error($conn));

        ///Start date and End Date and Valid days entry ///

        if ($arrUser['valid_day'] != '') {
            $limitId = uuid();
            $_SQL = "insert into limit_period(`limit_id`,`end_time`,`start_time`,`valid_day`) values('" . $limitId . "','" . $arrUser['end_time'] . "','" . $arrUser['start_time'] . "','" . $arrUser['valid_day'] . "')";
            $res = mysqli_query($conn , $_SQL) or die("Insert limit period : " . mysqli_error($conn));

            ///RElation between LImit Period list and Coupon ///
            $_SQL = "insert into campaign_limit_period_list(`campaign_id`,`limit_period_list`) values('" . $campaignId . "','" . $limitId . "')";
            $res = mysqli_query($conn , $_SQL) or die("limit id in relational table : " . mysqli_error($conn));
        }



        $_SESSION['MESSAGE'] = CAMPAIGN_OFFER_SUCCESS;
        $url = BASE_URL . 'showCampaign.php';
        $inoutObj->reDirect($url);
        exit();
    }

/*
* Function Name     : createCoupons()
* Description       : add new column `group_id` in coupon table
*                     to insert campaignId/StandardId/AdvertiseId
*                     while generating coupon.
*                     Add new entry into coupon_keywords_lang_list as system_key
* Author            : Prashant kr. Awasthi  Date: 16th,Feb,2013  Creation
*/
    function createCoupons() {
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $data = array();
        $error = '';
        $curr_date = date("Y-m-d");
        $previous_date = date("Y-m-d", time() - (60 * 60 * 24));

        $QUE = "select * from c_s_rel where (start_of_publishing='" . $curr_date . "' OR start_of_publishing='" . $previous_date . "') AND activ='1'";
        $res_rel = mysqli_query($conn , $QUE) or die(mysqli_error($conn));
        while ($row = mysqli_fetch_array($res_rel)) {
            $campaignId = $row['campaign_id'];
            $productId = $row['product_id'];
            $advertiseId = $row['advertise_id'];
            $storeId = $row['store_id'];
            $csrelStartDate = $row['start_of_publishing'];



            if ($campaignId) {
                $QUE = "select * from c_s_rel where campaign_id='" . $campaignId . "' AND store_id='" . $storeId . "'";
                $res = mysqli_query($conn , $QUE) or die("Get Coupon : " . mysqli_error($conn));
                while ($row = mysqli_fetch_array($res)) {
                    $couponId = $row['coupon_id'];
                    $StoreCouponId = $row['store_id'];
                }

/////////////////////////for coupon delivey method/////////
                $QUE = "select code_type from campaign where campaign_id='" . $campaignId . "'";
                $res = mysqli_query($conn , $QUE) or die("Get  : " . mysqli_error($conn));
                $row = mysqli_fetch_array($res);
                $code_type = $row['code_type'];
                if ($code_type == 'GTIN13') {
                    ////////////check barcode is in the table or not
                    $QUE = "select delivery_method from coupon_delivery_method where store='" . $StoreCouponId . "' AND delivery_method = 'BARCODE'";
                    $res = mysqli_query($conn , $QUE) or die("Get  : " . mysqli_error($conn));
                    $row = mysqli_fetch_array($res);
                    $delivery_method = $row['delivery_method'];
                    if ($delivery_method == '') {
                        $coupon_delivery_type = 'PINCODE';
                    } else if ($delivery_method == 'AUTO'){
                        $coupon_delivery_type = 'AUTO';
                    } else {
                        $coupon_delivery_type = 'BARCODE';
                    }
                } else if ($code_type == 'MOBILAB') {
                    $coupon_delivery_type = 'PINCODE';
                } else if ($code_type == '') {
                    $coupon_delivery_type = 'TIME_LIMIT';
                } else if ($code_type == 'CUSTOM') {
                    $coupon_delivery_type = 'PINCODE';
                }

                ////////////////////////////////////////////
                if (!$couponId) {

                    $que_camp = "SELECT campaign.*,sloganT.text as slogan,keyw.text as keyword,keyw.lang as lang3,sloganT.lang as lang1,subsloganT.text as subslogen,subsloganT.lang as lang2,campaign.infopage,campaign_limit_period_list.limit_period_list as limitPeriod,limit_period.*,cat_lng .text as categoryName,brands.*,
                       campaign_offer_slogan_lang_list.offer_slogan_lang_list as offer_slogen,campaign_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list as offer_sub_slogen,campaign_keyword.offer_keyword as offer_keyword,campaign_limit_period_list.limit_period_list as limit_period FROM campaign
                        LEFT JOIN  campaign_offer_slogan_lang_list          ON  campaign_offer_slogan_lang_list.campaign_id = campaign.campaign_id
                        LEFT JOIN  campaign_keyword          ON  campaign_keyword.campaign_id = campaign.campaign_id
                        LEFT JOIN    campaign_offer_sub_slogan_lang_list    ON  campaign_offer_sub_slogan_lang_list.campaign_id = campaign.campaign_id
                        LEFT JOIN  lang_text as sloganT             ON  campaign_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
                        LEFT JOIN    lang_text as subsloganT        ON  campaign_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = subsloganT.id
                        LEFT JOIN    lang_text as keyw        ON  campaign_keyword.offer_keyword  = keyw.id
                        LEFT JOIN  campaign_limit_period_list       ON campaign_limit_period_list.campaign_id =  campaign.campaign_id
                        LEFT JOIN limit_period                      ON limit_period.limit_id=campaign_limit_period_list.limit_period_list
                        LEFT JOIN  brands                           ON  brands.company_id=campaign.company_id
                        LEFT JOIN  category_names_lang_list  as cat_rel        ON  (cat_rel.category=campaign.category)
                        LEFT JOIN  lang_text as cat_lng        ON  (cat_lng.id=cat_rel.names_lang_list)

                      WHERE  campaign.campaign_id='" . $campaignId . "' AND cat_lng.lang = keyw.lang
                    AND cat_lng.lang = sloganT.lang
                    AND cat_lng.lang = subsloganT.lang group by lang1";

                    $q = $db->query($que_camp);
                    $couponId = uuid();
                    $couponFlag = 0;
                    $limitFlag = 0;


                    while ($rs = mysqli_fetch_array($q)) {
                        $data = $rs;
                        $sloganLangId = $data['offer_slogen'];
                        $subSloganLangId = $data['offer_sub_slogen'];
                        $keywordId = $data['offer_keyword'];
                        
                        $limitId = $data['limit_period'];

//                    $sloganLangId = uuid();
//                    $_SQL = "insert into lang_text(id,lang,text) values('" . $sloganLangId . "','" . $data['lang1'] . "','" . $data['slogan'] . "')";
//                    $res = mysql_query($_SQL) or die("title slogan in lang_text : " . mysql_error());
//                    ////////Sub Slogen entry///////
//                    $subSloganLangId = uuid();
//                    $_SQL = "insert into lang_text(id,lang,text) values('" . $subSloganLangId . "','" . $data['lang2'] . "','" . $data['subslogen'] . "')";
//                    $res = mysql_query($_SQL) or die("sub slogan in lang_text : " . mysql_error());
//
//                   ///////keyword
//                    $keywordId = uuid();
//                    $_SQL = "insert into lang_text(id,lang,text) values('" . $keywordId . "','" . $data['lang3'] . "','" . $data['keyword'] . "')";
//                    $res = mysql_query($_SQL) or die("keyword in lang_text : " . mysql_error());

                        if (!$couponFlag) {
                            // We have change start date to c_s_rel table start , according to new logic. Earlier it was campaign table start date.

// new viewopt Kent
                            $_SQL = "insert into coupon(`coupon_id`,`group_id`,`store`,`small_image`, `large_image`, category, `is_sponsored`, `valid_from`, `end_of_publishing`, `offer_type`,`product_info_link`,`view_opt`,`brand_name`,`brand_icon`,`coupon_delivery_type`,`code`,`code_type`,`value`)
                    values('" . $couponId . "','".$campaignId."','" . $storeId . "','" . $data['small_image'] . "','" . $data['large_image'] . "','" . $data['category'] . "','" . $data['spons'] . "','" . $csrelStartDate . "','" . $data['end_of_publishing'] . "','ONCE','" . $data['infopage'] . "','" . $data['view_opt'] . "','" . $data['brand_name'] . "','" . $data['icon'] . "','" . $coupon_delivery_type . "','" . $data['code'] . "','" . $data['code_type'] . "','" . $data['value'] . "');";
// end new viewopt Kent
                            $res = mysqli_query($conn , $_SQL) or die("Insert coupon : " . mysqli_error($conn));

                            if ($data['code'] == '') {
                                $query = "update coupon set `code` = NULL,`code_type` = NULL where coupon_id = '" . $couponId . "'";
                                $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
                            }

                            $couponFlag++;
                        }
                        /// SLogen anf language table relation entry ////
                        $_SQL = "insert into coupon_offer_title_lang_list(`coupon`,`offer_title_lang_list`) values('" . $couponId . "','" . $sloganLangId . "')";
                        $res = mysqli_query($conn , $_SQL) or die("Title slogan id in relational table : " . mysqli_error($conn));

                        ///Sub slogan and language table relation entry ///
                        $_SQL = "insert into coupon_offer_slogan_lang_list(`coupon`,`offer_slogan_lang_list`) values('" . $couponId . "','" . $subSloganLangId . "')";
                        $res = mysqli_query($conn , $_SQL) or die("Sub slogan id in relational table : " . mysqli_error($conn));

                        ///keyword
                        $_SQL = "insert into coupon_keywords_lang_list(`coupon`,`keywords_lang_list`) values('" . $couponId . "','" . $keywordId . "')";
                        $res = mysqli_query($conn , $_SQL) or die("Sub slogan id in relational table : " . mysqli_error($conn));

                        ///system_key
                        $sqlSysKey = "SELECT system_key FROM campaign_keyword WHERE campaign_id='".$data['campaign_id']."' AND system_key<>''";
                        $resSysKey = mysqli_query($conn , $sqlSysKey) or die("Get campaign system_key : " . mysqli_error($conn));
                        while($rowSysKey = mysql_fetch_array($resSysKey))
                        {
                            $_SQL = "insert into coupon_keywords_lang_list(`coupon`,`keywords_lang_list`) values('" . $couponId . "','" . $rowSysKey['system_key'] . "')";
                            $res = mysqli_query($conn , $_SQL) or die("system_key id in relational table 1:" . mysqli_error($conn));
                        }

                        ///Start date and End Date and Valid days entry ///
                        if (!$limitFlag) {
                            if ($data['limitPeriod']) {
//                        $limitId = uuid();
//                        $_SQL = "insert into limit_period(`limit_id`,`end_time`,`start_time`,`valid_day`) values('" . $limitId . "','" . $data['end_time'] . "','" . $data['start_time'] . "','" . $data['valid_day'] . "')";
//                        $res = mysql_query($_SQL) or die("Insert limit period : " . mysql_error());
                                ///RElation between LImit Period list and Coupon ///
                                $_SQL = "insert into coupon_limit_period_list(`coupon`,`limit_period_list`) values('" . $couponId . "','" . $limitId . "')";
                                $res = mysqli_query($conn , $_SQL) or die("limit id in relational table : " . mysqli_error($conn));
                                $limitFlag++;
                            }
                        }

                        $_SQL = "update c_s_rel SET `coupon_id`='" . $couponId . "' WHERE campaign_id='$campaignId' AND store_id='" . $storeId . "'";
                        $res = mysqli_query($conn , $_SQL) or die("limitttt id in relational table : " . mysqli_error($conn));
                    }
                }
            }else if ($advertiseId) {
                
                $QUE = "select * from c_s_rel where advertise_id='" . $advertiseId . "' AND store_id='" . $storeId . "'";
                $res = mysqli_query($conn , $QUE) or die("Get Coupon : " . mysqli_error($conn));
                while ($row = mysqli_fetch_array($res)) {
                    $couponId = $row['coupon_id'];
                    $StoreCouponId = $row['store_id'];
                }
                
                if (!$couponId) {

                    $que_camp = "SELECT advertise.*,sloganT.text as slogan,keyw.text as keyword,keyw.lang as lang3,sloganT.lang as lang1,subsloganT.text as subslogen,subsloganT.lang as lang2,advertise.infopage,cat_lng .text as categoryName,brands.*,advertise_offer_slogan_lang_list.offer_slogan_lang_list as offer_slogen,advertise_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list as offer_sub_slogen,advertise_keyword.offer_keyword as offer_keyword FROM advertise
                        LEFT JOIN  advertise_offer_slogan_lang_list          ON  advertise_offer_slogan_lang_list.advertise_id = advertise.advertise_id
                        LEFT JOIN  advertise_keyword       ON  advertise_keyword.advertise_id = advertise.advertise_id
                        LEFT JOIN    advertise_offer_sub_slogan_lang_list    ON  advertise_offer_sub_slogan_lang_list.advertise_id = advertise.advertise_id
                        LEFT JOIN  lang_text as sloganT             ON  advertise_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
                        LEFT JOIN    lang_text as subsloganT        ON  advertise_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = subsloganT.id
                        LEFT JOIN    lang_text as keyw        ON  advertise_keyword.offer_keyword  = keyw.id                        
                        LEFT JOIN  brands                           ON  brands.company_id=advertise.company_id
                        LEFT JOIN  category_names_lang_list  as cat_rel        ON  (cat_rel.category=advertise.category)
                        LEFT JOIN  lang_text as cat_lng        ON  (cat_lng.id=cat_rel.names_lang_list)
                      WHERE  advertise.advertise_id='" . $advertiseId . "' AND cat_lng.lang = keyw.lang
                    AND cat_lng.lang = sloganT.lang
                    AND cat_lng.lang = subsloganT.lang group by lang1";

                    $q = $db->query($que_camp);
                    $couponId = uuid();
                    $couponFlag = 0;
                    
                    while ($rs = mysqli_fetch_array($q)) {
                        $data = $rs;
                        $sloganLangId = $data['offer_slogen'];
                        $subSloganLangId = $data['offer_sub_slogen'];
                        $keywordId = $data['offer_keyword'];
                        
//                    $sloganLangId = uuid();
//                    $_SQL = "insert into lang_text(id,lang,text) values('" . $sloganLangId . "','" . $data['lang1'] . "','" . $data['slogan'] . "')";
//                    $res = mysql_query($_SQL) or die("title slogan in lang_text : " . mysql_error());
//                    ////////Sub Slogen entry///////
//                    $subSloganLangId = uuid();
//                    $_SQL = "insert into lang_text(id,lang,text) values('" . $subSloganLangId . "','" . $data['lang2'] . "','" . $data['subslogen'] . "')";
//                    $res = mysql_query($_SQL) or die("sub slogan in lang_text : " . mysql_error());
//
//                   ///////keyword
//                    $keywordId = uuid();
//                    $_SQL = "insert into lang_text(id,lang,text) values('" . $keywordId . "','" . $data['lang3'] . "','" . $data['keyword'] . "')";
//                    $res = mysql_query($_SQL) or die("keyword in lang_text : " . mysql_error());
                        if (!$couponFlag) {
                            
                            $_SQL = "insert into coupon(`coupon_id`,`group_id`,`store`,`small_image`, `large_image`, category, `is_sponsored`, `valid_from`, `end_of_publishing`, `offer_type`,`product_info_link`,`view_opt`,`brand_name`,`brand_icon`,`coupon_delivery_type`,`value`)
                   values('" . $couponId . "','".$advertiseId."','" . $storeId . "','" . $data['small_image'] . "','" . $data['large_image'] . "','" . $data['category'] . "','" . $data['spons'] . "','" . $csrelStartDate . "','" . $data['end_of_publishing'] . "','ADVERTISE','" . $data['infopage'] . "','" . $data['view_opt'] . "','" . $data['brand_name'] . "','" . $data['icon'] . "','MANUAL_SWIPE','" . $data['value'] . "');"; 
                            //echo $error."Innnnnnn here";die();
                            $res = mysqli_query($conn , $_SQL) or die("Insert coupon : " . mysqli_error($conn));                           

                            $couponFlag++;
                        }
                        // echo $arrUser['small_image'];  echo $arrUser['large_image']; die();
                        /// SLogen anf language table relation entry ////
                        $_SQL = "insert into coupon_offer_title_lang_list(`coupon`,`offer_title_lang_list`) values('" . $couponId . "','" . $sloganLangId . "')";
                        $res = mysqli_query($conn , $_SQL) or die("Title slogan id in relational table : " . mysqli_error($conn));

                        ///Sub slogan and language table relation entry ///
                        $_SQL = "insert into coupon_offer_slogan_lang_list(`coupon`,`offer_slogan_lang_list`) values('" . $couponId . "','" . $subSloganLangId . "')";
                        $res = mysqli_query($conn ,$_SQL) or die("Sub slogan id in relational table : " . mysqli_error($conn));

                        ///keyword
                        $_SQL = "insert into coupon_keywords_lang_list(`coupon`,`keywords_lang_list`) values('" . $couponId . "','" . $keywordId . "')";
                        $res = mysqli_query($conn , $_SQL) or die("Sub slogan id in relational table : " . mysqli_error($conn));                        

                        ///system_key
                        $sqlSysKey = "SELECT system_key FROM advertise_keyword WHERE advertise_id='".$data['advertise_id']."' AND system_key<>''";
                        $resSysKey = mysqli_query($conn , $sqlSysKey) or die("Get advertise system_key : " . mysqli_error($conn));
                        while($rowSysKey = mysqli_fetch_array($resSysKey))
                        {
                            $_SQL = "insert into coupon_keywords_lang_list(`coupon`,`keywords_lang_list`) values('" . $couponId . "','" . $rowSysKey['system_key'] . "')";
                            $res = mysqli_query($conn , $_SQL) or die("system_key id in relational table 2: " . mysqli_error($conn));
                        }
                        
                        $_SQL = "update c_s_rel SET `coupon_id`='" . $couponId . "' WHERE advertise_id='".$advertiseId."' AND store_id='" . $storeId . "'";
                        $res = mysqli_query($conn , $_SQL) or die("limitttt id in relational table : " . mysqli_error($conn));
                    }
                }
            } else {

                $QUE = "select coupon_id from c_s_rel where product_id='" . $productId . "' AND store_id='" . $storeId . "'";
                $res = mysqli_query($conn , $QUE) or die("Get Coupon : " . mysqli_error($conn));
                while ($row = mysqli_fetch_array($res)) {
                    $couponId = $row['coupon_id'];
                }

                if (!$couponId) {

                    $query1 = "SELECT product.*, lang_text.text as slogen,keyw.text as keyword,keyw.lang as lang2,lang_text.lang as lang1,cat.text as categoryName,brands.*,
                    product_keyword.offer_keyword as offer_keyword,product_offer_slogan_lang_list.offer_slogan_lang_list as offer_slogan FROM product
            LEFT JOIN    product_offer_slogan_lang_list  ON   product_offer_slogan_lang_list.product_id = product.product_id
             LEFT JOIN    product_keyword  ON   product_keyword.product_id = product.product_id
            LEFT JOIN        lang_text                  ON   product_offer_slogan_lang_list.offer_slogan_lang_list  = lang_text.id
            LEFT JOIN    lang_text as keyw        ON  product_keyword.offer_keyword  = keyw.id
            LEFT JOIN  category  ON category.category_id = product.category
            LEFT JOIN  category_names_lang_list  ON category.category_id = category_names_lang_list.category
            LEFT JOIN  lang_text as cat  ON cat.id = category_names_lang_list.names_lang_list
            LEFT JOIN  brands         ON  brands.company_id=product.company_id
            
                WHERE product.product_id='".$productId."' AND cat.lang = lang_text.lang AND cat.lang = keyw.lang group by lang1";

                    $q1 = $db->query($query1);
                    $couponId = uuid();
                    $couponFlag = 0;

                    while ($rs1 = mysqli_fetch_array($q1)) {
                        $data = $rs1;
                        $sloganLangId = $data['offer_slogan'];
                        $keywordId = $data['offer_keyword'];

                        $query = "SELECT product_price_list.text as price FROM product
                 LEFT JOIN    product_price_list        ON   product_price_list.product_id = product.product_id

                WHERE product.product_id='$productId'  AND store_id='$storeId'";

                        $q = $db->query($query);
                        while ($rs = mysqli_fetch_array($q)) {
                            $data1 = $rs;
                            $subSloganLangId = $data1['price'];
                        }

                        $subSloganLangId = uuid();
                        $_SQL = "insert into lang_text(id,lang,text) values('" . $subSloganLangId . "','" . $data['lang1'] . "','" . $data1['price'] . "')";
                        $res = mysql_query($_SQL) or die("sub slogan in lang_text : " . mysql_error());

//                     $keywordId = uuid();
//                    $_SQL = "insert into lang_text(id,lang,text) values('" . $keywordId . "','" . $data['lang2'] . "','" . $data['keyword'] . "')";
//                    $res = mysql_query($_SQL) or die("sub slogan in lang_text : " . mysql_error());

                        if (!$couponFlag) {
                            $query = "INSERT INTO coupon(`coupon_id`,`group_id`,`store`,`small_image`, `large_image`, `is_sponsored`,`offer_type`,`product_info_link`, category,`valid_from`,`end_of_publishing`,`brand_name`,`brand_icon`,`coupon_delivery_type`,`code`,`code_type`)
                    VALUES ('" . $couponId . "','".$productId."','" . $storeId . "','" . $data['small_image'] . "','" . $data['large_image'] . "','" . $data['is_sponsored'] . "','ADVERTISE','" . $data['product_info_page'] . "','" . $data['category'] . "','" . $data['start_of_publishing'] . "','2020-03-09','" . $data['brand_name'] . "','" . $data['icon'] . "','MANUAL_SWIPE','" . $data['code'] . "','" . $data['code_type'] . "');";
                            $res = mysqli_query($conn ,$query) or die(mysqli_error($conn));
                            $couponFlag++;
                        }


                        $query = "update coupon set `code` = NULL,`code_type` = NULL where coupon_id = '" . $couponId . "'";
                        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

                        /// SLogen anf language table relation entry ////
                        $_SQL = "insert into coupon_offer_title_lang_list(`coupon`,`offer_title_lang_list`) values('" . $couponId . "','" . $sloganLangId . "')";
                        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
                        //Sub slogan and language table relation entry //
                        $_SQL = "insert into coupon_offer_slogan_lang_list(`coupon`,`offer_slogan_lang_list`) values('" . $couponId . "','" . $subSloganLangId . "')";
                        $res = mysqli_query($conn , $_SQL) or die("Sub slogan id in relational table : " . mysqli_error($conn));

                        //keyword //
                        $_SQL = "insert into coupon_keywords_lang_list(`coupon`,`keywords_lang_list`) values('" . $couponId . "','" . $keywordId . "')";
                        $res = mysqli_query($conn , $_SQL) or die("Sub slogan id in relational table : " . mysqli_error($conn));

                        ///system_key
                        $sqlSysKey = "SELECT system_key FROM product_keyword WHERE product_id='".$data['product_id']."' AND system_key<>''";
                        $resSysKey = mysqli_query($conn , $sqlSysKey) or die("Get product system_key : " . mysqli_error($conn));
                        while($rowSysKey = mysqli_fetch_array($resSysKey))
                        {
                            $_SQL = "insert into coupon_keywords_lang_list(`coupon`,`keywords_lang_list`) values('" . $couponId . "','" . $rowSysKey['system_key'] . "')";
                            $res = mysqli_query($conn , $_SQL) or die("system key id in relational table 3:".mysqli_error($conn));
                        }


                        $_SQL = "update  c_s_rel SET `coupon_id`= '" . $couponId . "',`end_of_publishing`= '2020-03-09'  WHERE product_id='$productId' AND store_id='" . $storeId . "'";
                        $res = mysqli_query($conn , $_SQL) or die("limitttt id in relational table : " . mysqli_error($conn));
                    }
                }
            }
        }
    }

    function deleteCoupons() {

        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $data = array();
        $error = '';


        $QUE = "select * from c_s_rel where end_of_publishing < CURDATE() AND activ='1'";
        $res = mysqli_query($conn , $QUE) or die(mysqli_error($conn));
      while($row = mysqli_fetch_array($res)) {
            $campaignId = $row['campaign_id'];
            $productId = $row['product_id'];
            $storeId = $row['store_id'];
            "coupon:" . $couponId = $row['coupon_id'];
            if ($campaignId && $couponId) {

                $query1 = "DELETE FROM coupon WHERE coupon_id = '" . $couponId . "'";
                $res1 = mysqli_query($conn , $query1) or die(mysqli_error($conn));

                $query2 = "select * from coupon_limit_period_list  where coupon = '" . $couponId . "'";
                $res2 = mysqli_query($conn , $query2) or die('1' . mysqli_error($conn));
                $rs2 = mysqli_fetch_array($res2);
                $limitId = $rs2['limit_period_list'];

                $_SQL3 = "DELETE FROM coupon_limit_period_list WHERE coupon = '" . $couponId . "'";
                $res3 = mysqli_query($conn , $_SQL3) or die(mysqli_error($conn));

                $query5 = "select * from coupon_offer_slogan_lang_list  where coupon = '" . $couponId . "'";
                $res5 = mysqli_query($conn , $query5) or die('1' . mysqli_error($conn));
                while ($rs5 = mysqli_fetch_array($res5)) {
                    $offslogen = $rs5['offer_slogan_lang_list'];
                    $_SQL6 = "DELETE FROM coupon_offer_slogan_lang_list WHERE coupon = '" . $couponId . "'";
                    $res6 = mysqli_query($conn , $_SQL6) or die(mysqli_error($conn));
                }


                $query8 = "select * from coupon_offer_title_lang_list  where coupon = '" . $couponId . "'";
                $res8 = mysqli_query($conn , $query8) or die('1' . mysqli_error($conn));
                while ($rs8 = mysqli_fetch_array($conn , $res8)) {
                    $offtitle = $rs8['offer_title_lang_list'];
                    $_SQL9 = "DELETE FROM coupon_offer_title_lang_list WHERE coupon = '" . $couponId . "'";
                    $res9 = mysqli_query($conn , $_SQL9) or die(mysqli_error($conn));
                }

                $query11 = "select * from coupon_keywords_lang_list  where coupon = '" . $couponId . "'";
                $res11 = mysqli_query($conn , $query11) or die('1' . mysqli_error($conn));
                while ($rs11 = mysqli_fetch_array($res11)) {
                    $ckeyword = $rs11['keywords_lang_list'];
                    $_SQL12 = "DELETE FROM coupon_keywords_lang_list WHERE coupon = '" . $couponId . "'";
                    $res12 = mysqli_query($conn , $_SQL12) or die(mysqli_error($conn));
                }


                $_SQL14 = "update c_s_rel SET `activ`='2' WHERE campaign_id='$campaignId' AND store_id='" . $storeId . "'";
                $res14 = mysqli_query($conn , $_SQL14) or die(mysqli_error($conn));
            } else {


                $query15 = "DELETE FROM coupon WHERE coupon_id = '" . $couponId . "'";
                $res15 = mysqli_query($conn , $query15) or die(mysqli_error($conn));

                $query16 = "select * from coupon_offer_slogan_lang_list  where coupon = '" . $couponId . "'";
                $res16 = mysqli_query($conn , $query16) or die('1' . mysqli_error($conn));
                while ($rs16 = mysqli_fetch_array($res16)) {
                    $offslogen = $rs16['offer_slogan_lang_list'];
                    $_SQL17 = "DELETE FROM coupon_offer_slogan_lang_list WHERE coupon = '" . $couponId . "'";
                    $res17 = mysqli_query($conn , $_SQL17) or die(mysqli_error($conn));
                }

                $query19 = "select * from coupon_offer_title_lang_list  where coupon = '" . $couponId . "'";
                $res19 = mysqli_query($conn , $query19) or die('1' . mysqli_error($conn));
                while ($rs19 = mysqli_fetch_array($res19)) {
                    $offtitle = $rs19['offer_title_lang_list'];
                    $_SQL20 = "DELETE FROM coupon_offer_title_lang_list WHERE coupon = '" . $couponId . "'";
                    $res20 = mysqli_query($conn , $_SQL20) or die(mysqli_error($conn));
                }

                $query22 = "select * from coupon_keywords_lang_list  where coupon = '" . $couponId . "'";
                $res22 = mysqli_query($conn , $query22) or die('1' . mysqli_error($conn));
                while ($rs22 = mysqli_fetch_array($res22)) {
                    $ckeyword22 = $rs['keywords_lang_list'];
                    $_SQL23 = "DELETE FROM coupon_keywords_lang_list WHERE coupon = '" . $couponId . "'";
                    $res23 = mysqli_query($conn , $_SQL23) or die(mysqli_error($conn));
                }
            }
           
        }
    }

    function showCoupons() {

        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $data = array();
        $error = '';

        echo $que_coup = "SELECT coupon.*,sloganT.text as slogan,keyw.text as keyword,subsloganT.text as subslogen,limit_period.* FROM coupon
                       
                        LEFT JOIN    coupon_offer_title_lang_list    ON  coupon_offer_title_lang_list.coupon = coupon.coupon_id
                        LEFT JOIN    coupon_keywords_lang_list    ON  coupon_keywords_lang_list.coupon = coupon.coupon_id

                        LEFT JOIN   lang_text as sloganT             ON    coupon_offer_title_lang_list.offer_title_lang_list = sloganT.id
                        LEFT JOIN   lang_text as keyw             ON    coupon_keywords_lang_list.keywords_lang_list  = keyw.id
                         LEFT JOIN   coupon_offer_slogan_lang_list    ON     coupon_offer_slogan_lang_list.coupon = coupon.coupon_id
                        LEFT JOIN    lang_text as subsloganT        ON   coupon_offer_slogan_lang_list.offer_slogan_lang_list = subsloganT.id
                        LEFT JOIN   coupon_limit_period_list       ON   coupon_limit_period_list.coupon =  coupon.coupon_id
                        LEFT JOIN  limit_period                    ON  limit_period.limit_id=coupon_limit_period_list.limit_period_list

                        WHERE  coupon.coupon_id='4e1fdafce0d4d'";
        $q = $db->query($que_coup);
        while ($rs = mysqli_fetch_array($q)) {
            $data = $rs;
        }
    }

    function companycountry() {
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
        $data = array();
        $error = '';

        $QUE = "select country from company where u_id = '" . $_SESSION['userid'] . "'";
        $res = mysqli_query($conn , $QUE) or die(mysql_error());
        $row = mysqli_fetch_array($res);
        $compcont = $row['country'];
        return $compcont;
    }

//    function showDeleteStandard($paging_limit='0 , 10') {
//
//        $db = new db();
//        $db->makeConnection();
//        $data = array();
//        $error = '';
//
//        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['ke'])) {
//            // $qstr1 = " store_name REGEXP '[[:<:]]".trim($_REQUEST['keyword'])."[[:>:]]' ";
//            // $qstr2 = " email REGEXP '[[:<:]]".trim($_REQUEST['key'])."[[:>:]]' ";
//            $set_keywords = "";
//            if ($_REQUEST['keyword']) {
//                $set_keywords.= 'lang_text.text LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
//            }
//            if ($_REQUEST['key']) {
//                $set_keywords.= 'product_name LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
//            }
//            if ($_REQUEST['ke']) {
//                $set_keywords.= 'keywords LIKE "%' . trim($_REQUEST['ke']) . '%" AND ';
//            }
//            // $set_keywords = "(u_id='".$_SESSION['userid']."' AND ".$qstr1.") OR
//            //                  (u_id='".$_SESSION['userid']."' AND ".$qstr2.")";
//            //$set_keywords = trim($set_keywords, " AND ");
//        }
//        else
//            $set_keywords = " 1 AND ";
//
//        $query = "SELECT product.*, lang_text.text as slogen,cat.text as category FROM product
//            LEFT JOIN          user                     ON   product.u_id = user.u_id
//            LEFT JOIN    product_offer_slogan_lang_list  ON   product_offer_slogan_lang_list.product_id = product.product_id
//            LEFT JOIN        lang_text                  ON   product_offer_slogan_lang_list.offer_slogan_lang_list  = lang_text.id
//            LEFT JOIN  category  ON category.category_id = product.category
//            LEFT JOIN  category_names_lang_list  ON category.category_id = category_names_lang_list.category
//            LEFT JOIN  lang_text as cat  ON cat.id = category_names_lang_list.names_lang_list
//            WHERE product.u_id='" . $_SESSION['userid'] . "' AND s_activ='2' AND $set_keywords 1  LIMIT {$paging_limit} ";
//
//        $q = $db->query($query);
//        while ($rs = mysql_fetch_array($q)) {
//            $data[] = $rs;
//        }
//        return $data;
//    }




    function viewDeleteStandardDetailById($productid) {
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $data = array();
        $error = '';
        $query = "SELECT product.*, lang_text.text as slogen,keyw.text as keyword,cat.text as category FROM product
            LEFT JOIN          user                     ON   product.u_id = user.u_id
            LEFT JOIN    product_offer_slogan_lang_list  ON   product_offer_slogan_lang_list.product_id = product.product_id
             LEFT JOIN    product_keyword  ON   product_keyword.product_id = product.product_id
            LEFT JOIN        lang_text                  ON   product_offer_slogan_lang_list.offer_slogan_lang_list  = lang_text.id
            LEFT JOIN        lang_text as keyw      ON   product_keyword.offer_keyword  = keyw.id
            LEFT JOIN  category  ON category.category_id = product.category
            LEFT JOIN  category_names_lang_list  ON category.category_id = category_names_lang_list.category
            LEFT JOIN  lang_text as cat  ON cat.id = category_names_lang_list.names_lang_list
           WHERE product.product_id='" . $productid . "' AND cat.lang = lang_text.lang ";
        ;

        $q = $db->query($query);
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
        }
        $QUE = "select store.*,product_price_list.text from store left join c_s_rel
        on(c_s_rel.store_id = store.store_id)
         left join product_price_list
        on(store.store_id = product_price_list.store_id) AND (c_s_rel.product_id = product_price_list.product_id)
        where c_s_rel.product_id ='" . $productid . "' AND activ='1'";
        $res = mysqli_query($conn , $QUE) or die(mysqli_error($conn));
        while ($row = mysqli_fetch_array($res)) {
            $storeDetails[] = $row;
        }
        $data['storeDetails'] = $storeDetails;

        return $data;
    }

    function editDeleteStandardPreview($productid, $reseller='') {
        $inoutObj = new inOut();

        $_SESSION['product_for_edit'] = serialize($_POST);

        if ($_FILES['picture']['name'] <> '') {
            //$_SESSION['preview']['large_image'] = $_FILES['picture']['name']; //<> '' ? $_FILES['picture']['name'] : $_POST['largeimage']['name'] ;
        }

        $_SESSION['preview']['offer_slogan_lang_list'] = $_POST['titleSloganStand'];
        $_SESSION['preview']['product_name'] = $_POST['productName'];
        $_SESSION['preview']['brand_name'] = $_POST['standOfferName'];
        $_SESSION['preview']['product_number'] = $_POST['productNumber'];
        $_SESSION['preview']['productId'] = $productid;
        $_SESSION['preview']['linkedCatStand'] = $_POST['linkedCatStand'];
        $_SESSION['preview']['lang'] = $_POST['lang'];

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

            if (strtolower($info['extension']) == "jpg" || strtolower($info['extension']) == "png" || strtolower($info['extension']) == "jpeg" || $file_extension == "gif" || $file_extension == "bmp") {
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
        } else {
            if ($_SESSION['preview']['large_image'] != "") {
                $arrUser['large_image'] = $_SESSION['preview']['large_image'];
            } elseif ($_POST['largeimage'] == "") {
                $error.=ERROR_LARGE_STANDARD_IMAGE;
            } else {
                if ($_SESSION['preview']['large_image'] != "") {
                    $arrUser['large_image'] = $_SESSION['preview']['large_image'];
                } elseif ($_POST['largeimage'] == "") {
                    $error.= ERROR_SMALL_IMAGE;
                } else {
                    $arrUser['large_image'] = $_POST['largeimage'];
                    $_SESSION['preview']['large_image'] = $arrUser['large_image'];
                }
            }
        }

        /////////////////////////// upload largeimages into server///////////////////
        $file2 = _UPLOAD_IMAGE_ . 'coupon/' . $arrUser['large_image'];
        $dir2 = "coupon";
        $command2 = IMAGE_DIR_PATH . $file2 . " " . $dir2;
        system($command2);

        $q = $this->editSaveDeleteProduct($productid, $reseller);
#-------------------------------------
    }

    function editSaveDeleteProduct($productid, $reseller='') {
        extract(((unserialize($_SESSION['product_for_edit']))));
        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $arrUser = array();
        $error = '';

        $arrUser['offer_slogan_lang_list'] = addslashes($titleSloganStand);

        if ($_POST['icon'] == "") {
            $arrUser['small_image'] = $_POST['category_image'];
        } else {
            $arrUser['small_image'] = $_POST['icon'];
        }
        $arrUser['is_sponsored'] = $sponsStand;
        $arrUser['category'] = $linkedCatStand;
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
        $arrUser['product_name'] = addslashes($productName);
        $arrUser['ean_code'] = $eanCode;
        $arrUser['is_public'] = $publicProduct;
        $arrUser['product_number'] = $productNumber;
        $arrUser['start_of_publishing'] = $startDateStand;
        $arrUser['lang'] = $lang;
        $error.= ( $arrUser['offer_slogan_lang_list'] == '') ? ERROR_TITLE_SLOGAN : '';

        $error.= ( $arrUser['start_of_publishing'] == '') ? ERROR_START_OF_PUBLISHING : '';

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
                    $_SESSION['MESSAGE2'] = CRADIT_YOUR_ACCOUNT;

                    $url = BASE_URL . 'editDeleteStandard.php?productId='.$productid;
                    $inoutObj->reDirect($url);
                    exit();
                }
            }


            $query = "SELECT pre_loaded_value FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
            $rs = mysqli_fetch_array($res);
            $rs['pre_loaded_value'];
            if ($arrUser['is_sponsored'] == 1 && ($rs['pre_loaded_value'] == '0' || $rs['pre_loaded_value'] == null)) {
                $_SESSION['MESSAGE'] = INSUFFICIENT_BALANCE;
            }
        }


        $CategoryIconName = "cat_icon_" . md5(time());
        $info = pathinfo($_FILES["icon"]["name"]);
        // Opload images related to
        if (!empty($_FILES["icon"]["name"])) {
            if (!empty($_FILES["icon"]["name"])) {

                if (strtolower($info['extension']) == "png") {
                    if ($_FILES["icon"]["error"] > 0) {
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
        //// Upload Coupen image//////
        $coupenName = "cpn_" . md5(time());
        $info = pathinfo($_FILES["picture"]["name"]);

        if (!empty($_FILES["picture"]["name"])) {

            if (strtolower($info['extension']) == "jpg" || strtolower($info['extension']) == "png" || strtolower($info['extension']) == "jpeg" || $file_extension == "gif" || $file_extension == "bmp") {
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
                }
            } else {
                $error.=NOT_VALID_EXT;
            }
        } else {
            if ($_SESSION['preview']['large_image'] != "") {
                $arrUser['large_image'] = $_SESSION['preview']['large_image'];
            } elseif ($_POST['largeimage'] == "") {
                $error.=ERROR_LARGE_STANDARD_IMAGE;
            } else {
                if ($_SESSION['preview']['large_image'] != "") {
                    $arrUser['large_image'] = $_SESSION['preview']['large_image'];
                } elseif ($_POST['largeimage'] == "") {
                    $error.= ERROR_SMALL_IMAGE;
                } else {
                    $arrUser['large_image'] = $_POST['largeimage'];
                }
            }
        }

        /////////////////////////// upload largeimages into server///////////////////
        $file2 = _UPLOAD_IMAGE_ . 'coupon/' . $arrUser['large_image'];
        $dir2 = "coupon";
        $command2 = IMAGE_DIR_PATH . $file2 . " " . $dir2;
        system($command2);

        if ($error != '') {
            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            if ($reseller == '') {
                $url = BASE_URL . 'editDeleteStandard.php';
                $inoutObj->reDirect($url);
                exit();
            } else {
                $url = BASE_URL . 'editDeleteResellerStandard.php';
                $inoutObj->reDirect($url);
                exit();
            }
        } else {
            $_SESSION['post'] = "";
        }

        $preview = 0;
        if ($preview == 1) {
            $_SESSION['preview'] = $arrUser;
            $_SESSION['post'] = $_POST;
            $url = BASE_URL . 'newStandardOfferPreview.php';
            $inoutObj->reDirect($url);
            die();
        }

        $catImg = IMAGE_AMAZON_PATH . 'category/' . $arrUser['small_image'];
        $copImg = IMAGE_AMAZON_PATH . 'coupon/' . $arrUser['large_image'];
        $standUniqueId = uuid();
        //echo $standUniqueId;die();
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

        $query = "INSERT INTO product(`product_id`,`u_id`,`company_id`, `small_image`,`product_name`,`is_sponsored`, `category`,`large_image`,`product_info_page`,`ean_code`,`product_number`,`link`,`is_public`,`start_of_publishing`,`s_activ`)
        VALUES ('" . $standUniqueId . "','" . $_SESSION['userid'] . "','" . $companyId . "', '" . $catImg . "','" . $arrUser['product_name'] . "','" . $arrUser['is_sponsored'] . "','" . $arrUser['category'] . "',
           '" . $copImg . "','" . $arrUser['product_info_page'] . "','" . $arrUser['ean_code'] . "','" . $arrUser['product_number'] . "','" . $arrUser['link'] . "','" . $arrUser['is_public'] . "','" . $arrUser['start_of_publishing'] . "','0');";

        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

        if ($reseller != '') {
            $query = "UPDATE product SET `reseller_status` = 'P' WHERE product_id = '" . $standUniqueId . "'";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        }

        ////////Slogen entry///////
        $sloganLangId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $sloganLangId . "','" . $arrUser['lang'] . "','" . $arrUser['offer_slogan_lang_list'] . "')";
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
        
         
        $_SESSION['MESSAGE'] = STANDARD_OFFER_SUCCESS;
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

    function getPreLoadedValue() {

        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $query = "SELECT pre_loaded_value FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        $rs_comp = mysqli_fetch_array($res);
        $rs_comp['pre_loaded_value'];
        if ($rs_comp['pre_loaded_value']) {
            //$_SESSION['userid'];
            $pre_loaded_value = $rs_comp['pre_loaded_value'];
        } else {
            $query = "SELECT pre_loaded_value FROM user as usr
              LEFT JOIN company as camp ON       (camp.company_id=usr.company_id)
             WHERE usr.u_id='" . $_SESSION['userid'] . "'";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
            $rs_comp = mysqli_fetch_array($res);
            $pre_loaded_value = $rs_comp['pre_loaded_value'];
            //$rs['new_pre_loaded_value'];
        }
    }

    function getLang($campaignid) {

        $db = new db();

        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
        $data = array();
        $error = '';

        $query = "SELECT * FROM campaign_offer_slogan_lang_list WHERE campaign_id='" . $campaignid . "'";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        $rs = mysqli_fetch_array($res);
        $offer_slogan_lang_list = $rs['offer_slogan_lang_list'];

        $query = "SELECT * FROM lang_text WHERE id ='" . $offer_slogan_lang_list . "'";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        $rs = mysqli_fetch_array($res);
        $lang = $rs['lang'];
        return $lang;
    }

    

    function getLangProduct($productid) {
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $data = array();
        $error = '';

        $query = "SELECT * FROM product_offer_slogan_lang_list WHERE product_id='" . $productid . "'";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        $rs = mysqli_fetch_array($res);
        $offer_slogan_lang_list = $rs['offer_slogan_lang_list'];

        $query = "SELECT * FROM lang_text WHERE id ='" . $offer_slogan_lang_list . "'";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        $rs = mysqli_fetch_array($res);
        $lang = $rs['lang'];
        return $lang;
    }

    function deleteViewStore() {
        $storeId = $_REQUEST['storeId'];
        $campaignId = $_REQUEST['campaignId'];


        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $inoutObj = new inOut();

        $query = "select * from c_s_rel  where store_id = '" . $storeId . "' AND campaign_id = '" . $campaignId . "'"; //die();
        $res1 = mysqli_query($conn , $query) or die(mysqli_error($conn));
        $rs = mysqli_fetch_array($res1);
        $couponId = $rs['coupon_id'];

        if ($couponId) {
            $query = "select * from coupon_limit_period_list  where coupon = '" . $couponId . "'";
            $res = mysqli_query($conn , $query) or die('1' . mysqli_error($conn));
            $rs = mysqli_fetch_array($res);
            $limitId = $rs['limit_period_list'];


            $_SQL = "DELETE FROM coupon_limit_period_list WHERE coupon = '" . $couponId . "'";
            $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

            $query = "select * from coupon_offer_slogan_lang_list  where coupon = '" . $couponId . "'";
            $res = mysqli_query($conn , $query) or die('1' . mysqli_error($conn));
            $rs = mysqli_fetch_array($res);
            $offslogen = $rs['offer_slogan_lang_list'];

            $_SQL = "DELETE FROM coupon_offer_slogan_lang_list WHERE coupon = '" . $couponId . "'";
            $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

            $query = "select * from coupon_offer_title_lang_list  where coupon = '" . $couponId . "'";
            $res = mysqli_query($conn , $query) or die('1' . mysqli_error($conn));
            $rs = mysqli_fetch_array($res);
            $offtitle = $rs['offer_title_lang_list'];

            $_SQL = "DELETE FROM coupon_offer_title_lang_list WHERE coupon = '" . $couponId . "'";
            $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
        }

        $_SQL = "UPDATE c_s_rel SET activ='2' WHERE store_id = '" . $storeId . "' AND campaign_id='" . $campaignId . "'";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));



        $url = BASE_URL . 'showCampaign.php';
        $inoutObj->reDirect($url);
        exit();
    }

    function deleteViewstandStore() {
        $productId = $_REQUEST['productId'];
        $storeId = $_REQUEST['storeId'];

        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $inoutObj = new inOut();

        $query = "select * from c_s_rel  where store_id = '" . $storeId . "' AND  product_id = '" . $productId . "'";
        $res1 = mysqli_query($conn , $query) or die(mysqli_error($conn));
        $rs = mysqli_fetch_array($res1);

        $couponId = $rs['coupon_id'];



        if ($couponId) {
            $query = "DELETE FROM coupon WHERE coupon_id = '" . $couponId . "'";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

            $query = "select * from coupon_limit_period_list  where coupon = '" . $couponId . "'";
            $res = mysqli_query($conn , $query) or die('1' . mysqli_error($conn));
            $rs = mysqli_fetch_array($res);
            $limitId = $rs['limit_period_list'];


            $_SQL = "DELETE FROM coupon_limit_period_list WHERE coupon = '" . $couponId . "'";
            $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

            $query = "select * from coupon_offer_slogan_lang_list  where coupon = '" . $couponId . "'";
            $res = mysqli_query($conn , $query) or die('1' . mysqli_error($conn));
            $rs = mysqli_fetch_array($res);
            $offslogen = $rs['offer_slogan_lang_list'];

            $_SQL = "DELETE FROM coupon_offer_slogan_lang_list WHERE coupon = '" . $couponId . "'";
            $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

            $query = "select * from coupon_offer_title_lang_list  where coupon = '" . $couponId . "'";
            $res = mysqli_query($conn , $query) or die('1' . mysqli_error($conn));
            $rs = mysqli_fetch_array($res);
            $offtitle = $rs['offer_title_lang_list'];

            $_SQL = "DELETE FROM coupon_offer_title_lang_list WHERE coupon = '" . $couponId . "'";
            $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
        }

        $_SQL = "UPDATE c_s_rel SET activ='2' WHERE store_id = '" . $storeId . "' AND product_id='" . $productId . "'";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

        $_SQL = "DELETE FROM product_price_list WHERE store_id = '" . $storeId . "' AND  product_id = '" . $productId . "'";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

        $url = BASE_URL . 'showStandard.php';
        $inoutObj->reDirect($url);
        exit();
    }

    function viewPublicProductStandardDetailById($productid, $lang='ENG') {
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $data = array();
        $error = '';
        $query = "SELECT product.*, lang_text.text as slogen, keyw.text as keyword,cat.text as categoryName FROM product
            LEFT JOIN          user                     ON   product.u_id = user.u_id
            LEFT JOIN    product_offer_slogan_lang_list  ON   product_offer_slogan_lang_list.product_id = product.product_id
             LEFT JOIN    product_keyword  ON   product_keyword.product_id = product.product_id
            LEFT JOIN        lang_text                  ON   product_offer_slogan_lang_list.offer_slogan_lang_list  = lang_text.id
            LEFT JOIN        lang_text as keyw     ON   product_keyword.offer_keyword   = keyw.id
            LEFT JOIN  category  ON category.category_id = product.category
            LEFT JOIN  category_names_lang_list  ON category.category_id = category_names_lang_list.category
            LEFT JOIN  lang_text as cat  ON cat.id = category_names_lang_list.names_lang_list
           WHERE product.product_id='" . $productid . "' AND  cat.lang = '" . $lang . "' AND cat.lang = lang_text.lang
               AND cat.lang = keyw.lang AND cat.lang = lang_text.lang  GROUP BY product.product_id";

        $q = $db->query($query);
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
        }

        $QUE = "select store.*,product_price_list.text from store left join c_s_rel
        on(c_s_rel.store_id = store.store_id)
        left join product_price_list
        on(store.store_id = product_price_list.store_id) AND (c_s_rel.product_id = product_price_list.product_id)
        where c_s_rel.product_id ='" . $productid . "' AND u_id ='" . $_SESSION['userid'] . "'  AND activ='1'";
        $res = mysqli_query($conn , $QUE) or die(mysqli_error($conn));
        while ($row = mysqli_fetch_array($res)) {
            $storeDetails[] = $row;
        }
        $data['storeDetails'] = $storeDetails;
        return $data;
    }

    function addSaveLang($campaignid, $reseller='') {
        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $arrUser = array();
        $error = '';

        $arrUser['titleSlogan'] = addslashes($_POST['titleSlogan']);
        $arrUser['subSlogan'] = addslashes($_POST['subSlogan']);
        $arrUser['lang'] = $_POST['lang'];
        $arrUser['searchKeyword'] = addslashes($_POST['searchKeyword']);


        $query = "SELECT * FROM campaign
        LEFT JOIN campaign_offer_slogan_lang_list ON campaign.campaign_id = campaign_offer_slogan_lang_list.campaign_id
        LEFT JOIN lang_text ON campaign_offer_slogan_lang_list.offer_slogan_lang_list = lang_text.id
        where campaign.campaign_id = '" . $campaignid . "' AND lang_text.lang = '" . $arrUser['lang'] . "'"; //die();
        $res = mysqli_query($conn , $query) or die('1' . mysqli_error($conn));
        $row = mysqli_fetch_array($res);
        $text = $row['text'];
        $companyId = $row['company_id'];


        if ($text) {
            $_SESSION[MESSAGE] = ALREADY_LANG;
            if ($reseller == '') {
                $url = BASE_URL . 'showCampaign.php';
                $inoutObj->reDirect($url);
                exit();
            } else {
                $url = BASE_URL . 'showResellerCampaign.php';
                $inoutObj->reDirect($url);
                exit();
            }
        }


        if($arrUser['searchKeyword'] != "")
        {
        $keyId = uuid();
        $query = "INSERT INTO campaign_keyword(`campaign_id`,`offer_keyword`)
                VALUES ('" . $campaignid . "','" . $keyId . "');";
        $res = mysqli_query($conn , $query) or die("Inset campaign : " . mysqli_error($conn));

             $query = "INSERT INTO lang_text(`id`,`lang`,`text`)
                    VALUES ('" . $keyId . "','" . $arrUser['lang'] . "','" . $arrUser['searchKeyword'] . "');";
            $res = mysqli_query($conn , $query) or die("Inset campaign : " . mysqli_error($conn));
        }
        
        
         $SystemkeyId = uuid();
         $_SQL = "insert into lang_text(id,lang,text) values('" . $SystemkeyId . "','" . $arrUser['lang'] . "','" . $campaignid . "')";
         $res = mysqli_query($conn , $_SQL) or die("sub slogan in lang_text : " . mysqli_error($conn));

         $_SQL = "insert into campaign_keyword(`campaign_id`,`system_key`) values('" . $campaignid . "','" . $SystemkeyId . "')";
         $res = mysqli_query($conn , $_SQL) or die("keyword in relational table : " . mysqli_error($conn));
        
         $Systemkey_companyId = uuid();
         $_SQL = "insert into lang_text(id,lang,text) values('" . $Systemkey_companyId . "','" . $arrUser['lang'] . "','" . $companyId . "')";
         $res = mysqli_query($conn , $_SQL) or die("sub slogan in lang_text : " . mysqli_error($conn));

         $_SQL = "insert into campaign_keyword(`campaign_id`,`system_key`) values('" . $campaignid . "','" . $Systemkey_companyId . "')";
         $res = mysqli_query($conn , $_SQL) or die("keyword in relational table : " . mysqli_error($conn));

        $slogenId = uuid();
        $query = "INSERT INTO campaign_offer_slogan_lang_list(`campaign_id`,`offer_slogan_lang_list`)
                VALUES ('" . $campaignid . "','" . $slogenId . "');";
        $res = mysqli_query($conn , $query) or die("Inset campaign : " . mysqli_error($conn));

        $subslogenId = uuid();
        $query = "INSERT INTO campaign_offer_sub_slogan_lang_list(`campaign_id`,`offer_sub_slogan_lang_list`)
                VALUES ('" . $campaignid . "','" . $subslogenId . "');";
        $res = mysqli_query($conn , $query) or die("Inset campaign : " . mysqli_error($conn));

        $query = "INSERT INTO lang_text(`id`,`lang`,`text`)
                VALUES ('" . $slogenId . "','" . $arrUser['lang'] . "','" . $arrUser['titleSlogan'] . "');";
        $res = mysqli_query($conn , $query) or die("Inset campaign : " . mysqli_error($conn));

        $query = "INSERT INTO lang_text(`id`,`lang`,`text`)
                VALUES ('" . $subslogenId . "','" . $arrUser['lang'] . "','" . $arrUser['subSlogan'] . "');";
        $res = mysqli_query($conn , $query) or die("Inset campaign : " . mysqli_error($conn));

        $_SESSION[MESSAGE] = ADD_LANG;
        if ($reseller == '') {
            $url = BASE_URL . 'showCampaign.php';
            $inoutObj->reDirect($url);
            exit();
        } else {
            $url = BASE_URL . 'showResellerCampaign.php';
            $inoutObj->reDirect($url);
            exit();
        }
    }

    function addSaveStandLang($productid, $reseller='') {
        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $arrUser = array();
        $error = '';

        $arrUser['titleSloganStand'] = addslashes($_POST['titleSloganStand']);
        $arrUser['searchKeywordStand'] = addslashes($_POST['searchKeywordStand']);
        $arrUser['lang'] = $_POST['lang'];
        $arrUser['titleSloganStandDishDescription'] = addslashes($_POST['titleSloganStandDishDescription']);

        $query = "SELECT * FROM product
        LEFT JOIN product_offer_slogan_lang_list ON product.product_id = product_offer_slogan_lang_list.product_id
        LEFT JOIN lang_text ON product_offer_slogan_lang_list.offer_slogan_lang_list = lang_text.id
        where product.product_id = '" . $productid . "' AND lang_text.lang = '" . $arrUser['lang'] . "'"; //echo $query; die();
        $res = mysqli_query($conn , $query) or die('1' . mysqli_error($conn));
        $row = mysqli_fetch_array($res);
        $text = $row['text'];
          $companyId = $row['company_id'];

        if ($text) {
            $_SESSION[MESSAGE] = ALREADY_LANG;
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

        if($arrUser['searchKeywordStand']!= "")
        {
            
        $keyId = uuid();
        $query = "INSERT INTO product_keyword(`product_id`,`offer_keyword`)
                VALUES ('" . $productid . "','" . $keyId . "');";
        $res = mysqli_query($conn , $query) or die("Inset campaign : " . mysqli_error($conn));

             $query = "INSERT INTO lang_text(`id`,`lang`,`text`)
                    VALUES ('" . $keyId . "','" . $arrUser['lang'] . "','" . $arrUser['searchKeywordStand'] . "');";
            $res = mysqli_query($conn , $query) or die("Inset campaign : " . mysqli_error($conn));
        }

        $SystemkeyId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $SystemkeyId . "','" . $arrUser['lang'] . "','" . $productid . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

        $_SQL = "insert into product_keyword(`product_id`,`system_key`) values('" . $productid . "','" . $SystemkeyId . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
        
         $Systemkey_companyId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $Systemkey_companyId . "','" . $arrUser['lang'] . "','" . $companyId . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

        $_SQL = "insert into product_keyword(`product_id`,`system_key`) values('" . $productid . "','" . $Systemkey_companyId . "')";
        $res = mysqli_query($conn, $_SQL) or die(mysqli_error($conn));
        
        $slogenId = uuid();
        $query = "INSERT INTO product_offer_slogan_lang_list(`product_id`,`offer_slogan_lang_list`)
                VALUES ('" . $productid . "','" . $slogenId . "');";
        $res = mysqli_query($conn , $query) or die("Inset campaign : " . mysqli_error($conn));

        $query = "INSERT INTO lang_text(`id`,`lang`,`text`)
                VALUES ('" . $slogenId . "','" . $arrUser['lang'] . "','" . $arrUser['titleSloganStand'] . "');";
        $res = mysqli_query($conn , $query) or die("Inset campaign : " . mysqli_error($conn));
//Dish discription
        $sloganSubLangId = uuid();
        $dishDiscription = $arrUser['titleSloganStandDishDescription'];
        $_SQL = "insert into product_offer_sub_slogan_lang_list(`product_id`,`offer_sub_slogan_lang_list`) values('" . $productid . "','" . $sloganSubLangId . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

        $_SQL = "insert into lang_text(id,lang,text) values('" . $sloganSubLangId . "','" . $arrUser['lang'] . "','" . $dishDiscription . "')";
        $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

        $_SESSION[MESSAGE] = ADD_LANG;
        if ($reseller == '') {
            $url = BASE_URL . 'showStandard.php';
            $inoutObj->reDirect($url);
            exit;
        } else {
            $url = BASE_URL . 'showResellerStandard.php';
            $inoutObj->reDirect($url);
            exit;
        }
    }

    function rejectCampaignReseller($campaignid, $uId, $ccode) {
        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $arrUser = array();
        $error = '';

        $query = "SELECT * FROM company WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        $rs = mysqli_fetch_array($res);
        $resellerId = $rs['seller_id'];
        $companyId = $rs['company_id'];
        $codeCheck = $rs['ccode'];

        //// select company id using reseller id
        $query1 = "SELECT company_id FROM employer WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res1 = mysqli_query($conn, $query1) or die(mysqli_error($conn));
        $rs1 = mysqli_fetch_array($res1);
        $emplyCompanyId = $rs1['company_id'];


        $query2 = "SELECT seller_id FROM company WHERE company_id = '" . $emplyCompanyId . "'";
        $res2 = mysqli_query($conn , $query2) or die(mysqli_error($conn));
        $rs2 = mysqli_fetch_array($res2);
        $emplyResellerId = $rs2['seller_id'];

        if (($resellerId == '') && ($emplyResellerId == '')) {
            $message = RESELLER_REPLY;
            $url = BASE_URL . "viewResellerCampaign.php?campaignId=" . $campaignid . '&alt=' . alt;
            $inoutObj->reDirect($url);
            exit;
        } else if (($uId == $resellerId) || ($uId == $emplyResellerId)) {
            if ($codeCheck == '') {

                $query = "SELECT * FROM ccode WHERE ccode = '" . $ccode . "'";
                $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
                $rs = mysqli_fetch_array($res);
                $ccValue = $rs['value'];

                $query = "UPDATE company SET  `ccode` = '" . $ccode . "', `cc_value` = '" . $ccValue . "'  WHERE u_id = '" . $_SESSION['userid'] . "'";
                $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
            }

            $query = "UPDATE campaign SET `reseller_status` = 'R'  WHERE campaign_id = '" . $campaignid . "' ";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

            $url = BASE_URL . 'showCampaign.php';
            $inoutObj->reDirect($url);
            exit;
        } else if (($uId != $resellerId) || ($uId != $emplyResellerId)) {
            $message = RESELLER_REPLY;
            $url = BASE_URL . "viewResellerCampaign.php?campaignId=" . $campaignid . '&alt=' . alt;
            $inoutObj->reDirect($url);
            exit;
        }
    }

    function acceptCampaignReseller($campaignid, $uId, $ccode) {
        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $arrUser = array();
        $error = '';

        ////check reseller_id null or not
        $query = "SELECT * FROM company WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        $rs = mysqli_fetch_array($res);
        $resellerId = $rs['seller_id'];
        $companyId = $rs['company_id'];
        $codeCheck = $rs['ccode'];


        //// select company id using reseller id
        $query1 = "SELECT company_id FROM employer WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res1 = mysqli_query($conn , $query1) or die(mysqli_error($conn));
        $rs1 = mysqli_fetch_array($res1);
        $emplyCompanyId = $rs1['company_id'];


        $query2 = "SELECT seller_id FROM company WHERE company_id = '" . $emplyCompanyId . "'";
        $res2 = mysqli_query($conn , $query2) or die(mysqli_error($conn));
        $rs2 = mysqli_fetch_array($res2);
        $emplyResellerId = $rs2['seller_id'];

        if (($resellerId == '') && ($emplyResellerId == '')) {
            $message = RESELLER_REPLY;
            $url = BASE_URL . "viewResellerCampaign.php?campaignId=" . $campaignid . '&alt=' . alt;
            $inoutObj->reDirect($url);
            exit;
        } else if (($uId == $resellerId) || ($uId == $emplyResellerId)) {

            //get ccvalue according ccode
            $query = "SELECT * FROM ccode WHERE ccode = '" . $ccode . "'";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
            $rs = mysqli_fetch_array($res);
            $ccValue = $rs['value'];


            //////////////////check ccode which is exist in company table or not//////////
            if ($codeCheck == '') {

                //$date = date('Y-m-d H:i:s');
                $query = "UPDATE company SET `ccode` = '" . $ccode . "', `cc_value` = '" . $ccValue . "'  WHERE u_id = '" . $_SESSION['userid'] . "'";
                $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
            }

            //////////////////if ccode already exist in table//////////

            if ($companyId == '') {
                $companyId = $emplyCompanyId;
            }
            $query = "UPDATE campaign SET `reseller_status` = 'A' , `company_id` = '" . $companyId . "' , `accept_by` = '" . $_SESSION['userid'] . "' WHERE campaign_id = '" . $campaignid . "' ";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

            $url = BASE_URL . 'showCampaign.php';
            $inoutObj->reDirect($url);
            exit;
        } else if (($uId != $resellerId) || ($uId != $emplyResellerId)) {
            $message = RESELLER_REPLY;
            $url = BASE_URL . "viewResellerCampaign.php?campaignId=" . $campaignid . '&alt=' . alt;
            $inoutObj->reDirect($url);
            exit;
        }
    }

    function acceptProductReseller($productid, $uId, $ccode) {
        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $arrUser = array();
        $error = '';

        ////check reseller_id null or not
        $query = "SELECT * FROM company WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        $rs = mysqli_fetch_array($res);
        $resellerId = $rs['seller_id'];
        $companyId = $rs['company_id'];

        if ($resellerId == '') {
            $date = date('Y-m-d H:i:s');
            $query = "UPDATE company SET `seller_id` = '" . $uId . "' , `seller_date` = '" . $date . "', `ccode` = '" . $ccode . "' WHERE u_id = '" . $_SESSION['userid'] . "' ";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

            $query = "UPDATE product SET `reseller_status` = 'A' , `company_id` = '" . $companyId . "'  WHERE product_id = '" . $productid . "' ";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

            $url = BASE_URL . 'showStandard.php';
            $inoutObj->reDirect($url);
            exit;
        } else if ($uId == $resellerId) {
            $query = "UPDATE product SET reseller_status = 'A' , `company_id` = '" . $companyId . "' WHERE product_id = '" . $productid . "' ";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

            $url = BASE_URL . 'showStandard.php';
            $inoutObj->reDirect($url);
            exit;
        } else if ($uId != $resellerId) {
            $message = RESELLER_REPLY;
            $mailObj = new emails();
            $mailObj->sendBackReseller($uId, $message);
            $url = BASE_URL . "viewResellerStandard.php?productId=" . $productid . '&alt=' . alt;
            $inoutObj->reDirect($url);
            exit;
        }
    }

    function rejectProductReseller($productid) {
        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $arrUser = array();
        $error = '';



        $query = "UPDATE product SET `reseller_status` = 'R'  WHERE product_id = '" . $productid . "' ";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

        $url = BASE_URL . 'showStandard.php';
        $inoutObj->reDirect($url);
        exit;
    }

//////////////////////insert saveMobilabCampaign ///////////////////////

    function saveMobilabCampaign($result) {
        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $arrUser = array();
        $error = '';

        $couponId = $result->ListCouponsResult->CouponProduct->CouponId;
        $name = $result->ListCouponsResult->CouponProduct->Name;
        $value = $result->ListCouponsResult->CouponProduct->Value;
        $valueText = $result->ListCouponsResult->CouponProduct->ValueText;
        $validTo = $result->ListCouponsResult->CouponProduct->ValidTo;
        $validFrom = $result->ListCouponsResult->CouponProduct->ValidFrom;
        $category = $result->ListCouponsResult->CouponProduct->Category;
        $internalValue = $result->ListCouponsResult->CouponProduct->InternalValue;
        $maxNoOfCoupon = $result->ListCouponsResult->CouponProduct->MaxNrOfCoupons;
        $generatedCoupons = $result->ListCouponsResult->CouponProduct->GeneratedCoupons;
        $redeemedCoupons = $result->ListCouponsResult->CouponProduct->RedeemedCoupons;
        $statusCode = $result->ListCouponsResult->CouponProduct->StatusCode;
        $statusText = $result->ListCouponsResult->CouponProduct->StatusText;
        $store1 = $result->ListCouponsResult->CouponProduct->Stores->string['0'];
        $store2 = $result->ListCouponsResult->CouponProduct->Stores->string['1'];
        $ImageUrl = $result->ListCouponsResult->CouponProduct->ImageUrl;

        $category = trim($category);
        $categoryKeyword = $category;
// The code below is in comment as this code is likely from our first version and will likely never be used - Kent

///////////////////////////query for select category
// The code below alwas returns "" so something is wrong  - Kent
        $query = "SELECT cat.category_id FROM category AS cat, category_names_lang_list AS llist, lang_text AS ltext
WHERE ltext.text='" . $category . "' AND ltext.id=llist.names_lang_list AND llist.category=cat.category_id";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));

        $rs = mysqli_fetch_array($res);
        $catId = $rs['category_id'];


        if ($catId == '') {

            ////////////mail to admin for new category
// No point in sending this mail - Kent
           // $mailObj = new emails();
            //$mailObj->sendCategoryAdminMail($category);

            $query = "SELECT cat.category_id FROM category AS cat, category_names_lang_list AS llist, lang_text AS ltext
WHERE ltext.text='Other' AND ltext.id=llist.names_lang_list AND llist.category=cat.category_id";
            $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
            $rs = mysqli_fetch_array($res);
            $catId = $rs['category_id'];
        }
//echo "---------";
//echo $catId;
//////////////////////////// check couponId already in database or  not

        $query = "SELECT campaign_id FROM campaign WHERE campaign_name = '" . $couponId . "'";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        $rs = mysqli_fetch_array($res);
        $campId = $rs['campaign_id'];

        if ($campId == '') {
            $urlArray = explode('/', $ImageUrl);
            $imageName = $urlArray[count($urlArray) - 1];
            $nameArray = explode('.', $imageName);
            $imageExt = $nameArray[count($nameArray) - 1];
            $imageNameRandom = "cpn_" . md5(uniqid(mt_rand(), true));
            $CouponIconName = $imageNameRandom . '.' . $imageExt;
            $img = @file_get_contents($ImageUrl);
            @file_put_contents(UPLOAD_DIR . 'coupon/' . $CouponIconName, $img);
///// for small image
            $imageNameRandom2 = "cat_icon_" . md5(uniqid(mt_rand(), true));
            $CategoryIconName = $imageNameRandom2 . '.' . $imageExt;
            $fileOriginal = UPLOAD_DIR . 'coupon/' . $CouponIconName;
            $path = UPLOAD_DIR . "category/";
            $fileThumbnail = $path . $CategoryIconName;
            $crop = '5';
            $size = 'smallImg';
            createFileThumbnail($fileOriginal, $fileThumbnail, $size, $frontUpload = 0, $crop, $errorMsg);

//@file_put_contents($imageNameRandom,$img);


            $arrUser['small_image'] = $CategoryIconName;
            $arrUser['large_image'] = $CouponIconName;


            /////////////////////////// upload largeimages and smallimages into server///////////////////

            $file1 = _UPLOAD_IMAGE_ . 'category/' . $arrUser['small_image'];
            $dir1 = "category";
            $command = IMAGE_DIR_PATH . $file1 . " " . $dir1;
            system($command);

            $file2 = _UPLOAD_IMAGE_ . 'coupon/' . $arrUser['large_image'];
            $dir2 = "coupon";
            $command2 = IMAGE_DIR_PATH . $file2 . " " . $dir2;
            system($command2);

            $catImg = IMAGE_AMAZON_PATH . 'category/' . $arrUser['small_image'];
            $copImg = IMAGE_AMAZON_PATH . 'coupon/' . $arrUser['large_image'];

//////////////// query for select mobilab from patner table
            $query = "SELECT * FROM partner WHERE company_name = 'MOBILAB' ";
            $res = mysqli_query($conn , $query) or die("Inset campaign : " . mysqli_error($conn));
            $rs = mysqli_fetch_array($res);
            $patId = $rs['partner_id'];

//////////////////////query for insert
            $query = "select * from company where orgnr = '556646-7113'";
            $res = mysqli_query($conn , $query);
            $rs = mysqli_fetch_array($res);
            $campanyId = $rs['company_id'];
            $uId = $rs['u_id'];

            $campaignId = uuid();
            $query = "INSERT INTO campaign(`campaign_id`,`spons`,`start_of_publishing`,`end_of_publishing`,`campaign_name`,`s_activ`,`category`,`value`,`MaxNrOfCoupons`,`GeneratedCoupons`,`RedeemedCoupons`,`startValidity`,`small_image`,`large_image`,`code`,`code_type`,`partner_id`,`company_id`,`u_id`)
    VALUES('" . $campaignId . "','0','" . $validFrom . "','" . $validTo . "','" . $couponId . "','0','" . $catId . "','" . $value . "','" . $maxNoOfCoupon . "','" . $generatedCoupons . "','" . $redeemedCoupons . "','" . $validFrom . "','" . $catImg . "','" . $copImg . "','" . $couponId . "','MOBILAB','" . $patId . "','" . $campanyId . "','" . $uId . "')";
            $res = mysqli_query($conn , $query) or die("Inset campaign : " . mysqli_error($conn));

            $slogenId = uuid();
            $query = "INSERT INTO campaign_offer_slogan_lang_list(`campaign_id`,`offer_slogan_lang_list`)
VALUES ('" . $campaignId . "','" . $slogenId . "');";
            $res = mysqli_query($conn , $query) or die("Inset campaign : " . mysqli_error($conn));

            $name = mb_convert_encoding($name, "iso-8859-1", "utf-8");
            $query = "INSERT INTO lang_text(`id`,`lang`,`text`)
VALUES ('" . $slogenId . "','SWE','" . $name . "');";
            $res = mysqli_query($conn , $query) or die("Inset campaign : " . mysqli_error($conn));

            $subslogenId = uuid();
            $query = "INSERT INTO campaign_offer_sub_slogan_lang_list(`campaign_id`,`offer_sub_slogan_lang_list`)
 VALUES ('" . $campaignId . "','" . $subslogenId . "');";
            $res = mysqli_query($conn , $query) or die("Inset campaign : " . mysqli_error($conn));

            $valueText = mb_convert_encoding($valueText, "iso-8859-1", "utf-8");
            $query = "INSERT INTO lang_text(`id`,`lang`,`text`)
VALUES ('" . $subslogenId . "','SWE','" . $valueText . "');";
            $res = mysqli_query($conn , $query) or die("Inset campaign : " . mysqli_error($conn));

///////////insert keyword entry according to condition
            $keywordId = uuid();
            if (($categoryKeyword == 'Valentin') OR ($categoryKeyword == 'Tuggummi') OR ($categoryKeyword == 'Reztart') OR ($categoryKeyword == 'Choklad') OR ($categoryKeyword == 'Ost')
                    OR ($categoryKeyword == 'Godis') OR ($categoryKeyword == 'Glass') OR ($categoryKeyword == 'Julgåvor') OR ($categoryKeyword == 'Mejeri') OR ($categoryKeyword == 'Kaffe')) {
                $keyText = $categoryKeyword;

                $query = "INSERT INTO campaign_keyword(`campaign_id`,`offer_keyword`)
 VALUES ('" . $campaignId . "','" . $keywordId . "');";
                $res = mysqli_query($conn , $query) or die("Inset campaign : " . mysqli_error($conn));

                $keyText = mb_convert_encoding($keyText, "iso-8859-1", "utf-8");
                $query = "INSERT INTO lang_text(`id`,`lang`,`text`)
VALUES ('" . $keywordId . "','SWE','" . $keyText . "');";
                $res = mysqli_query($conn , $query) or die("Inset campaign : " . mysqli_error($conn));
            } else {
                $query = "INSERT INTO campaign_keyword(`campaign_id`,`offer_keyword`)
 VALUES ('" . $campaignId . "','" . $keywordId . "');";
                $res = mysqli_query($conn , $query) or die("Inset campaign : " . mysqli_error($conn));

                $query = "INSERT INTO lang_text(`id`,`lang`,`text`)
VALUES ('" . $keywordId . "','SWE','');";
                $res = mysqli_query($conn , $query) or die("Inset campaign : " . mysqli_error($conn));
            }

///////////////hardard code in cs rel table store id we will make it dynamic later
            $stoId = '38fccb57-6906-a9e3-9907-5712556671ac';
            $query = "INSERT INTO c_s_rel(`campaign_id`,`store_id`,`start_of_publishing`,`end_of_publishing`,`activ`)
VALUES ('" . $campaignId . "','" . $stoId . "','" . $validFrom . "','" . $validTo . "','1');";
            $res = mysqli_query($conn , $query) or die("Inset campaign : " . mysqli_error($conn));
        } else {

            $query = "UPDATE campaign SET `MaxNrOfCoupons` = '" . $maxNoOfCoupon . "',`GeneratedCoupons` = '" . $generatedCoupons . "',`RedeemedCoupons` = '" . $redeemedCoupons . "' WHERE campaign_name = '" . $couponId . "'";
            $res = mysqli_query($conn , $query) or die("Inset campaign : " . mysqli_error($conn));
        }
    }

//////////////////////////////////
///////////////////function for batch for financial service
/*
* Function Name     : saveFinancialService()
* Description       : Charge for transaction is done in relation (in percentage ) to discount. 
* Author            : Prashant kr. Awasthi  Date: 16th,Feb,2013  Creation
*/
    function saveFinancialService() {
        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $arrUser = array();
        $error = '';


        $queryq = "select * from transaction_receipt";
        $resq = mysqli_query($conn , $queryq) or die('1' . mysqli_error($conn));
        while ($rsq = mysqli_fetch_array($resq)) {
            $patnerId = $rsq['partner_id'];
            $couponId = $rsq['coupon_id'];
            //continue;
            //print_r($patnerId);echo "-----------";
            ////check this patner id is in financial_exception table or not

            $query1 = "select * from financial_exception where partner_id = '" . $patnerId . "'";
            $res1 = mysqli_query($conn , $query1) or die('10' . mysqli_error($conn));
            $rs1 = mysqli_num_rows($res1);

            ////// check  if both partner id is same then query will not excute//
            if ($rs1 > 0) {
                
            } else {

                /////////fetch campaign id from coupon id////
                $query2 = "select * from c_s_rel where coupon_id = '" . $couponId . "'";
                $res2 = mysqli_query($conn , $query2) or die('11' . mysqli_error($conn));
                $rs2 = mysqli_fetch_array($res2, 1);
                $campaignId = $rs2['campaign_id'];


                /////////fetch campany id from campaign id////
                $query3 = "select * from campaign where campaign_id = '" . $campaignId . "'";
                $res3 = mysqli_query($conn , $query3) or die('12' . mysql_error($conn));
                $rs3 = mysqli_fetch_array($res3, 1);
                $companyId = $rs3['company_id'];
                $discountValue = $rs3['value']; // fetch value as discount from campaign 

                //////fetch country /////////
                $query4 = "select country.printable_name,company.cc_value,company.pre_loaded_value from company left join country on country.iso = company.country
     where company.company_id = '" . $companyId . "'";
                $res4 = mysqli_query($conn , $query4) or die('13' . mysqli_error($conn));
                $rs4 = mysqli_fetch_array($res4);
                $countryName = $rs4['printable_name'];
                $ccValue = $rs4['cc_value'];
                $preLoadedValue = $rs4['pre_loaded_value'];

                ////////// fetch usage_fee
                $query9 = "select usage_fee from cost where country = '" . $countryName . "'";
                $res9 = mysqli_query($conn , $query9) or die('1' . mysqli_error($conn));
                $rs9 = mysqli_fetch_array($res9);
                
                // Charge for transaction is done in relation (in percentage ) to discount
                $usageFee = $discountValue * ($rs9['usage_fee']/100);

//////////conditon
                if ((($ccValue == '') or ($ccValue == 0)) and ($preLoadedValue > $usageFee)) {
                    $finPreValue = $preLoadedValue - $usageFee;
                    $query5 = "update company set `pre_loaded_value` = '" . $finPreValue . "' where company_id = '" . $companyId . "'";
                    $res5 = mysqli_query($conn , $query5) or die('14' . mysqli_error($conn));
                } else if ((($ccValue != '') or ($ccValue != 0)) and ($preLoadedValue > $usageFee)) {

                    $finCcValue = $ccValue - 1;
                    $query5 = "update company set `cc_value` = '" . $finCcValue . "' where company_id = '" . $companyId . "'";
                    $res5 = mysqli_query($conn , $query5) or die('15' . mysqli_error($conn));
                }

                ///////condition if preloaded value is less than
                else if ($preLoadedValue < $usageFee) {
                    $query6 = "select * from company where company_id = '" . $companyId . "'";
                    $res6 = mysqli_query($conn , $query6) or die('15' . mysqli_error($conn));
                    $rs6 = mysqli_fetch_array($res6);
                    $uId = $rs6['u_id'];
                    $mailObj = new emails();
                    $mailObj->sendDeactivateCampaignPreloadedMail($uId);

                    /////deactivate campaign
                    $query13 = "update campaign set `s_activ` = '3' where campaign_id = '" . $campaignId . "'";
                    $res13 = mysqli_query($conn , $query13) or die('16' . mysqli_error($conn));

                    /////delete coupon
                    $query7 = "DELETE FROM coupon WHERE coupon_id = '" . $couponId . "'";
                    $res7 = mysqli_query($conn , $query7) or die(mysqli_error($conn));

                    $query8 = "select * from coupon_limit_period_list  where coupon = '" . $couponId . "'";
                    $res8 = mysqli_query($conn , $query8) or die('1' . mysqli_error($conn));
                    $rs8 = mysqli_fetch_array($res8);
                    $limitId = $rs8['limit_period_list'];

                    $_SQL = "DELETE FROM coupon_limit_period_list WHERE coupon = '" . $couponId . "' AND limit_period_list = '" . $limitId . "' ";
                    $res = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));

                    $query10 = "select * from coupon_offer_slogan_lang_list  where coupon = '" . $couponId . "'";
                    $res10 = mysqli_query($conn , $query10) or die('1' . mysqli_error($conn));
                    while ($rs10 = mysqli_fetch_array($res10)) {
                        $offslogen = $rs10['offer_slogan_lang_list'];
                        $_SQL3 = "DELETE FROM coupon_offer_slogan_lang_list WHERE coupon = '" . $couponId . "'";
                        $res3 = mysqli_query($conn , $_SQL3) or die(mysqli_error($conn));
                    }


                    $query11 = "select * from coupon_offer_title_lang_list  where coupon = '" . $couponId . "'";
                    $res11 = mysqli_query($conn , $query11) or die('1' . mysqli_error($conn));
                    while ($rs11 = mysqli_fetch_array($res11)) {
                        $offtitle = $rs11['offer_title_lang_list'];
                        $_SQL5 = "DELETE FROM coupon_offer_title_lang_list WHERE coupon = '" . $couponId . "'";
                        $res5 = mysqli_query($conn , $_SQL5) or die(mysqli_error($conn));
                    }

                    $query12 = "select * from coupon_keywords_lang_list  where coupon = '" . $couponId . "'";
                    $res12 = mysqli_query($conn , $query12) or die('1' . mysqli_error($conn));
                    while ($rs12 = mysqli_fetch_array($res12)) {
                        $ckeyword = $rs12['keywords_lang_list'];
                        $_SQL7 = "DELETE FROM coupon_keywords_lang_list WHERE coupon = '" . $couponId . "'";
                        $res7 = mysqli_query($conn , $_SQL7) or die(mysqli_error($conn));
                    }
                    //////update c_s_rel
                    $_SQL9 = "UPDATE c_s_rel SET activ='3'  WHERE campaign_id = '" . $campaignId . "'";
                    $res9 = mysqli_query($conn, $_SQL9) or die(mysqli_error($conn));
                }
            }
        }
    }

//////////////////////// for sponsored coupon

    function saveSponsoresCoupon() {

        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $arrUser = array();
        $error = '';


        $query = "select * from coupon_usage_statistics";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        while ($rs = mysqli_fetch_array($res)) {
            $couponId = $rs['coupon_id'];
            $numViews = $rs['num_views'];

            $query2 = "select * from c_s_rel where coupon_id = '" . $couponId . "'";
            $res2 = mysqli_query($conn , $query2) or die(mysqli_error($conn));
            $rs2 = mysqli_fetch_array($res2, 1);
            $campaignId = $rs2['campaign_id'];


            /////////fetch campany id from campaign id////
            $query3 = "select * from campaign where campaign_id = '" . $campaignId . "'";
            $res3 = mysqli_query($conn , $query3) or die(mysqli_error($conn));
            $rs3 = mysqli_fetch_array($res3, 1);
            $companyId = $rs3['company_id'];
            $sponser = $rs3['spons'];

            //////fetch country /////////
            $query4 = "select country.printable_name,company.cc_value,company.pre_loaded_value,company.low_level from company left join country on country.iso = company.country
     where company.company_id = '" . $companyId . "'";
            $res4 = mysqli_query($conn , $query4) or die(mysqli_error($conn));
            $rs4 = mysqli_fetch_array($res4);
            $countryName = $rs4['printable_name'];
            $preLoadedValue = $rs4['pre_loaded_value'];
            $lowLevelAlert = $rs4['low_level'];



            ////////// fetch spons_fee
            $query8 = "select spons_fee from cost where country = '" . $countryName . "'";
            $res8 = mysqli_query($conn , $query8) or die(mysqli_error($conn));
            $rs8 = mysqli_fetch_array($res8);
            $sponsFee = $rs8['spons_fee'];


            /////////check campaign is sponserd or not
            if (($sponser == '1') and (($preLoadedValue > $sponsFee))) {

                $deductValue = $sponsFee * $numViews;
                $finPreValue = $preLoadedValue - $deductValue;
                $query5 = "update company set `pre_loaded_value` = '" . $finPreValue . "' where company_id = '" . $companyId . "'";
                $res5 = mysqli_query($conn , $query5) or die(mysqli_error($conn));
            } else if (($preLoadedValue < $lowLevelAlert) and ($preLoadedValue > $sponsFee) and ($sponser == '1')) {

                $query6 = "select u_id from company where company_id = '" . $companyId . "'";
                $res6 = mysqli_query($conn , $query6) or die(mysqli_error($conn));
                $rs6 = mysqli_fetch_array($res6);
                $uId = $rs6['u_id'];
                $mailObj = new emails();
                $mailObj->sendLessPreloadedValueMail($uId);
            } else if ($preLoadedValue < $sponsFee and ($sponser == '1')) {

                $query7 = "select * from company where company_id = '" . $companyId . "'";
                $res7 = mysqli_query($conn , $query7) or die(mysqli_error($conn));
                $rs7 = mysqli_fetch_array($res7);
                $uId = $rs7['u_id'];
                $mailObj = new emails();
                $mailObj->sendDeactivateCampaignPreloadedMail($uId);


                /////deactivate campaign table
                $query9 = "update campaign set `spons` = '3' where campaign_id = '" . $campaignId . "'";
                $res9 = mysqli_query($conn , $query9) or die(mysqli_error($conn));

                /////deactivate c_s_rel table
                $query10 = "update c_s_rel set `activ` = '3' where campaign_id = '" . $campaignId . "'";
                $res10 = mysqli_query($conn , $query10) or die(mysqli_error($conn));

                ///// change in coupon table is_sponserd into 0 from 1

                $query11 = "SELECT * FROM c_s_rel WHERE campaign_id = '" . $campaignId . "'";
                $res11 = mysqli_query($conn , $query11) or die(mysqli_error($conn));
                while ($arr11 = mysqli_fetch_array($res11)) {
                    $couponId = $arr11['coupon_id'];

                    $query12 = "UPDATE coupon SET `is_sponsored` = '0' WHERE coupon_id = '" . $couponId . "'";
                    $res12 = mysqli_query($conn , $query12) or die(mysqli_error($conn));
                }
            }
        }
    }


//////////////////////// for clicks coupon
/* Function Header :saveClicksCoupon()
*             Args: none
*           Errors: none
*     Return Value: none
*      Description: Function for batch for financial service.
*                   Calculate deduction amount for total click.
*           Author: Prashant kr. Awasthi  Date: 16th,Feb,2013  Creation
*/
    function saveClicksCoupon() {

        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $arrUser = array();
        $error = '';
        
        $query = "select * from coupon_usage_statistics";
        $res = mysqli_query($conn ,$query) or die(mysqli_error($conn));
        
        while ($rs = mysqli_fetch_array($res)) {
            $couponId = $rs['coupon_id'];
            $numClicks = $rs['num_loads'];

            $query2 = "select * from c_s_rel where coupon_id = '" . $couponId . "'";
            $res2 = mysqli_query($conn , $query2) or die(mysqli_error($conn));
            $rs2 = mysqli_fetch_array($res2, 1);
            $campaignId = $rs2['campaign_id'];


            /////////fetch campany id from campaign id////
            $query3 = "select * from campaign where campaign_id = '" . $campaignId . "'";
            $res3 = mysqli_query($conn , $query3) or die(mysqli_error($conn));
            $rs3 = mysqli_fetch_array($res3, 1);
            $companyId = $rs3['company_id'];            

            //////fetch country /////////
            $query4 = "select country.printable_name,company.cc_value,company.pre_loaded_value,company.low_level from company left join country on country.iso = company.country
     where company.company_id = '" . $companyId . "'";           
            
            $res4 = mysqli_query($conn , $query4) or die(mysqli_error($conn));
            $rs4 = mysqli_fetch_array($res4);
            $countryName = $rs4['printable_name'];
            $preLoadedValue = $rs4['pre_loaded_value'];
            $lowLevelAlert = $rs4['low_level'];

            ////////// fetch Clicks
            $query8 = "select clicks from cost where country = '" . $countryName . "'";
            $res8 = mysqli_query($conn , $query8) or die(mysqli_error($conn));
            $rs8 = mysqli_fetch_array($res8);
            $clicksFee = $rs8['clicks'];

            /////////check campaign is sponserd or not
            if ($preLoadedValue > $clicksFee) {

                $deductValue = $clicksFee * $numClicks;                
                $finPreValue = $preLoadedValue - $deductValue;
                $query5 = "update company set `pre_loaded_value` = '" . $finPreValue . "' where company_id = '" . $companyId . "'";
                $res5 = mysqli_query($conn , $query5) or die(mysqli_error($conn));
            } else if (($preLoadedValue < $lowLevelAlert) and ($preLoadedValue > $clicksFee)) {

                $query6 = "select u_id from company where company_id = '" . $companyId . "'";
                $res6 = mysqli_query($conn , $query6) or die(mysqli_error($conn));
                $rs6 = mysqli_fetch_array($res6);
                $uId = $rs6['u_id'];
                $mailObj = new emails();
                $mailObj->sendLessPreloadedValueMail($uId);
            } else if ($preLoadedValue < $clicksFee ) {

                $query7 = "select * from company where company_id = '" . $companyId . "'";
                $res7 = mysqli_query($conn , $query7) or die(mysqli_error($conn));
                $rs7 = mysqli_fetch_array($res7);
                $uId = $rs7['u_id'];
                $mailObj = new emails();
                $mailObj->sendDeactivateCampaignPreloadedMail($uId);


                /////deactivate campaign table
                $query9 = "update campaign set `s_activ` = '3' where campaign_id = '" . $campaignId . "'";
                $res9 = mysqli_query($conn , $query9) or die(mysqli_error($conn));

                /////deactivate c_s_rel table
                $query10 = "update c_s_rel set `activ` = '3' where campaign_id = '" . $campaignId . "'";
                $res10 = mysqli_query($conn , $query10) or die(mysqli_error($conn));                
            }
        }
    }
    
//////////////////////// for views coupon
/* Function Header :saveViewsCoupon()
*             Args: none
*           Errors: none
*     Return Value: none
*      Description: Function for batch for financial service.
*                   Calculate deduction amount for total views.
*           Author: Prashant kr. Awasthi  Date: 16th,Feb,2013  Creation
*/
    function saveViewsCoupon() {

        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $arrUser = array();
        $error = '';
        
        $query = "select * from coupon_usage_statistics";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        
        while ($rs = mysqli_fetch_array($res)) {
            $couponId = $rs['coupon_id'];
            $numViews = $rs['num_views'];

            $query2 = "select * from c_s_rel where coupon_id = '" . $couponId . "'";
            $res2 = mysqli_query($conn , $query2) or die(mysqli_error($conn));
            $rs2 = mysqli_fetch_array($res2, 1);
            $campaignId = $rs2['campaign_id'];


            /////////fetch campany id from campaign id////
            $query3 = "select * from campaign where campaign_id = '" . $campaignId . "'";
            $res3 = mysqli_query($conn , $query3) or die(mysqli_error($conn));
            $rs3 = mysqli_fetch_array($res3, 1);
            $companyId = $rs3['company_id'];            

            //////fetch country /////////
            $query4 = "select country.printable_name,company.cc_value,company.pre_loaded_value,company.low_level from company left join country on country.iso = company.country
     where company.company_id = '" . $companyId . "'";
            $res4 = mysqli_query($conn , $query4) or die(mysqli_error($conn));
            $rs4 = mysqli_fetch_array($res4);
            $countryName = $rs4['printable_name'];
            $preLoadedValue = $rs4['pre_loaded_value'];
            $lowLevelAlert = $rs4['low_level'];

            ////////// fetch Views
            $query8 = "select views from cost where country = '" . $countryName . "'";
            $res8 = mysqli_query($conn , $query8) or die(mysqli_error($conn));
            $rs8 = mysqli_fetch_array($res8);
            $viewsFee = $rs8['views'];


            /////////check campaign is sponserd or not
            if ($preLoadedValue > $viewsFee) {

                $deductValue = $viewsFee * $numViews;
                $finPreValue = $preLoadedValue - $deductValue;
                $query5 = "update company set `pre_loaded_value` = '" . $finPreValue . "' where company_id = '" . $companyId . "'";
                $res5 = mysqli_query($conn , $query5) or die(mysqli_error($conn));
            } else if (($preLoadedValue < $lowLevelAlert) and ($preLoadedValue > $viewsFee)) {

                $query6 = "select u_id from company where company_id = '" . $companyId . "'";
                $res6 = mysqli_query($conn , $query6) or die(mysqli_error($conn));
                $rs6 = mysqli_fetch_array($res6);
                $uId = $rs6['u_id'];
                $mailObj = new emails();
                $mailObj->sendLessPreloadedValueMail($uId);
            } else if ($preLoadedValue < $viewsFee ) {

                $query7 = "select * from company where company_id = '" . $companyId . "'";
                $res7 = mysqli_query($conn , $query7) or die(mysqli_error($conn));
                $rs7 = mysqli_fetch_array($res7);
                $uId = $rs7['u_id'];
                $mailObj = new emails();
                $mailObj->sendDeactivateCampaignPreloadedMail($uId);


                /////deactivate campaign table
                $query9 = "update campaign set `s_activ` = '3' where campaign_id = '" . $campaignId . "'";
                $res9 = mysqli_query($conn , $query9) or die(mysqli_error($conn));

                /////deactivate c_s_rel table
                $query10 = "update c_s_rel set `activ` = '3' where campaign_id = '" . $campaignId . "'";
                $res10 = mysqli_query($conn , $query10) or die(mysqli_error($conn));                
            }
        }
    }
    
///////////////////// transaction history
    function saveTransactionHistory() {
        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $arrUser = array();
        $error = '';


        $query = "select * from transaction_receipt";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        while ($rs = mysqli_fetch_array($res)) {
            $_SQL = "insert into transaction_receipt_history(client_id,coupon_id,partner_id,partner_ref,purchase_time,store_id,version)
        values('" . $rs['client_id'] . "','" . $rs['coupon_id'] . "','" . $rs['partner_id'] . "','" . $rs['partner_ref'] . "','" . $rs['purchase_time'] . "','" . $rs['store_id'] . "','" . $rs['version'] . "')";
            mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
        }
    }

///////////////////// Coupon Usage Statics history

    function saveCouponUsageHistory() {
        $inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $arrUser = array();
        $error = '';


        $query = "select * from coupon_usage_statistics";
        $res = mysqli_query($query) or die(mysqli_error($conn));
        while ($rs = mysqli_fetch_array($res)) {

            $numConsumes = $rs['num_consumes'];
            $numLoads = $rs['num_loads'];
            $numViews = $rs['num_views'];
            $sumConsumeDistToStore = $rs['sum_consume_dist_to_store'];
            $sumLoadDistToStore = $rs['sum_load_dist_to_store'];
            $sumViewDistToStore = $rs['sum_view_dist_to_store'];

            ////////// check coupon id exist or not
            $query1 = "select * from coupon_usage_statistics_history where coupon_id = '" . $rs['coupon_id'] . "'";
            $res1 = mysqli_query($conn , $query1) or die(mysqli_error($conn));
            $rs1 = mysqli_fetch_array($res1);
            $couponId = $rs1['coupon_id'];
            $numConsumes2 = $rs1['num_consumes'];
            $numLoads2 = $rs1['num_loads'];
            $numViews2 = $rs1['num_views'];
            $sumConsumeDistToStore2 = $rs1['sum_consume_dist_to_store'];
            $sumLoadDistToStore2 = $rs1['sum_load_dist_to_store'];
            $sumViewDistToStore2 = $rs1['sum_view_dist_to_store'];



            if ($couponId == '') {

                $_SQL = "insert into coupon_usage_statistics_history(coupon_id,num_consumes,num_loads,num_views,store_id,sum_consume_dist_to_store,sum_load_dist_to_store,sum_view_dist_to_store,version)
        values('" . $rs['coupon_id'] . "','" . $rs['num_consumes'] . "','" . $rs['num_loads'] . "','" . $rs['num_views'] . "','" . $rs['store_id'] . "','" . $rs['sum_consume_dist_to_store'] . "','" . $rs['sum_load_dist_to_store'] . "','" . $rs['sum_view_dist_to_store'] . "','" . $rs['version'] . "')";
                mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
                $_DELSQL = "DELETE FROM coupon_usage_statistics WHERE coupon_id='".$rs['coupon_id']."'";
                mysqli_query($conn , $_DELSQL) or die(mysqli_error($conn));
            } else {

                $finNumConsumes = $numConsumes + $numConsumes2;
                $finNumLoads = $numLoads + $numLoads2;
                $finNumViews = $numViews + $numViews2;
                $finSumConsumeDistToStore = $sumConsumeDistToStore + $sumConsumeDistToStore2;
                $finSumLoadDistToStore = $sumLoadDistToStore + $sumLoadDistToStore2;
                $finSumViewDistToStore = $sumViewDistToStore + $sumViewDistToStore2;

                $_SQL = "UPDATE coupon_usage_statistics_history SET `num_consumes` = '" . $finNumConsumes . "',`num_loads` = '" . $finNumLoads . "',`num_views` = '" . $finNumViews . "'
       ,`sum_consume_dist_to_store` = '" . $finSumConsumeDistToStore . "',`sum_load_dist_to_store` = '" . $finSumLoadDistToStore . "' ,`sum_view_dist_to_store` = '" . $finSumViewDistToStore . "'  WHERE coupon_id = '" . $couponId . "'";
                $res2 = mysqli_query($conn , $_SQL) or die(mysqli_error($conn));
                $_DELSQL = "DELETE FROM coupon_usage_statistics WHERE coupon_id='".$couponId."'";
                mysqli_query($conn , $_DELSQL) or die(mysqli_error($conn));
            }
        }
    }

    function getStoreDetail($storeId,$productId) {
       
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}

        $data = array();
        $query = "SELECT * FROM product_price_list LEFT JOIN store ON store.store_id = product_price_list.store_id
            WHERE product_price_list.store_id = '" . $storeId . "' AND product_id = '" . $productId . "'";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        $data = mysqli_fetch_array($res);
        return $data;
    }

    function saveEditStorePrice($storeId,$productId) {
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


        $q = $db->query("SELECT company.currencies as currency FROM user
             LEFT JOIN  company  ON  company.u_id  = user.u_id

                 WHERE user.u_id ='" . $_SESSION['userid'] . "' ");
        while ($rs = mysqli_fetch_array($q)) {
            $datal = $rs;
        }
//print_r($data);
        $arrUser['price'] = $_POST['price'];
        $arrUser['store_id'] = $storeId;
     // echo  $productId ;

        $_SESSION['post'] = "";

        $query1 = "SELECT lang_text.lang as language  FROM product
                        LEFT JOIN  product_offer_slogan_lang_list  ON product.product_id = product_offer_slogan_lang_list.product_id
                        LEFT JOIN  lang_text  ON lang_text.id = product_offer_slogan_lang_list.offer_slogan_lang_list
                        WHERE  product.product_id='" . $productId . "'";

        $q1 = $db->query($query1);
        while ($rs1 = mysqli_fetch_array($q1)) {
            $data = $rs1;
        }

        if ($data['language'] == ENG) {
            $arrUser['price'] = 'Price:' . $arrUser['price'] . 'Rupee';
        } else {
            $arrUser['price'] = 'Pris:' . $arrUser['price'] . 'Kr';
        }

         $_SQL = "update product_price_list set `product_id` =  '" . $productId . "', `store_id` =  '" . $arrUser['store_id'] . "',
                `text` =  '" . $arrUser['price'] . "',`lang` =  '" . $data['language'] . "' where product_id = '" . $productId . "' and store_id = '" . $arrUser['store_id'] . "'";

        $res = mysqli_query($conn , $_SQL) or die("Error in product_price_list : " . mysqli_error($conn));



        /////////////// update if coupon exist////////////////

         $query = "select * from c_s_rel  where product_id = '" . $productId . "'";
            $res2 = mysqli_query($conn , $query) or die(mysqli_error($conn));
            while ($rs = mysqli_fetch_array($res2)) {
                $couponId = $rs['coupon_id'];


                if ($couponId) {

                    // for sub slogen (price)

                    $query1 = "SELECT offer_slogan_lang_list  FROM coupon_offer_slogan_lang_list LEFT JOIN c_s_rel
                        ON c_s_rel.coupon_id = coupon_offer_slogan_lang_list.coupon
                        WHERE coupon_offer_slogan_lang_list.coupon  = '" . $couponId . "' AND c_s_rel.store_id = '" . $arrUser['store_id'] . "'";
                    $res1 = mysqli_query($conn , $query1) or die('2' . mysqli_error($conn));
                    while ($rs1 = mysqli_fetch_array($res1)) {
                        $subSlogenId1 = $rs1['offer_slogan_lang_list'];
                        
                   
                   $query = "UPDATE lang_text SET `text` = '" . $arrUser['price'] . "' WHERE id = '" . $subSlogenId1 . "'";
                    $res = mysqli_query($conn , $query) or die('3' . mysqli_error($conn));
               
                     }
                    
                    }

            }
        
        //$_SESSION['MESSAGE'] = COUPON_OFFER_SUCCESS;
        $url = BASE_URL . 'showStandard.php';
        $inoutObj->reDirect($url);
        exit();
    }


    function logs($str = ""){
        $t=time();
        // echo BASE_URL . "upload/log" . date("Ymd",$t) . ".txt";
        // die();

        // $myfile = fopen("upload/log" . date("Ymd",$t) . ".txt", "a") or die("Unable to open file!");

        try{
            $myfile = fopen("upload/log" . date("Ymd",$t) . ".txt", "a");
        }catch(Exception $ex){
            echo $ex;
            die();
        }

        $txt = date("Y-m-d",$t) . " - " . $str . "  \n";
        fwrite($myfile, $txt);
        fclose($myfile);
    }

}
?>
