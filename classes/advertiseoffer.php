<?php

//header('Content-Type: text/html; charset=utf-8');
//include('lib/resizer/resizer.php');

class advertiseoffer {
    /*
     *   Advertise Offer function
     */

    function showAdvertiseOfferDetailsRows() {
        $db = new db();
        $db->makeConnection();
        $data = array();

        $res = $this->searchAdvertise();
        $total_records = $db->numRows($res);
        return $total_records;
    }

    function showAdvertiseOfferDetails($paging_limit = '0 , 10') {
        $db = new db();
        $db->makeConnection();
        $data = array();

        $q = $this->searchAdvertise($paging_limit);
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }

// Change accoding to Advertise tables 
    function searchAdvertise($paging_limit = 0) {
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
            $limit = "LIMIT " . $paging_limit;

        $query = "SELECT * FROM employer WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res = mysqli_query($query);
        $rs = mysqli_fetch_array($res);
        $companyId = $rs['company_id'];

        if ($_REQUEST['m'] == "showadvtoffer") {
            $QUE = "SELECT advertise.*,sloganT.text as slogan,subsloganT.text as subslogen,keyw.text as keywordss, advertise.infopage,lang_text.text as category  FROM advertise
                        LEFT JOIN   advertise_offer_slogan_lang_list ON  advertise_offer_slogan_lang_list.advertise_id = advertise.advertise_id
                        LEFT JOIN   advertise_offer_sub_slogan_lang_list  ON  advertise_offer_sub_slogan_lang_list.advertise_id = advertise.advertise_id
                        LEFT JOIN   advertise_keyword  ON  advertise_keyword.advertise_id = advertise.advertise_id
                        LEFT JOIN   lang_text as sloganT ON  advertise_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
                        LEFT JOIN   lang_text as subsloganT ON advertise_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = subsloganT.id
                        LEFT JOIN   lang_text as keyw ON advertise_keyword.offer_keyword = keyw.id
                        LEFT JOIN  category  ON category.category_id = advertise.category
                        LEFT JOIN  category_names_lang_list  ON category.category_id = category_names_lang_list.category
                        LEFT JOIN  lang_text   ON lang_text.id = category_names_lang_list.names_lang_list
                        WHERE
                        advertise.company_id='" . $companyId . "' AND $set_keywords  end_of_publishing < CURDATE() AND s_activ!='2' AND lang_text.lang = subsloganT.lang AND (reseller_status = 'A' OR reseller_status = '') GROUP BY advertise_id " . $limit;
        } else {
            $QUE = "SELECT advertise.*,sloganT.text as slogan,subsloganT.text as subslogen,keyw.text as keyword, advertise.infopage,lang_text.text as category  FROM advertise
                        LEFT JOIN   advertise_offer_slogan_lang_list ON  advertise_offer_slogan_lang_list.advertise_id = advertise.advertise_id
                        LEFT JOIN   advertise_offer_sub_slogan_lang_list  ON  advertise_offer_sub_slogan_lang_list.advertise_id = advertise.advertise_id
                        LEFT JOIN   advertise_keyword  ON  advertise_keyword.advertise_id = advertise.advertise_id
                        LEFT JOIN   lang_text as sloganT ON  advertise_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
                        LEFT JOIN   lang_text as subsloganT ON advertise_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = subsloganT.id
                        LEFT JOIN   lang_text as keyw ON advertise_keyword.offer_keyword = keyw.id
                        LEFT JOIN  category  ON (category.category_id = advertise.category)
                        LEFT JOIN  category_names_lang_list  ON (category.category_id = category_names_lang_list.category)
                        LEFT JOIN  lang_text   ON lang_text.id = category_names_lang_list.names_lang_list

                        WHERE
                        advertise.company_id='" . $companyId . "' AND $set_keywords 1 AND end_of_publishing >= CURDATE() AND (s_activ='0' or s_activ='3') AND (reseller_status = 'A' OR reseller_status = '') GROUP BY advertise_id " . $limit;
        }

        $res = mysqli_query($QUE);
        return $res;
    }

    function showAllPublicAdvertiseOffers() {
        $db = new db();
        $db->makeConnection();
        $is_Public = array();
        $res = $this->searchPublicAdvertiseOffers();
        $total_records1 = $db->numRows($res);
        return $total_records1;
    }

    function showAllPublicAdvertiseOffersDetails($paging_l = '0 , 10') {
        $db = new db();
        $db->makeConnection();
        $is_Public = array();
        $q = $this->searchPublicAdvertiseOffers($paging_l);
        while ($rs = mysqli_fetch_array($q)) {
            $is_Public[] = $rs;
        }
        return $is_Public;
    }

    function searchPublicAdvertiseOffers($paging_l = 0) {
        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['ke'])) {
            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'advertise.keywords LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
        }
        else
            $set_keywords = " 1 AND ";
        if ($paging_l)
            $limit = "limit " . $paging_l;

        $QUE = "SELECT c_s_rel.*,advertise.* FROM c_s_rel
                        left join store on(c_s_rel.store_id=store.store_id)
                        left join advertise on(c_s_rel.advertise_id=advertise.advertise_id)
                         WHERE store.u_id='" . $_SESSION['userid'] . "' AND $set_keywords 1 AND advertise.s_activ='0' AND c_s_rel.activ='1'  AND advertise.u_id!='" . $_SESSION['userid'] . "' GROUP BY advertise.advertise_id " . $limit;
        $res = mysqli_query($QUE);
        return $res;
    }

    function saveNewAdvertiseOffersDetails($reseller = '') {

        // print_r($_POST); die();
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $error = '';

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
        $arrUser['advertise_name'] = addslashes($_POST['advertiseName']);
        $arrUser['keywords'] = addslashes($_POST['searchKeyword']);
//  New View Option Kent  -->
        $arrUser['viewopt'] = $_POST['viewopt'];
//  END  New View Option Kent  -->
        $arrUser['large_image'] = $_POST['picture'];
        $arrUser['infopage'] = $_POST['descriptive'];

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
        $error.= ( $arrUser['spons'] == '') ? ERROR_ADVERTISE_SPONSORS : '';
        $error.= ( $arrUser['category'] == '') ? ERROR_CATEGORY : '';
        $error.= ( $arrUser['start_of_publishing'] == '') ? ERROR_ADVERTISE_START_OF_PUBLISHING : '';
        $error.= ( $arrUser['end_of_publishing'] == '') ? ERROR_ADVERTISE_END_OF_PUBLISHING : '';
        $error.= ( $arrUser['advertise_name'] == '') ? ERROR_ADVERTISE_NAME : '';
//  New View Option Kent  -->
        $error.= ( $arrUser['viewopt'] == '') ? ERROR_VIEW_OPTION : '';
//  New View Option Kent  -->
        $_SESSION['post'] = "";
        // Url kept in the session variable..
        $_SESSION['post'] = $_POST;
        $_SESSION['URL2'] = $_SERVER['PHP_SELF'];

        if ($reseller == '') {

            $query = "SELECT pre_loaded_value FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
            $res = mysqli_query($query) or die(mysqli_error());
            $rs_comp = mysqli_fetch_array($res);
            $rs_comp['pre_loaded_value'];
            if ($rs_comp['pre_loaded_value']) {
                //$_SESSION['userid'];
                $pre_loaded_value = $rs_comp['pre_loaded_value'];
            } else {
                $query = "SELECT pre_loaded_value FROM user as usr
          LEFT JOIN company as comp ON       (comp.company_id=usr.company_id)
         WHERE usr.u_id='" . $_SESSION['userid'] . "'";
                $res = mysqli_query($query) or die(mysqli_error());
                $rs_comp = mysqli_fetch_array($res);
                $pre_loaded_value = $rs_comp['pre_loaded_value'];
                //$rs['new_pre_loaded_value'];
            }

            if ($_POST['sponsor'] == 1) {
                if (($pre_loaded_value == '0' || $pre_loaded_value == null)) {
                    $_SESSION['MESSAGE2'] = CRADIT_YOUR_ACCOUNT;


                    $url = BASE_URL . 'createAdvertise.php';
                    $inoutObj->reDirect($url);
                    exit();
                }
            }


            $query = "SELECT pre_loaded_value FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
            $res = mysqli_query($query) or die(mysqli_error());
            $rs = mysqli_fetch_array($res);
            $rs['pre_loaded_value'];
            //echo $_SESSION['userid'];
            if ($arrUser['is_sponsored'] == 1 && ($rs['pre_loaded_value'] == '0' || $rs['pre_loaded_value'] == null)) {
                $_SESSION['MESSAGE'] = INSUFFICIENT_BALANCE;
            }
        }

         // print_r($_POST); die();
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
                $url = BASE_URL . 'createAdvertise.php';
                $inoutObj->reDirect($url);
                exit();
            } else {
                $_SESSION['MESSAGE'] = $error;
                $_SESSION['post'] = $_POST;
                $url = BASE_URL . 'createResellerAdvertise.php';
                $inoutObj->reDirect($url);
                exit();
            }
        }

        $catImg = IMAGE_AMAZON_PATH . 'category/' . $arrUser['small_image'];
        $copImg = IMAGE_AMAZON_PATH . 'coupon/' . $arrUser['large_image'];
        $advertiseId = uuid();
        /// Select company id of this user
        $QUE = "select company_id from company where u_id='" . $_SESSION['userid'] . "'";
        $res = mysqli_query($QUE) or die(mysqli_error());
        $row = mysqli_fetch_array($res);
        $companyId = $row['company_id'];

        if ($companyId == '') {
            $QUE33 = "select company_id from employer where u_id='" . $_SESSION['userid'] . "'";
            $res33 = mysqli_query($QUE33) or die(mysqli_error());
            $rs33 = mysqli_fetch_array($res33);
            $empCompId = $rs33['company_id'];
            $companyId = $empCompId;
        }

//  New View Option Kent  -->
        $query = "INSERT INTO advertise(`advertise_id`,`company_id`,`u_id`, `small_image`,`large_image`, `spons`, `category`, `start_of_publishing`,`end_of_publishing`,`advertise_name`,`view_opt`,`infopage`)
                VALUES ('" . $advertiseId . "','" . $companyId . "','" . $_SESSION['userid'] . "', '" . $catImg . "', '" . $copImg . "','" . $arrUser['spons'] . "','" . $arrUser['category'] . "','" . $arrUser['start_of_publishing'] . "','" . $arrUser['end_of_publishing'] . "','" . $arrUser['advertise_name'] . "','" . $arrUser['viewopt'] . "','" . $arrUser['infopage'] . "');";
        $res = mysqli_query($query) or die(mysqli_error());

        if ($reseller != '') {
            $query = "UPDATE advertise SET `reseller_status` = 'P' WHERE advertise_id = '" . $advertiseId . "'";
            $res = mysqli_query($query);
        }

        ////////Slogen entry///////
        $sloganLangId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $sloganLangId . "','" . $arrUser['lang'] . "','" . $arrUser['offer_slogan_lang_list'] . "')";
        $res = mysqli_query($_SQL) or die(mysqli_error());
        //echo"here";die();
        ////////Sub Slogen entry///////
        $subSloganLangId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $subSloganLangId . "','" . $arrUser['lang'] . "','" . $arrUser['offer_sub_slogan_lang_list'] . "')";
        $res = mysqli_query($_SQL) or die(mysqli_error());

        //////keywords
        $keywordId = uuid();
        //if (trim($arrUser['keywords']) != "") 
        {
            $_SQL = "insert into lang_text(id,lang,text) values('" . $keywordId . "','" . $arrUser['lang'] . "','" . $arrUser['keywords'] . "')";
            $res = mysqli_query($_SQL) or die(mysqli_error());
            
             $_SQL = "insert into advertise_keyword(`advertise_id`,`offer_keyword`) values('" . $advertiseId . "','" . $keywordId . "')";
            $res = mysqli_query($_SQL) or die(mysqli_error());
        }

        $SystemkeyId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $SystemkeyId . "','" . $arrUser['lang'] . "','" . $advertiseId . "')";
        $res = mysqli_query($_SQL) or die(mysqli_error());

        $_SQL = "insert into advertise_keyword(`advertise_id`,system_key) values('" . $advertiseId . "','" . $SystemkeyId . "')";
        $res = mysqli_query($_SQL) or die(mysqli_error());


        $Systemkey_companyId = uuid();  // company ID as Key 
        $_SQL = "insert into lang_text(id,lang,text) values('" . $Systemkey_companyId . "','" . $arrUser['lang'] . "','" . $companyId . "')";
        $res = mysqli_query($_SQL) or die(mysqli_error());

        $_SQL = "insert into advertise_keyword(`advertise_id`,system_key) values('" . $advertiseId . "','" . $Systemkey_companyId . "')";
        $res = mysqli_query($_SQL) or die(mysqli_error());
        

        /// SLogen anf language table relation entry ////
        $_SQL = "insert into advertise_offer_slogan_lang_list(`advertise_id`,`offer_slogan_lang_list`) values('" . $advertiseId . "','" . $sloganLangId . "')";
        $res = mysqli_query($_SQL) or die(mysqli_error());

        ///Sub slogan and language table relation entry ///
        $_SQL = "insert into advertise_offer_sub_slogan_lang_list(`advertise_id`,`offer_sub_slogan_lang_list`) values('" . $advertiseId . "','" . $subSloganLangId . "')";
        $res = mysqli_query($_SQL) or die(mysqli_error());

      



        $_SESSION['preview'] = "";
        $_SESSION['post'] = '';
        $_POST = "";
        $_SESSION['askForAdvertiseStore'] = 1;

        $_SESSION['MESSAGE'] = ADVERTISE_OFFER_SUCCESS . $custom_msg;
        if ($reseller == '') {
            $url = BASE_URL . 'showAdvertise.php?advtId=' . $advertiseId;
            $inoutObj->reDirect($url);
            exit();
        } else {
            $url = BASE_URL . 'showResellerAdvertise.php?advtId=' . $advertiseId;
            $inoutObj->reDirect($url);
            exit();
        }
    }

    function viewadvertiseDetailById($advertiseid, $lang ) {
// removed Lang = 'SWE'
        $db = new db();
        $db->makeConnection();
        $data = array();
        $error = '';

        $sqlstr = "SELECT advertise.*,sloganT.text as slogan,subsloganT.text as subslogen,keyw.text as keyword, advertise.infopage,lang_text.text as categoryName  FROM advertise
                        LEFT JOIN  advertise_offer_slogan_lang_list   ON  advertise_offer_slogan_lang_list.advertise_id = advertise.advertise_id
                        LEFT JOIN  advertise_keyword    ON  advertise_keyword.advertise_id = advertise.advertise_id
                        LEFT JOIN    advertise_offer_sub_slogan_lang_list    ON  advertise_offer_sub_slogan_lang_list.advertise_id = advertise.advertise_id
                        LEFT JOIN  lang_text as sloganT             ON  advertise_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
                        LEFT JOIN    lang_text as subsloganT        ON  advertise_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = subsloganT.id
                        LEFT JOIN  lang_text as keyw             ON  advertise_keyword.offer_keyword  = keyw.id
                        LEFT JOIN  category  ON category.category_id = advertise.category
                        LEFT JOIN  category_names_lang_list  ON category.category_id = category_names_lang_list.category
                        LEFT JOIN  lang_text  ON lang_text.id = category_names_lang_list.names_lang_list

WHERE  advertise.advertise_id='" . $advertiseid . "' AND lang_text.lang = '" . $lang . "' AND lang_text.lang = subsloganT.lang AND lang_text.lang = sloganT.lang AND lang_text.lang = keyw.lang  GROUP BY advertise.advertise_id";
        $q = $db->query($sqlstr);
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
        }
        //  print_r ($data); die($sqlstr);

        $QUE = "select store.* from store left join c_s_rel
        on(c_s_rel.store_id = store.store_id)
        where c_s_rel.advertise_id ='" . $advertiseid . "' AND activ='1'";
        $res = mysqli_query($QUE) or die(mysqli_error());
        while ($row = mysqli_fetch_array($res)) {
            $storeDetails[] = $row;
        }
        $data['storeDetails'] = $storeDetails;
        //print_r($data['storeDetails']);
        //echo $_SESSION['userid'];
        return $data;
        //  print_r ($data); die("hg");
    }

    function getAdvertiseLang($advertiseid) {

        $db = new db();
        $db->makeConnection();
        $data = array();
        $error = '';

        $query = "SELECT * FROM advertise_offer_slogan_lang_list WHERE advertise_id='" . $advertiseid . "'";
        $res = mysqli_query($query) or die(mysqli_error());
        $rs = mysqli_fetch_array($res);
        $offer_slogan_lang_list = $rs['offer_slogan_lang_list'];


        $query = "SELECT * FROM lang_text WHERE id ='" . $offer_slogan_lang_list . "'";
        $res = mysqli_query($query) or die(mysqli_error());
        $rs = mysqli_fetch_array($res);
        $lang = $rs['lang'];

        return $lang;
    }

    /* Function Header :editSaveAdvertisePreview()
     *             Args: advertiseid
     *           Errors: none
     *     Return Value: none
     *      Description: To edit and show preview for advertise.
     */

    function editSaveAdvertisePreview($advertiseid, $reseller = '') {

        $inoutObj = new inOut();

        // Url kept in the session variable..
        $_SESSION['postPayment'] = $_POST;
        $_SESSION['URL2'] = $_SERVER['PHP_SELF'] . "?advertiseId=" . $advertiseid;

        if ($reseller == '') {
            $query = "SELECT pre_loaded_value FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
            $res = mysqli_query($query) or die(mysqli_error());
            $rs_comp = mysqli_fetch_array($res);
            $rs_comp['pre_loaded_value'];
            if ($rs_comp['pre_loaded_value']) {
                //$_SESSION['userid'];
                $pre_loaded_value = $rs_comp['pre_loaded_value'];
            } else {
                $query = "SELECT pre_loaded_value FROM user as usr
          LEFT JOIN company as comp ON       (comp.company_id=usr.company_id)
         WHERE usr.u_id='" . $_SESSION['userid'] . "'";
                $res = mysqli_query($query) or die(mysqli_error());
                $rs_comp = mysqli_fetch_array($res);
                $pre_loaded_value = $rs_comp['pre_loaded_value'];
                //$rs['new_pre_loaded_value'];
            }

            if ($_POST['sponsor'] == 1) {
                if (($pre_loaded_value == '0' || $pre_loaded_value == null)) {
                    $_SESSION['MESSAGE2'] = CRADIT_YOUR_ACCOUNT;


                    $url = BASE_URL . 'editAdvertise.php?advertiseId=' . $advertiseid . "&ldacc=1";
                    $inoutObj->reDirect($url);
                    exit();
                }
            }
        }


        $_SESSION['advertise_for_edit'] = serialize($_POST);

        if ($_FILES['picture']['name'] <> '') {
            
        }
        $_SESSION['preview']['advertiseId'] = $_POST['advertiseId'];

        $_SESSION['preview']['lang'] = $_POST['lang'];
        $_SESSION['preview']['offer_slogan_lang_list'] = $_POST['titleSlogan'];
        $_SESSION['preview']['offer_sub_slogan_lang_list'] = $_POST['subSlogan'];
        $_SESSION['preview']['advertiseId'] = $advertiseid;
        $_SESSION['preview']['linkedCat'] = $_POST['linkedCat'];
        $_SESSION['preview']['startDateLimitation'] = $_POST['startDateLimitation'];
        $_SESSION['preview']['endDateLimitation'] = $_POST['endDateLimitation'];

        //// Upload Coupen image//////
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

            if (strtolower($info['extension']) == "jpg" || strtolower($info['extension']) == "png" || strtolower($info['extension']) == "jpeg") {
                if ($_FILES["picture"]["error"] > 0) {
                    $error.=$_FILES["picture"]["error"] . "<br />";
                } else {
                    $coupon_filename = $coupenName . "." . strtolower($info['extension']);
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
        $q = $this->editSaveAdvertise($advertiseid, $reseller);
    }

    function editSaveAdvertise($advertiseid, $reseller = '') {
        //echo "tttt";die;
        extract(((unserialize($_SESSION['advertise_for_edit']))));
        // extract(((unserialize($_SESSION['advertise_for_edit_image']))));
        //echo "sasadas"; die();
        $inoutObj = new inOut();
        $db = new db();
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
        $arrUser['advertise_name'] = addslashes($advertiseName);
        $arrUser['keywords'] = addslashes($searchKeyword);
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
        $arrUser['lang'] = $lang;
        $error.= ( $arrUser['offer_slogan_lang_list'] == '') ? ERROR_TITLE_SLOGAN : '';
        $error.= ( $arrUser['offer_sub_slogan_lang_list'] == '') ? ERROR_SUB_SLOGAN : '';
        $error.= ( $arrUser['spons'] == '') ? ERROR_ADVERTISE_SPONSORS : '';
        $error.= ( $arrUser['category'] == '') ? ERROR_CATEGORY : '';
        $error.= ( $arrUser['start_of_publishing'] == '') ? ERROR_ADVERTISE_START_OF_PUBLISHING : '';
        $error.= ( $arrUser['end_of_publishing'] == '') ? ERROR_ADVERTISE_END_OF_PUBLISHING : '';
        $error.= ( $arrUser['advertise_name'] == '') ? ERROR_ADVERTISE_NAME : '';
        $_SESSION['post'] = "";

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

            if (!empty($category_image)) {

                $categoryImageName = explode(".", $category_image);
                $cat_filename = $CategoryIconName . "." . $categoryImageName[1];
                //move_uploaded_file($_FILES["icon"]["tmp_name"],UPLOAD_DIR."Category/" .$cat_filename);
                $fileOriginal = UPLOAD_DIR . "category_lib/" . $category_image;
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
                $url = BASE_URL . 'editAdvertise.php?advertiseId=' . $advertiseid;
                $inoutObj->reDirect($url);
                exit();
            } else {
                $url = BASE_URL . 'editAdvertise.php?advertiseId=' . $advertiseid . "&from=reseller";
                $inoutObj->reDirect($url);
                exit();
            }
        }

        $catImg = IMAGE_AMAZON_PATH . 'category/' . $arrUser['small_image'];
        $copImg = IMAGE_AMAZON_PATH . 'coupon/' . $arrUser['large_image'];

        ////////////////start date is more than current date
        $t = date("Y-m-d");

        if ($arrUser['start_of_publishing'] > $t) {

            $query = "select * from c_s_rel  where advertise_id = '" . $advertiseid . "'";
            $res1 = mysqli_query($query) or die(mysqli_error());
            while ($rs = mysqli_fetch_array($res1)) {
                $couponId = $rs['coupon_id'];

                if ($couponId) {

                    /////delete coupon
                    $query = "DELETE FROM coupon WHERE coupon_id = '" . $couponId . "'";
                    $res = mysqli_query($query) or die(mysqli_error());

                    $query = "select * from coupon_limit_period_list  where coupon = '" . $couponId . "'";
                    $res = mysqli_query($query) or die('1' . mysqli_error());
                    $rs = mysqli_fetch_array($res);
                    $limitId = $rs['limit_period_list'];


                    $_SQL = "DELETE FROM coupon_limit_period_list WHERE coupon = '" . $couponId . "' AND limit_period_list = '" . $limitId . "' ";
                    $res = mysqli_query($_SQL) or die(mysqli_error());

                    $query = "select * from coupon_offer_slogan_lang_list  where coupon = '" . $couponId . "'";
                    $res = mysqli_query($query) or die('1' . mysqli_error());
                    while ($rs = mysqli_fetch_array($res)) {
                        $offslogen = $rs['offer_slogan_lang_list'];

                        $_SQL1 = "DELETE FROM coupon_offer_slogan_lang_list WHERE coupon = '" . $couponId . "'";
                        $res1 = mysqli_query($_SQL1) or die(mysqli_error());
                    }


                    $query = "select * from coupon_offer_title_lang_list  where coupon = '" . $couponId . "'";
                    $res = mysqli_query($query) or die('1' . mysqli_error());
                    while ($rs = mysqli_fetch_array($res)) {
                        $offtitle = $rs['offer_title_lang_list'];

                        $_SQL1 = "DELETE FROM coupon_offer_title_lang_list WHERE coupon = '" . $couponId . "'";
                        $res1 = mysqli_query($_SQL1) or die(mysqli_error());
                    }

                    $query = "select * from coupon_keywords_lang_list  where coupon = '" . $couponId . "'";
                    $res = mysqli_query($query) or die('1' . mysqli_error());
                    while ($rs = mysqli_fetch_array($res)) {
                        $ckeyword = $rs['keywords_lang_list'];

                        $_SQL1 = "DELETE FROM coupon_keywords_lang_list WHERE coupon = '" . $couponId . "'";
                        $res1 = mysqli_query($_SQL1) or die(mysqli_error());
                    }

                    //////update c_s_rel
                    $_SQL = "UPDATE c_s_rel SET activ='2', start_of_publishing = '" . $arrUser['start_of_publishing'] . "', `end_of_publishing` = '" . $arrUser['end_of_publishing'] . "' WHERE advertise_id = '" . $advertiseId . "'";
                    $res = mysqli_query($_SQL) or die(mysqli_error());
                }
            }

            //echo $icon; die();
            if ($icon <> '' || $category_image <> '') {
                // rename(UPLOAD_DIR . "coupon/" . $_SESSION['preview']['small_image'], UPLOAD_DIR . "category/" . substr($_SESSION['preview']['small_image'], 5));


                $query = "UPDATE advertise SET  `small_image` = '" . $catImg . "' WHERE advertise_id= '" . $advertiseid . "'";
                $res = mysqli_query($query) or die('6' . mysqli_error());
            }

            //echo $_SESSION['preview']['large_image']; die();
            if ($_SESSION['preview']['large_image'] <> '') {
                //rename(UPLOAD_DIR . "coupon/" . $_SESSION['preview']['large_image'], UPLOAD_DIR . "coupon/" . substr($_SESSION['preview']['large_image'], 5));


                $query = "UPDATE advertise SET  large_image = '" . $copImg . "' WHERE advertise_id = '" . $advertiseid . "'";
                $res = mysqli_query($query) or die('7' . mysqli_error());
            }

            ////diferent language function update
            //for keywords
            $query = "select lang_text.text,lang_text.id from advertise_keyword 
                LEFT JOIN lang_text ON advertise_keyword.offer_keyword = lang_text.id  
                where advertise_keyword.advertise_id = '" . $advertiseid . "' AND lang_text.lang = '" . $arrUser['language'] . "'";
            $res = mysqli_query($query) or die('1' . mysqli_error());
            while ($rs = mysqli_fetch_array($res)) {
                $keyId = $rs['id'];
            }

            //echo $keyId;
            //echo $keyText;die();
            $query = "UPDATE lang_text SET `text` = '" . $arrUser['keywords'] . "'  WHERE id = '" . $keyId . "' AND  lang = '" . $arrUser['language'] . "' ";
            $res = mysqli_query($query) or die('3' . mysqli_error());

            // for title slogen


            $query = "select lang_text.text,lang_text.id from advertise_offer_slogan_lang_list LEFT JOIN lang_text ON advertise_offer_slogan_lang_list.offer_slogan_lang_list = lang_text.id  where advertise_offer_slogan_lang_list.advertise_id = '" . $advertiseid . "' AND lang_text.lang = '" . $arrUser['language'] . "'";
            $res = mysqli_query($query) or die('2' . mysqli_error());
            while ($rs = mysqli_fetch_array($res)) {
                $titleId = $rs['id'];
            }
            $query = "UPDATE lang_text SET `text` = '" . $arrUser['offer_slogan_lang_list'] . "' WHERE id = '" . $titleId . "' AND  lang = '" . $arrUser['language'] . "'";
            $res = mysqli_query($query) or die('3' . mysqli_error());

            // for sub slogen

            $query = "select lang_text.text,lang_text.id from advertise_offer_sub_slogan_lang_list LEFT JOIN lang_text ON advertise_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = lang_text.id  where advertise_offer_sub_slogan_lang_list.advertise_id = '" . $advertiseid . "' AND lang_text.lang = '" . $arrUser['language'] . "'";
            $res = mysqli_query($query) or die('2' . mysqli_error());
            while ($rs = mysqli_fetch_array($res)) {
                $subSlogenId = $rs['id'];
            }
            $query = "UPDATE lang_text SET `text` = '" . $arrUser['offer_sub_slogan_lang_list'] . "' WHERE id = '" . $subSlogenId . "' AND  lang = '" . $arrUser['language'] . "'";
            $res = mysqli_query($query) or die('3' . mysqli_error());
            ///////update c_s_rel

            $query = "UPDATE c_s_rel SET  start_of_publishing = '" . $arrUser['start_of_publishing'] . "', `end_of_publishing` = '" . $arrUser['end_of_publishing'] . "'  WHERE advertise_id = '" . $advertiseid . "'";
            $res = mysqli_query($query) or die('7' . mysqli_error());
        }

        //////if start date less than or equal to current date///////////
        if ($arrUser['start_of_publishing'] <= $t) {

            $query = "UPDATE advertise SET category = '" . $arrUser['category'] . "',spons = '" . $arrUser['spons'] . "',advertise_name = '" . $arrUser['advertise_name'] . "',infopage = '" . $arrUser['infopage'] . "', start_of_publishing = '" . $arrUser['start_of_publishing'] . "', end_of_publishing = '" . $arrUser['end_of_publishing'] . "'  WHERE advertise_id = '" . $advertiseid . "'";
            $res = mysqli_query($query) or die('2' . mysqli_error());

            //echo $icon; die();
            if ($icon <> '' || $category_image <> '') {
                $query = "UPDATE advertise SET  `small_image` = '" . $catImg . "' WHERE advertise_id= '" . $advertiseid . "'";
                $res = mysqli_query($query) or die('6' . mysqli_error());
            }

            if ($_SESSION['preview']['large_image'] <> '') {
                $query = "UPDATE advertise SET  large_image = '" . $copImg . "' WHERE advertise_id = '" . $advertiseid . "'";
                $res = mysqli_query($query) or die('7' . mysqli_error());
            }

            ////diferent language function update
            //for keywords
            $query = "select lang_text.text,lang_text.id from advertise_keyword 
                LEFT JOIN lang_text ON advertise_keyword.offer_keyword = lang_text.id  where advertise_keyword.advertise_id = '" . $advertiseid . "' AND lang_text.lang = '" . $arrUser['language'] . "'";
            $res = mysqli_query($query) or die('1' . mysqli_error());
            while ($rs = mysqli_fetch_array($res)) {
                $keyId = $rs['id'];
                $query = "UPDATE lang_text SET `text` = '" . $arrUser['keywords'] . "'  WHERE id = '" . $keyId . "' AND  lang = '" . $arrUser['language'] . "' ";
                $res = mysqli_query($query) or die('3' . mysqli_error());
            }
            // for title slogen


            $query = "select lang_text.text,lang_text.id from advertise_offer_slogan_lang_list LEFT JOIN lang_text ON advertise_offer_slogan_lang_list.offer_slogan_lang_list = lang_text.id  where advertise_offer_slogan_lang_list.advertise_id = '" . $advertiseid . "' AND lang_text.lang = '" . $arrUser['language'] . "'";
            $res = mysqli_query($query) or die('2' . mysqli_error());
            while ($rs = mysqli_fetch_array($res)) {
                $titleId = $rs['id'];


                $query = "UPDATE lang_text SET `text` = '" . $arrUser['offer_slogan_lang_list'] . "' WHERE id = '" . $titleId . "' AND  lang = '" . $arrUser['language'] . "'";
                $res = mysqli_query($query) or die('3' . mysqli_error());
            }
            // for sub slogen

            $query = "select lang_text.text,lang_text.id from advertise_offer_sub_slogan_lang_list LEFT JOIN lang_text ON advertise_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = lang_text.id  where advertise_offer_sub_slogan_lang_list.advertise_id = '" . $advertiseid . "' AND lang_text.lang = '" . $arrUser['language'] . "'";
            $res = mysqli_query($query) or die('2' . mysqli_error());
            while ($rs = mysqli_fetch_array($res)) {
                $subSlogenId = $rs['id'];


                $query = "UPDATE lang_text SET `text` = '" . $arrUser['offer_sub_slogan_lang_list'] . "' WHERE id = '" . $subSlogenId . "' AND  lang = '" . $arrUser['language'] . "'";
                $res = mysqli_query($query) or die('3' . mysqli_error());
            }

            //////////////update c_s_rel/////////////

            $query = "UPDATE c_s_rel SET  start_of_publishing = '" . $arrUser['start_of_publishing'] . "', `end_of_publishing` = '" . $arrUser['end_of_publishing'] . "'  WHERE advertise_id = '" . $advertiseid . "'";
            $res = mysqli_query($query) or die('7' . mysqli_error());

            $query = "select * from c_s_rel  where advertise_id = '" . $advertiseid . "'";
            $res1 = mysqli_query($query) or die(mysqli_error());
            while ($rs1 = mysqli_fetch_array($res1)) {
                $couponId = $rs1['coupon_id'];

                //echo $couponId;echo '-------';

                $query = "select * from coupon_limit_period_list  where coupon = '" . $couponId . "'";
                $res = mysqli_query($query) or die('1' . mysqli_error());
                $rs = mysqli_fetch_array($res);
                $limitId = $rs['limit_period_list'];

                $query = "UPDATE coupon SET category = '" . $arrUser['category'] . "',is_sponsored = '" . $arrUser['spons'] . "', valid_from = '" . $arrUser['start_of_publishing'] . "', end_of_publishing = '" . $arrUser['end_of_publishing'] . "', product_info_link = '" . $arrUser['infopage'] . "'  WHERE coupon_id = '" . $couponId . "'";
                $res = mysqli_query($query) or die('2' . mysqli_error());


                //echo $icon; die();
                if ($icon <> '' || $category_image <> '') {
                    $query = "UPDATE coupon SET  `small_image` = '" . $catImg . "' WHERE coupon_id= '" . $couponId . "'";
                    $res = mysqli_query($query) or die('6' . mysqli_error());
                }

                if ($_SESSION['preview']['large_image'] <> '') {
                    $query = "UPDATE coupon SET  large_image = '" . $copImg . "' WHERE coupon_id = '" . $couponId . "'";
                    $res = mysqli_query($query) or die('7' . mysqli_error());
                }

                ////diferent language function update in coupon
                //update keywords for coupon
                $query = "select lang_text.text,lang_text.id from coupon_keywords_lang_list LEFT JOIN lang_text ON coupon_keywords_lang_list.keywords_lang_list = lang_text.id  where coupon_keywords_lang_list.coupon = '" . $couponId . "' AND lang_text.lang = '" . $arrUser['language'] . "'";
                $res = mysqli_query($query) or die('1' . mysqli_error());
                while ($rs = mysqli_fetch_array($res)) {
                    $keyId = $rs['id'];
                }

                $query = "UPDATE lang_text SET `text` = '" . $arrUser['keywords'] . "'  WHERE id = '" . $keyId . "' AND  lang = '" . $arrUser['language'] . "' ";
                $res = mysqli_query($query) or die('3' . mysqli_error());

                // for title slogen for coupon
                $query = "select lang_text.text,lang_text.id from coupon_offer_title_lang_list LEFT JOIN lang_text ON coupon_offer_title_lang_list.offer_title_lang_list = lang_text.id  where coupon_offer_title_lang_list.coupon = '" . $couponId . "' AND lang_text.lang = '" . $arrUser['language'] . "'";
                $res = mysqli_query($query) or die('2' . mysqli_error());
                while ($rs = mysqli_fetch_array($res)) {
                    $titleId = $rs['id'];
                }
                $query = "UPDATE lang_text SET `text` = '" . $arrUser['offer_slogan_lang_list'] . "' WHERE id = '" . $titleId . "' AND  lang = '" . $arrUser['language'] . "'";
                $res = mysqli_query($query) or die('3' . mysqli_error());

                // for sub slogen for coupon

                $query = "select lang_text.text,lang_text.id from coupon_offer_slogan_lang_list 
                    LEFT JOIN lang_text ON coupon_offer_slogan_lang_list.offer_slogan_lang_list = lang_text.id  
                    where coupon_offer_slogan_lang_list.coupon = '" . $couponId . "' AND lang_text.lang = '" . $arrUser['language'] . "'";
                $res = mysqli_query($query) or die('2' . mysqli_error());
                while ($rs = mysqli_fetch_array($res)) {
                    $subSlogenId = $rs['id'];
                }
                $query = "UPDATE lang_text SET `text` = '" . $arrUser['offer_sub_slogan_lang_list'] . "' WHERE id = '" . $subSlogenId . "' AND  lang = '" . $arrUser['language'] . "'";
                $res = mysqli_query($query) or die('3' . mysqli_error());
            }
        }

        $_SESSION['MESSAGE'] = ADVERTISE_OFFER_SUCCESS;


        if ($reseller == '') {
            $url = BASE_URL . 'showAdvertise.php';
            // $url = BASE_URL.'editAdvertisePreview.php?advertiseId='.$advertiseid;
            $inoutObj->reDirect($url);
            exit();
        } else {
            $url = BASE_URL . 'showResellerAdvertise.php';
            // $url = BASE_URL.'editAdvertisePreview.php?advertiseId='.$advertiseid;
            $inoutObj->reDirect($url);
            exit();
        }
    }

    function showDeleteAdvertiseDetailsRows() {
        //echo kajdhs;die();
        $db = new db();
        $db->makeConnection();
        $is_Public = array();
        $error = '';
        $inoutObj = new inOut();
        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['ke'])) {
            // $qstr1 = " store_name REGEXP '[[:<:]]".trim($_REQUEST['keyword'])."[[:>:]]' ";
            // $qstr2 = " email REGEXP '[[:<:]]".trim($_REQUEST['key'])."[[:>:]]' ";
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
        $res = mysqli_query($query);
        $rs = mysqli_fetch_array($res);
        $companyId = $rs['company_id'];

        $Query = "SELECT advertise.*,sloganT.text as slogan,subsloganT.text as subslogen,keyw.text as keyword, advertise.infopage,lang_text.text as category FROM advertise
                        LEFT JOIN   advertise_offer_slogan_lang_list ON  advertise_offer_slogan_lang_list.advertise_id = advertise.advertise_id
                        LEFT JOIN   advertise_offer_sub_slogan_lang_list  ON  advertise_offer_sub_slogan_lang_list.advertise_id = advertise.advertise_id
                        LEFT JOIN   advertise_keyword  ON  advertise_keyword.advertise_id = advertise.advertise_id
                        LEFT JOIN   lang_text as sloganT ON  advertise_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
                        LEFT JOIN   lang_text as subsloganT ON advertise_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = subsloganT.id
                        LEFT JOIN   lang_text as keyw ON advertise_keyword.offer_keyword = keyw.id
                        LEFT JOIN  category  ON (category.category_id = advertise.category)
                        LEFT JOIN  category_names_lang_list  ON (category.category_id = category_names_lang_list.category)
                        LEFT JOIN  lang_text  ON lang_text.id = category_names_lang_list.names_lang_list
                        WHERE advertise.company_id = '" . $companyId . "' AND $set_keywords s_activ='2' AND lang_text.lang = subsloganT.lang AND (reseller_status = 'A' OR reseller_status = '') GROUP BY advertise_id ";

        //$QUE = "SELECT * FROM advertise WHERE u_id = '" . $_SESSION['userid'] . "' AND $set_keywords  s_activ='2'";

        $res = mysqli_query($Query) or die(mysqli_error());
        $total_records = $db->numRows($res);

        return $total_records;
    }

    function deleteAdvertise() {
        $advertiseid = $_REQUEST['advertiseId'];
        $reseller = $_REQUEST['reseller'];
        $db = new db();
        $inoutObj = new inOut();
        $db->makeConnection();

        $query16 = "select * from c_s_rel  where advertise_id = '" . $advertiseid . "'";
        $res16 = mysqli_query($query16) or die(mysqli_error());
        while ($rs16 = mysqli_fetch_array($res16)) {
            $couponId = $rs16['coupon_id'];
            $advertiseId = $rs16['advertise_id'];
            $storeId = $rs16['store_id'];
            // die();


            if ($advertiseId) {
                $_SQL14 = "UPDATE c_s_rel SET activ='2' WHERE advertise_id = '" . $advertiseId . "'";
                $res14 = mysqli_query($_SQL14) or die(mysqli_error());
            }

            if ($couponId) {

                /////delete coupon
                $query1 = "DELETE FROM coupon WHERE coupon_id = '" . $couponId . "'";
                $res1 = mysqli_query($query1) or die(mysqli_error());

                $query2 = "select * from coupon_limit_period_list  where coupon = '" . $couponId . "'";
                $res2 = mysqli_query($query2) or die('1' . mysqli_error());
                $rs2 = mysqli_fetch_array($res2);
                $limitId = $rs2['limit_period_list'];


                $_SQL3 = "DELETE FROM coupon_limit_period_list WHERE coupon = '" . $couponId . "' AND limit_period_list = '" . $limitId . "' ";
                $res3 = mysqli_query($_SQL3) or die(mysqli_error());

                $query5 = "select * from coupon_offer_slogan_lang_list  where coupon = '" . $couponId . "'";
                $res5 = mysqli_query($query5) or die('1' . mysqli_error());
                while ($rs5 = mysqli_fetch_array($res5)) {
                    $offslogen = $rs5['offer_slogan_lang_list'];

                    $_SQL6 = "DELETE FROM coupon_offer_slogan_lang_list WHERE coupon = '" . $couponId . "'";
                    $res6 = mysqli_query($_SQL6) or die(mysqli_error());
                }


                $query8 = "select * from coupon_offer_title_lang_list  where coupon = '" . $couponId . "'";
                $res8 = mysqli_query($query8) or die('1' . mysqli_error());
                while ($rs8 = mysqli_fetch_array($res8)) {
                    $offtitle = $rs8['offer_title_lang_list'];

                    $_SQL9 = "DELETE FROM coupon_offer_title_lang_list WHERE coupon = '" . $couponId . "'";
                    $res9 = mysqli_query($_SQL9) or die(mysqli_error());
                }

                $query11 = "select * from coupon_keywords_lang_list  where coupon = '" . $couponId . "'";
                $res11 = mysqli_query($query11) or die('1' . mysqli_error());
                while ($rs11 = mysqli_fetch_array($res11)) {
                    $ckeyword = $rs11['keywords_lang_list'];

                    $_SQL12 = "DELETE FROM coupon_keywords_lang_list WHERE coupon = '" . $couponId . "'";
                    $res12 = mysqli_query($_SQL12) or die(mysqli_error());
                }
            }
        }

        $_SQL15 = "UPDATE advertise SET s_activ='2' WHERE advertise_id='" . $advertiseid . "'";
        $q = $db->query($_SQL15);
        if ($reseller == '') {
            $url = BASE_URL . 'showAdvertise.php';
        } else {
            $url = BASE_URL . 'showResellerAdvertise.php';
        }
        $inoutObj->reDirect($url);
        exit();
    }

    function showDeleteAdvertise($paging_limit = '0 , 10') {

        //echo kjasd;die();
        $db = new db();
        $db->makeConnection();
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
        $res = mysqli_query($query);
        $rs = mysqli_fetch_array($res);
        $companyId = $rs['company_id'];

        $Query = "SELECT advertise.*,sloganT.text as slogan,subsloganT.text as subslogen,keyw.text as keyword, advertise.infopage,lang_text.text as category FROM advertise
                        LEFT JOIN   advertise_offer_slogan_lang_list ON  advertise_offer_slogan_lang_list.advertise_id = advertise.advertise_id
                        LEFT JOIN   advertise_offer_sub_slogan_lang_list  ON  advertise_offer_sub_slogan_lang_list.advertise_id = advertise.advertise_id
                         LEFT JOIN   advertise_keyword  ON  advertise_keyword.advertise_id = advertise.advertise_id
                        LEFT JOIN   lang_text as sloganT ON  advertise_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
                        LEFT JOIN   lang_text as subsloganT ON advertise_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = subsloganT.id
                        LEFT JOIN   lang_text as keyw ON advertise_keyword.offer_keyword = keyw.id
                        LEFT JOIN  category  ON (category.category_id = advertise.category)
                        LEFT JOIN  category_names_lang_list  ON (category.category_id = category_names_lang_list.category)
                        LEFT JOIN  lang_text  ON lang_text.id = category_names_lang_list.names_lang_list
                        WHERE advertise.company_id = '" . $companyId . "' AND $set_keywords s_activ='2' AND lang_text.lang = subsloganT.lang AND (reseller_status = 'A' OR reseller_status = '') 
                            GROUP BY advertise_id LIMIT {$paging_limit}";



        $q = $db->query($Query);
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
        }
        // print_r($data); die("dssdada");
        return $data;
    }

    /////////////////////////////////////////

    function viewDeleteAdvertiseDetailById($advertiseid) {
        $db = new db();
        $db->makeConnection();
        $data = array();
        $error = '';


        $q = $db->query("SELECT advertise.*,sloganT.text as slogan,subsloganT.text as subslogen,keyw.text as keyword, advertise.infopage,lang_text.text as categoryName  FROM advertise
                        LEFT JOIN  advertise_offer_slogan_lang_list          ON  advertise_offer_slogan_lang_list.advertise_id = advertise.advertise_id
                        LEFT JOIN  advertise_keyword    ON  advertise_keyword.advertise_id = advertise.advertise_id
                        LEFT JOIN    advertise_offer_sub_slogan_lang_list    ON  advertise_offer_sub_slogan_lang_list.advertise_id = advertise.advertise_id
                        LEFT JOIN  lang_text as sloganT             ON  advertise_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
                        LEFT JOIN  lang_text as keyw             ON  advertise_keyword.offer_keyword  = keyw.id
                        LEFT JOIN    lang_text as subsloganT        ON  advertise_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = subsloganT.id
                        LEFT JOIN  category  ON category.category_id = advertise.category
                        LEFT JOIN  category_names_lang_list  ON category.category_id = category_names_lang_list.category
                        LEFT JOIN  lang_text  ON lang_text.id = category_names_lang_list.names_lang_list
                        WHERE  advertise.advertise_id='" . $advertiseid . "' AND lang_text.lang = subsloganT.lang");
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
            // print_r($data);
        }

        $QUE = "select store.* from store left join c_s_rel
        on(c_s_rel.store_id = store.store_id)
        where c_s_rel.advertise_id ='" . $advertiseid . "' AND activ='1'";
        $res = mysqli_query($QUE) or die(mysqli_error());
        while ($row = mysqli_fetch_array($res)) {
            $storeDetails[] = $row;
        }
        $data['storeDetails'] = $storeDetails;
        //print_r($data['storeDetails']);
        //echo $_SESSION['userid'];
        return $data;
        // print_r ($data); die("hg");
    }

    function editDeleteAdvertisePreview($advertiseid, $reseller = '') {
        $inoutObj = new inOut();

        $_SESSION['advertise_for_edit'] = serialize($_POST);

        if ($_FILES['picture']['name'] <> '') {
            
        }
        $_SESSION['preview']['advertiseId'] = $_POST['advertiseId'];
        $_SESSION['preview']['offer_slogan_lang_list'] = $_POST['titleSlogan'];
        $_SESSION['preview']['offer_sub_slogan_lang_list'] = $_POST['subSlogan'];
        $_SESSION['preview']['advertiseId'] = $advertiseid;
        $_SESSION['preview']['linkedCat'] = $_POST['linkedCat'];
        $_SESSION['preview']['startDateLimitation'] = $_POST['startDateLimitation'];
        $_SESSION['preview']['endDateLimitation'] = $_POST['endDateLimitation'];

        //// Upload Coupen image//////
        $coupenName = "cpn_" . md5(time());
        $info = pathinfo($_FILES["picture"]["name"]);
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

        extract(((unserialize($_SESSION['advertise_for_edit']))));
        // extract(((unserialize($_SESSION['advertise_for_edit_image']))));
        //echo "sasadas"; die();
        $inoutObj = new inOut();
        $db = new db();
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
        $arrUser['advertise_name'] = addslashes($advertiseName);
        $arrUser['keywords'] = addslashes($searchKeyword);
        $arrUser['infopage'] = $descriptive;
        $arrUser['lang'] = $_POST['lang'];

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

        $error.= ( $arrUser['offer_slogan_lang_list'] == '') ? ERROR_TITLE_SLOGAN : '';

        $error.= ( $arrUser['offer_sub_slogan_lang_list'] == '') ? ERROR_SUB_SLOGAN : '';

        $error.= ( $arrUser['spons'] == '') ? ERROR_ADVERTISE_SPONSORS : '';

        $error.= ( $arrUser['category'] == '') ? ERROR_CATEGORY : '';

        $error.= ( $arrUser['start_of_publishing'] == '') ? ERROR_ADVERTISE_START_OF_PUBLISHING : '';

        $error.= ( $arrUser['end_of_publishing'] == '') ? ERROR_ADVERTISE_END_OF_PUBLISHING : '';

        $error.= ( $arrUser['advertise_name'] == '') ? ERROR_ADVERTISE_NAME : '';

        $_SESSION['post'] = "";

        if ($reseller == '') {

            $query = "SELECT pre_loaded_value FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
            $res = mysqli_query($query) or die(mysqli_error());
            $rs_comp = mysqli_fetch_array($res);
            $rs_comp['pre_loaded_value'];
            if ($rs_comp['pre_loaded_value']) {
                //$_SESSION['userid'];
                $pre_loaded_value = $rs_comp['pre_loaded_value'];
            } else {
                $query = "SELECT pre_loaded_value FROM user as usr
          LEFT JOIN company as comp ON       (comp.company_id=usr.company_id)
         WHERE usr.u_id='" . $_SESSION['userid'] . "'";
                $res = mysqli_query($query) or die(mysqli_error());
                $rs_comp = mysqli_fetch_array($res);
                $pre_loaded_value = $rs_comp['pre_loaded_value'];
                //$rs['new_pre_loaded_value'];
            }

            if ($_POST['sponsor'] == 1) {
                if (($pre_loaded_value == '0' || $pre_loaded_value == null)) {
                    $_SESSION['MESSAGE2'] = CRADIT_YOUR_ACCOUNT;


                    $url = BASE_URL . 'editDeleteAdvertise.php?advertiseId=' . $advertiseid;
                    $inoutObj->reDirect($url);
                    exit();
                }
            }


            $query = "SELECT pre_loaded_value FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
            $res = mysqli_query($query) or die(mysqli_error());
            $rs = mysqli_fetch_array($res);
            $rs['pre_loaded_value'];
            //echo $_SESSION['userid'];
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

            if (!empty($category_image)) {

                $categoryImageName = explode(".", $category_image);
                $cat_filename = $CategoryIconName . "." . $categoryImageName[1];
                //move_uploaded_file($_FILES["icon"]["tmp_name"],UPLOAD_DIR."Category/" .$cat_filename);
                $fileOriginal = UPLOAD_DIR . "category_lib/" . $category_image;
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
                $url = BASE_URL . 'editDeleteAdvertise.php?advertiseId=' . $advertiseid;
                $inoutObj->reDirect($url);
                exit();
            } else {
                $url = BASE_URL . 'editDeleteAdvertise.php?advertiseId=' . $advertiseid . 'from=' . $reseller;
                $inoutObj->reDirect($url);
                exit();
            }
        }
        ///////////////////////////

        $advertiseId = uuid();
        /// Select company id of this user
        $QUE = "select company_id from company where u_id='" . $_SESSION['userid'] . "'";
        $res = mysqli_query($QUE) or die("Get Company : " . mysqli_error());
        $row = mysqli_fetch_array($res);
        $companyId = $row['company_id'];

        if ($companyId == '') {
            $QUE33 = "select company_id from employer where u_id='" . $_SESSION['userid'] . "'";
            $res33 = mysqli_query($QUE33) or die(mysqli_error());
            $rs33 = mysqli_fetch_array($res33);
            $empCompId = $rs33['company_id'];
            $companyId = $empCompId;
        }

        $catImg = IMAGE_AMAZON_PATH . 'category/' . $arrUser['small_image'];
        $copImg = IMAGE_AMAZON_PATH . 'coupon/' . $arrUser['large_image'];

        $arrUser['u_id'] = $_SESSION['userid'];
//  New View Option Kent  -->
        $query = "INSERT INTO advertise(`advertise_id`,`company_id`,`u_id`, `small_image`,`large_image`, `spons`, `category`, `start_of_publishing`,`end_of_publishing`,`advertise_name`,`view_opt`,`infopage`,`s_activ`)
                VALUES ('" . $advertiseId . "','" . $companyId . "','" . $_SESSION['userid'] . "', '" . $catImg . "', '" . $copImg . "','" . $arrUser['spons'] . "','" . $arrUser['category'] . "','" . $arrUser['start_of_publishing'] . "','" . $arrUser['end_of_publishing'] . "','" . $arrUser['advertise_name'] . "','" . $arrUser['viewopt'] . "','" . $arrUser['infopage'] . "','0');";
        $res = mysqli_query($query) or die("Inset advertise : " . mysqli_error());
        if ($reseller != '') {
            $query = "UPDATE advertise SET `reseller_status` = 'P' WHERE advertise_id = '" . $advertiseId . "'";
            $res = mysqli_query($query);
        }


        $sloganLangId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $sloganLangId . "','" . $arrUser['lang'] . "','" . $arrUser['offer_slogan_lang_list'] . "')";
        $res = mysqli_query($_SQL) or die("title slogan in lang_text : " . mysqli_error());

        $subSloganLangId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $subSloganLangId . "','" . $arrUser['lang'] . "','" . $arrUser['offer_sub_slogan_lang_list'] . "')";
        $res = mysqli_query($_SQL) or die("sub slogan in lang_text : " . mysqli_error());


        ////keyword
        $keywordId = uuid();
     //   if (trim($arrUser['keywords']) != "") 
        {
        $_SQL = "insert into lang_text(id,lang,text) values('" . $keywordId . "','" . $arrUser['lang'] . "','" . $arrUser['keywords'] . "')";
        $res = mysqli_query($_SQL) or die("title slogan in lang_text : " . mysqli_error());
        
         $_SQL = "insert into advertise_keyword(`advertise_id`,`offer_keyword`) values('" . $advertiseId . "','" . $keywordId . "')";
        $res = mysqli_query($_SQL) or die("Sub slogan id in relational table : " . mysqli_error());
         }

        $SystemkeyId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $SystemkeyId . "','" . $arrUser['lang'] . "','" . $advertiseId . "')";
        $res = mysqli_query($_SQL) or die(mysqli_error());

        $_SQL = "insert into advertise_keyword(`advertise_id`,system_key) values('" . $advertiseId . "','" . $SystemkeyId . "')";
        $res = mysqli_query($_SQL) or die(mysqli_error());


        $Systemkey_companyId = uuid();  // company ID as Key 
        $_SQL = "insert into lang_text(id,lang,text) values('" . $Systemkey_companyId . "','" . $arrUser['lang'] . "','" . $companyId . "')";
        $res = mysqli_query($_SQL) or die(mysqli_error());

        $_SQL = "insert into advertise_keyword(`advertise_id`,system_key) values('" . $advertiseId . "','" . $Systemkey_companyId . "')";
        $res = mysqli_query($_SQL) or die(mysqli_error());
        

        ///Slogan and language table relation entry ///
        $_SQL = "insert into advertise_offer_slogan_lang_list(`advertise_id`,`offer_slogan_lang_list`) values('" . $advertiseId . "','" . $sloganLangId . "')";
        $res = mysqli_query($_SQL) or die("Tital slogan id in relational table : " . mysqli_error());


        ///Sub slogan and language table relation entry ///
        $_SQL = "insert into advertise_offer_sub_slogan_lang_list(`advertise_id`,`offer_sub_slogan_lang_list`) values('" . $advertiseId . "','" . $subSloganLangId . "')";
        $res = mysqli_query($_SQL) or die("Sub slogan id in relational table : " . mysqli_error());

      


        $_SESSION['MESSAGE'] = ADVERTISE_OFFER_SUCCESS;
        if ($reseller == '') {
            $url = BASE_URL . 'showAdvertise.php';
            // $url = BASE_URL.'editAdvertisePreview.php?advertiseId='.$advertiseid;
            $inoutObj->reDirect($url);
            exit();
        } else {
            $url = BASE_URL . 'showResellerAdvertise.php';
            // $url = BASE_URL.'editAdvertisePreview.php?advertiseId='.$advertiseid;
            $inoutObj->reDirect($url);
            exit();
        }
    }

    function editDeleteAdvertise($advertiseid) {

        extract(((unserialize($_SESSION['advertise_for_edit']))));
        // extract(((unserialize($_SESSION['advertise_for_edit_image']))));
        //echo "sasadas"; die();
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $error = '';


        $arrUser['offer_slogan_lang_list'] = $titleSlogan;
        $arrUser['offer_sub_slogan_lang_list'] = $subSlogan;
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
        $arrUser['advertise_name'] = $advertiseName;
        $arrUser['keywords'] = $searchKeyword;
        $arrUser['infopage'] = $descriptive;
        $arrUser['lang'] = $_POST['lang'];

        $error.= ( $arrUser['offer_slogan_lang_list'] == '') ? ERROR_TITLE_SLOGAN : '';

        $error.= ( $arrUser['offer_sub_slogan_lang_list'] == '') ? ERROR_SUB_SLOGAN : '';

        $error.= ( $arrUser['spons'] == '') ? ERROR_ADVERTISE_SPONSORS : '';

        $error.= ( $arrUser['category'] == '') ? ERROR_CATEGORY : '';

        $error.= ( $arrUser['start_of_publishing'] == '') ? ERROR_ADVERTISE_START_OF_PUBLISHING : '';

        $error.= ( $arrUser['end_of_publishing'] == '') ? ERROR_ADVERTISE_END_OF_PUBLISHING : '';

        $error.= ( $arrUser['advertise_name'] == '') ? ERROR_ADVERTISE_NAME : '';

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
            $url = BASE_URL . 'editDeleteAdvertise.php?advertiseId=' . $advertiseid;
            $inoutObj->reDirect($url);
            exit();
        }
        $preview = 0;
        if ($preview == 1) {
            $_SESSION['preview'] = $arrUser;
            $_SESSION['post'] = $_POST;
            $url = BASE_URL . 'editDeleteAdvertisePreview.php?advertiseId=' . $advertiseid;
            $inoutObj->reDirect($url);
            exit();
        }
        ///////////////////////////

        $advertiseId = uuid();
        /// Select company id of this user
        $QUE = "select company_id from company where u_id='" . $_SESSION['userid'] . "'";
        $res = mysqli_query($QUE) or die("Get Company : " . mysqli_error());
        $row = mysqli_fetch_array($res);
        $companyId = $row['company_id'];

        $catImg = IMAGE_AMAZON_PATH . 'category/' . $arrUser['small_image'];
        $copImg = IMAGE_AMAZON_PATH . 'coupon/' . $arrUser['large_image'];

        $arrUser['u_id'] = $_SESSION['userid'];
//  New View Option Kent  -->
        $query = " INSERT INTO advertise(`advertise_id`,`company_id`,`u_id`, `small_image`,`large_image`, `spons`, `category`, `start_of_publishing`,`end_of_publishing`,`advertise_name`,`view_opt`,`keywords`,`infopage`,`s_activ`)
                VALUES ('" . $advertiseId . "','" . $companyId . "','" . $_SESSION['userid'] . "', '" . $catImg . "', '" . $copImg . "','" . $arrUser['spons'] . "','" . $arrUser['category'] . "','" . $arrUser['start_of_publishing'] . "','" . $arrUser['end_of_publishing'] . "','" . $arrUser['advertise_name'] . "','" . $arrUser['viewopt'] . "','" . $arrUser['keywords'] . "','" . $arrUser['infopage'] . "','0');";
        $res = mysqli_query($query) or die("Inset advertise : " . mysqli_error());

          ////keyword
        $keywordId = uuid();
         //   if (trim($arrUser['keywords']) != "") 
        {
            $_SQL = "insert into lang_text(id,lang,text) values('" . $keywordId . "','" . $arrUser['lang'] . "','" . $arrUser['keywords'] . "')";
            $res = mysqli_query($_SQL) or die("Keyword in lang_text : " . mysqli_error());
        
            $_SQL = "insert into advertise_keyword(`advertise_id`,`offer_keyword`) values('" . $advertiseId . "','" . $keywordId . "')";
            $res = mysqli_query($_SQL) or die("Keyword in relational table : " . mysqli_error());
        }
        
        
        $SystemkeyId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $SystemkeyId . "','" . $arrUser['lang'] . "','" . $advertiseId . "')";
        $res = mysqli_query($_SQL) or die(mysqli_error());

        $_SQL = "insert into advertise_keyword(`advertise_id`,system_key) values('" . $advertiseId . "','" . $SystemkeyId . "')";
        $res = mysqli_query($_SQL) or die(mysqli_error());

        
          
        $Systemkey_companyId = uuid();  // company ID as Key 
        $_SQL = "insert into lang_text(id,lang,text) values('" . $Systemkey_companyId . "','" . $arrUser['lang'] . "','" . $companyId . "')";
        $res = mysqli_query($_SQL) or die(mysqli_error());

        $_SQL = "insert into advertise_keyword(`advertise_id`,system_key) values('" . $advertiseId . "','" . $Systemkey_companyId . "')";
        $res = mysqli_query($_SQL) or die(mysqli_error());
        
        
        
        
        
        
        ////////Slogan entry///////
        $sloganLangId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $sloganLangId . "','" . $arrUser['lang'] . "','" . $arrUser['offer_slogan_lang_list'] . "')";
        $res = mysqli_query($_SQL) or die("title slogan in lang_text : " . mysqli_error());

        ////////Sub Slogen entry///////
        $subSloganLangId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $subSloganLangId . "','" . $arrUser['lang'] . "','" . $arrUser['offer_sub_slogan_lang_list'] . "')";
        $res = mysqli_query($_SQL) or die("sub slogan in lang_text : " . mysqli_error());

        ///Slogan and language table relation entry ///
        $_SQL = "insert into advertise_offer_slogan_lang_list(`advertise_id`,`offer_slogan_lang_list`) values('" . $advertiseId . "','" . $sloganLangId . "')";
        $res = mysqli_query($_SQL) or die("Tital slogan id in relational table : " . mysqli_error());


        ///Sub slogan and language table relation entry ///
        $_SQL = "insert into advertise_offer_sub_slogan_lang_list(`advertise_id`,`offer_sub_slogan_lang_list`) values('" . $advertiseId . "','" . $subSloganLangId . "')";
        $res = mysqli_query($_SQL) or die("Sub slogan id in relational table : " . mysqli_error());


        $_SESSION['MESSAGE'] = ADVERTISE_OFFER_SUCCESS;
        $url = BASE_URL . 'showAdvertise.php';
        // $url = BASE_URL.'editAdvertisePreview.php?advertiseId='.$advertiseid;
        $inoutObj->reDirect($url);
        exit();
    }

    function showadvtoffer($paging_limit = '0 , 10') {
        $db = new db();
        $db->makeConnection();
        $data = array();

        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['ke'])) {
            // $qstr1 = " store_name REGEXP '[[:<:]]".trim($_REQUEST['keyword'])."[[:>:]]' ";
            // $qstr2 = " email REGEXP '[[:<:]]".trim($_REQUEST['key'])."[[:>:]]' ";
            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'advertise.keywords LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
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


        $QUE = "SELECT advertise.*,sloganT.text as slogan,subsloganT.text as subslogen,keyw.text as keyword, advertise.infopage,lang_text.text as category  FROM advertise
                        LEFT JOIN   advertise_offer_slogan_lang_list ON  advertise_offer_slogan_lang_list.advertise_id = advertise.advertise_id
                        LEFT JOIN   advertise_offer_sub_slogan_lang_list  ON  advertise_offer_sub_slogan_lang_list.advertise_id = advertise.advertise_id
                        LEFT JOIN   advertise_keyword  ON  advertise_keyword.advertise_id = advertise.advertise_id
                        LEFT JOIN   lang_text as sloganT ON  advertise_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
                        LEFT JOIN   lang_text as subsloganT ON advertise_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = subsloganT.id
                        LEFT JOIN   lang_text as keyw ON advertise_keyword.offer_keyword = keyw.id
                        LEFT JOIN  category  ON category.category_id = advertise.category
                        LEFT JOIN  category_names_lang_list  ON category.category_id = category_names_lang_list.category
                        LEFT JOIN  lang_text   ON lang_text.id = category_names_lang_list.names_lang_list
                        WHERE
                        advertise.u_id='" . $_SESSION['userid'] . "' AND $set_keywords  end_of_publishing < CURDATE() AND s_activ!='2' AND lang_text.lang = subsloganT.lang GROUP BY advertise_id " . $limit;


        $res = mysqli_query($QUE);
        while ($rs = mysqli_fetch_array($res)) {

            $data[] = $rs;
            //echo "<pre>"; print_r($rs); echo "</pre>";
        }
        return $data;
    }

    function deleteOutdatedAdvertise() {
        $advertiseid = $_REQUEST['advertiseId'];
        $db = new db();
        $db->makeConnection();
        //   $subslogan_id = $this->get_slogan($advertiseid, 'subslogan');
        //   $slogan_id = $this->get_slogan($advertiseid);

        /*    $query = "select * from advertise  where u_id = '" . $_SESSION['userid'] . "'";
          $res = mysqli_query($query) or die(mysqli_error());
          $rs = mysqli_fetch_array($res);
          $advertiseId = $rs['advertise_id'];
         */
        $query = "UPDATE `advertise` SET  `s_activ` = '2' WHERE `advertise`.`advertise_id` = '" . $advertiseid . "'";
        $res = mysqli_query($query) or die(mysqli_error());

        $inoutObj = new inOut();
        $url = BASE_URL . 'showAdvertise.php?m=showadvtoffer';
        $inoutObj->reDirect($url);
        exit();
    }

    function deleteViewAdvertiseStore() {

        $storeId = $_REQUEST['storeId'];
        $advertiseId = $_REQUEST['advertiseId'];

        $db = new db();
        $inoutObj = new inOut();
        $db->makeConnection();

        $query = "select * from c_s_rel  where store_id = '" . $storeId . "' AND advertise_id = '" . $advertiseId . "'"; //die();
        $res1 = mysqli_query($query) or die(mysqli_error());
        $rs = mysqli_fetch_array($res1);
        $couponId = $rs['coupon_id'];

        if ($couponId) {
            $query = "select * from coupon_offer_slogan_lang_list  where coupon = '" . $couponId . "'";
            $res = mysqli_query($query) or die('1' . mysqli_error());
            $rs = mysqli_fetch_array($res);
            $offslogen = $rs['offer_slogan_lang_list'];

            $_SQL = "DELETE FROM coupon_offer_slogan_lang_list WHERE coupon = '" . $couponId . "'";
            $res = mysqli_query($_SQL) or die(mysqli_error());


            $query = "select * from coupon_offer_title_lang_list  where coupon = '" . $couponId . "'";
            $res = mysqli_query($query) or die('1' . mysqli_error());
            $rs = mysqli_fetch_array($res);
            $offtitle = $rs['offer_title_lang_list'];

            $_SQL = "DELETE FROM coupon_offer_title_lang_list WHERE coupon = '" . $couponId . "'";
            $res = mysqli_query($_SQL) or die(mysqli_error());
        }

        $_SQL = "UPDATE c_s_rel SET activ='2' WHERE store_id = '" . $storeId . "' AND advertise_id='" . $advertiseId . "'";
        $res = mysqli_query($_SQL) or die(mysqli_error());

        $url = BASE_URL . 'showAdvertise.php';
        $inoutObj->reDirect($url);
        exit();
    }

    function addSaveAdvertiseLang($advertiseid, $reseller = '') {
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $error = '';

        $arrUser['titleSlogan'] = addslashes($_POST['titleSlogan']);
        $arrUser['subSlogan'] = addslashes($_POST['subSlogan']);
        $arrUser['lang'] = $_POST['lang'];
        $arrUser['searchKeyword'] = addslashes($_POST['searchKeyword']);


       $query = "SELECT * FROM advertise
        LEFT JOIN advertise_offer_slogan_lang_list ON advertise.advertise_id = advertise_offer_slogan_lang_list.advertise_id
        LEFT JOIN lang_text ON advertise_offer_slogan_lang_list.offer_slogan_lang_list = lang_text.id
        where advertise.advertise_id = '" . $advertiseid . "' AND lang_text.lang = '" . $arrUser['lang'] . "'"; //die();
        $res = mysqli_query($query) or die('1' . mysqli_error());
        $row = mysqli_fetch_array($res);
        $text = $row['text'];
        $companyId = $row['company_id'];
        //  echo "<pre>"; print_r($row); echo "</pre>" ; die( $query);

        if ($text) {
            $_SESSION[MESSAGE] = ALREADY_LANG;
            if ($reseller == '') {
                $url = BASE_URL . 'showAdvertise.php';
                $inoutObj->reDirect($url);
                exit();
            } else {
                $url = BASE_URL . 'showResellerAdvertise.php';
                $inoutObj->reDirect($url);
                exit();
            }
        }
       

        $slogenId = uuid();
        $query = "INSERT INTO advertise_offer_slogan_lang_list(`advertise_id`,`offer_slogan_lang_list`)
                VALUES ('" . $advertiseid . "','" . $slogenId . "');";
        $res = mysqli_query($query) or die("Inset advertise : " . mysqli_error());

        $subslogenId = uuid();
        $query = "INSERT INTO advertise_offer_sub_slogan_lang_list(`advertise_id`,`offer_sub_slogan_lang_list`)
                VALUES ('" . $advertiseid . "','" . $subslogenId . "');";
        $res = mysqli_query($query) or die("Inset advertise : " . mysqli_error());

    //    if ($arrUser['searchKeyword'] != "") 
       {
        
         $keyId = uuid();
        $query = "INSERT INTO advertise_keyword(`advertise_id`,`offer_keyword`)
                VALUES ('" . $advertiseid . "','" . $keyId . "');";
        $res = mysqli_query($query) or die("Inset advertise : " . mysqli_error());

        $query = "INSERT INTO lang_text(`id`,`lang`,`text`)
                VALUES ('" . $keyId . "','" . $arrUser['lang'] . "','" . $arrUser['searchKeyword'] . "');";
        $res = mysqli_query($query) or die("Inset advertise : " . mysqli_error());
        }


        $SystemkeyId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $SystemkeyId . "','" . $arrUser['lang'] . "','" . $advertiseid . "')";
        $res = mysqli_query($_SQL) or die(mysqli_error());

        $_SQL = "insert into advertise_keyword(`advertise_id`,system_key) values('" . $advertiseid . "','" . $SystemkeyId . "')";
        $res = mysqli_query($_SQL) or die(mysqli_error());
        
        
          
        $Systemkey_companyId = uuid();  // company ID as Key 
        $_SQL = "insert into lang_text(id,lang,text) values('" . $Systemkey_companyId . "','" . $arrUser['lang'] . "','" . $companyId . "')";
        $res = mysqli_query($_SQL) or die(mysqli_error());
        
        $_SQL = "insert into advertise_keyword(`advertise_id`,system_key) values('" . $advertiseid . "','" . $Systemkey_companyId . "')";
        $res = mysqli_query($_SQL) or die(mysqli_error());
        


        $query = "INSERT INTO lang_text(`id`,`lang`,`text`)
                VALUES ('" . $slogenId . "','" . $arrUser['lang'] . "','" . $arrUser['titleSlogan'] . "');";
        $res = mysqli_query($query) or die("Inset advertise : " . mysqli_error());

        $query = "INSERT INTO lang_text(`id`,`lang`,`text`)
                VALUES ('" . $subslogenId . "','" . $arrUser['lang'] . "','" . $arrUser['subSlogan'] . "');";
        $res = mysqli_query($query) or die("Inset advertise : " . mysqli_error());

        
        $_SESSION[MESSAGE] = ADD_LANG;
        if ($reseller == '') {
            $url = BASE_URL . 'showAdvertise.php';
            $inoutObj->reDirect($url);
            exit();
        } else {
            $url = BASE_URL . 'showResellerAdvertise.php';
            $inoutObj->reDirect($url);
            exit();
        }
    }

    function viewPublicAdvertiseDetailById($advertiseid, $lang = 'ENG') {
//echo "here";echo $advertiseid;die;
        $db = new db();
        $db->makeConnection();
        $data = array();
        $error = '';

        $q = $db->query("SELECT advertise.*,sloganT.text as slogan,subsloganT.text as subslogen,keyw.text as keyword, advertise.infopage,limit_period.*,lang_text.text as categoryName  FROM advertise
                        LEFT JOIN  advertise_offer_slogan_lang_list   ON  advertise_offer_slogan_lang_list.advertise_id = advertise.advertise_id
                        LEFT JOIN  advertise_keyword    ON  advertise_keyword.advertise_id = advertise.advertise_id
                        LEFT JOIN    advertise_offer_sub_slogan_lang_list    ON  advertise_offer_sub_slogan_lang_list.advertise_id = advertise.advertise_id
                        LEFT JOIN  lang_text as sloganT             ON  advertise_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
                        LEFT JOIN    lang_text as subsloganT        ON  advertise_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = subsloganT.id
                        LEFT JOIN  lang_text as keyw             ON  advertise_keyword.offer_keyword  = keyw.id
                        LEFT JOIN  category  ON category.category_id = advertise.category
                        LEFT JOIN  category_names_lang_list  ON category.category_id = category_names_lang_list.category
                        LEFT JOIN  lang_text  ON lang_text.id = category_names_lang_list.names_lang_list

                        WHERE  advertise.advertise_id='" . $advertiseid . "' AND lang_text.lang = '" . $lang . "' AND lang_text.lang = subsloganT.lang AND
                         lang_text.lang = sloganT.lang AND lang_text.lang = keyw.lang  GROUP BY advertise.advertise_id");
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
            // print_r($data);
        }

        $QUE = "select store.* from store left join c_s_rel
        on(c_s_rel.store_id = store.store_id)
        where c_s_rel.advertise_id ='" . $advertiseid . "' AND activ='1' AND u_id ='" . $_SESSION['userid'] . "'";
        $res = mysqli_query($QUE) or die(mysqli_error());
        while ($row = mysqli_fetch_array($res)) {
            $storeDetails[] = $row;
        }
        $data['storeDetails'] = $storeDetails; 
        return $data;
    }

    function showDeleteResellerAdvertise($paging_limit = '0 , 10') {

        //echo kjasd;die();
        $db = new db();
        $db->makeConnection();
        $is_Public = array();
        $error = '';
        $inoutObj = new inOut();
        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['ke'])) {
            // $qstr1 = " store_name REGEXP '[[:<:]]".trim($_REQUEST['keyword'])."[[:>:]]' ";
            // $qstr2 = " email REGEXP '[[:<:]]".trim($_REQUEST['key'])."[[:>:]]' ";
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
        $Query = "SELECT advertise.*,sloganT.text as slogan,subsloganT.text as subslogen,keyw.text as keyword, advertise.infopage,lang_text.text as category FROM advertise
                        LEFT JOIN   advertise_offer_slogan_lang_list ON  advertise_offer_slogan_lang_list.advertise_id = advertise.advertise_id
                        LEFT JOIN   advertise_offer_sub_slogan_lang_list  ON  advertise_offer_sub_slogan_lang_list.advertise_id = advertise.advertise_id
                         LEFT JOIN   advertise_keyword  ON  advertise_keyword.advertise_id = advertise.advertise_id
                        LEFT JOIN   lang_text as sloganT ON  advertise_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
                        LEFT JOIN   lang_text as subsloganT ON advertise_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = subsloganT.id
                        LEFT JOIN   lang_text as keyw ON advertise_keyword.offer_keyword = keyw.id
                        LEFT JOIN  category  ON (category.category_id = advertise.category)
                        LEFT JOIN  category_names_lang_list  ON (category.category_id = category_names_lang_list.category)
                        LEFT JOIN  lang_text  ON lang_text.id = category_names_lang_list.names_lang_list
                        WHERE advertise.u_id = '" . $_SESSION['userid'] . "' AND $set_keywords s_activ='2' AND lang_text.lang = subsloganT.lang GROUP BY advertise_id LIMIT {$paging_limit}";
        $q = $db->query($Query);
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
        }
        // print_r($data); die("dssdada");
        return $data;
    }

    function showDeleteAdvertiseDetailsResellerRows() {
        $db = new db();
        $db->makeConnection();
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

        $Query = "SELECT advertise.*,sloganT.text as slogan,subsloganT.text as subslogen,keyw.text as keyword, advertise.infopage,lang_text.text as category FROM advertise
                        LEFT JOIN   advertise_offer_slogan_lang_list ON  advertise_offer_slogan_lang_list.advertise_id = advertise.advertise_id
                        LEFT JOIN   advertise_offer_sub_slogan_lang_list  ON  advertise_offer_sub_slogan_lang_list.advertise_id = advertise.advertise_id
                        LEFT JOIN   advertise_keyword  ON  advertise_keyword.advertise_id = advertise.advertise_id
                        LEFT JOIN   lang_text as sloganT ON  advertise_offer_slogan_lang_list.offer_slogan_lang_list = sloganT.id
                        LEFT JOIN   lang_text as subsloganT ON advertise_offer_sub_slogan_lang_list.offer_sub_slogan_lang_list = subsloganT.id
                        LEFT JOIN   lang_text as keyw ON advertise_keyword.offer_keyword = keyw.id
                        LEFT JOIN  category  ON (category.category_id = advertise.category)
                        LEFT JOIN  category_names_lang_list  ON (category.category_id = category_names_lang_list.category)
                        LEFT JOIN  lang_text  ON lang_text.id = category_names_lang_list.names_lang_list
                        WHERE advertise.u_id = '" . $_SESSION['userid'] . "' AND $set_keywords s_activ='2' AND lang_text.lang = subsloganT.lang GROUP BY advertise_id ";
        $res = mysqli_query($Query) or die(mysqli_error());
        $total_records = $db->numRows($res);

        return $total_records;
    }

    function saveAdvertiseOffersDetails($reseller = '') {

        //print_r($_POST); die();
        $inoutObj = new inOut();
        //$_SESSION['advertise_for_edit'] = serialize($_POST);
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
        $arrUser['advertise_name'] = addslashes($_POST['advertiseName']);
        $arrUser['keywords'] = addslashes($_POST['searchKeyword']);
        $arrUser['large_image'] = $_POST['picture'];
        $arrUser['infopage'] = $_POST['descriptive'];
 
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
        $error.= ( $arrUser['spons'] == '') ? ERROR_ADVERTISE_SPONSORS : '';
        $error.= ( $arrUser['category'] == '') ? ERROR_CATEGORY : '';
        $error.= ( $arrUser['start_of_publishing'] == '') ? ERROR_ADVERTISE_START_OF_PUBLISHING : ''; //ERROR_ADVERTISE_START_OF_PUBLISHING
        $error.= ( $arrUser['end_of_publishing'] == '') ? ERROR_ADVERTISE_END_OF_PUBLISHING : ''; //  ERROR_ADVERTISE_END_OF_PUBLISHING
        $error.= ( $arrUser['advertise_name'] == '') ? ERROR_ADVERTISE_NAME : '';

        $_SESSION['post'] = "";
        // Print_r($_POST); die();
        // Upload category icon file////

        $CategoryIconName = "cat_icon_" . md5(time());
        $info = pathinfo($_FILES["icon"]["name"]);
        //echo $info;

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

        //echo "End UPLOAD"; die();
        //// Upload Coupen image//////
        $coupenName = "cpn_" . md5(time());
        $info = pathinfo($_FILES["picture"]["name"]);

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
                $url = BASE_URL . 'advertiseOffer.php';
                $inoutObj->reDirect($url);
                exit();
            } else {
                $url = BASE_URL . 'advertiseResellerOffer.php';
                $inoutObj->reDirect($url);
                exit();
            }
        }

        $catImg = IMAGE_AMAZON_PATH . 'category/' . $arrUser['small_image'];
        $copImg = IMAGE_AMAZON_PATH . 'coupon/' . $arrUser['large_image'];
        $advertiseId = uuid();
        /// Select company id of this user
        $QUE = "select company_id from company where u_id='" . $_SESSION['userid'] . "'";
        $res = mysqli_query($QUE) or die("Get Company : " . mysqli_error());
        $row = mysqli_fetch_array($res);
        $companyId = $row['company_id'];

        $catImg = _UPLOAD_URLDIR_ . "category/" . $arrUser['small_image'];
        $cpnImg = _UPLOAD_URLDIR_ . "coupon/" . $arrUser['large_image'];

        $arrUser['u_id'] = $_SESSION['userid'];
//  New View Option Kent  -->
        $query = "INSERT INTO advertise(`advertise_id`,`company_id`,`u_id`, `small_image`,`large_image`, `spons`, `category`, `start_of_publishing`,`end_of_publishing`,`advertise_name`,`view_opt`, `infopage`)
                VALUES ('" . $advertiseId . "','" . $companyId . "','" . $_SESSION['userid'] . "', '" . $catImg . "', '" . $copImg . "','" . $arrUser['spons'] . "','" . $arrUser['category'] . "','" . $arrUser['start_of_publishing'] . "','" . $arrUser['end_of_publishing'] . "','" . $arrUser['advertise_name'] . "','" . $arrUser['viewopt'] . "','" . $arrUser['infopage'] . "');";
        $res = mysqli_query($query) or die("Inset advertise : " . mysqli_error());
       

        if ($reseller != '') {
            $query = "UPDATE advertise SET `reseller_status` = 'P' WHERE advertise_id = '" . $advertiseId . "'";
            $res = mysqli_query($query);
        }

        ////////Slogan entry///////
        $sloganLangId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $sloganLangId . "','" . $arrUser['lang'] . "','" . $arrUser['offer_slogan_lang_list'] . "')";
        $res = mysqli_query($_SQL) or die("title slogan in lang_text : " . mysqli_error());

        ////////Sub Slogen entry///////
        $subSloganLangId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $subSloganLangId . "','" . $arrUser['lang'] . "','" . $arrUser['offer_sub_slogan_lang_list'] . "')";
        $res = mysqli_query($_SQL) or die("sub slogan in lang_text : " . mysqli_error());

        ////////Sub Slogen entry///////
        $keywordId = uuid();
     //   if (trim($arrUser['keywords']) != "")         
        {
        $_SQL = "insert into lang_text(id,lang,text) values('" . $keywordId . "','" . $arrUser['lang'] . "','" . $arrUser['keywords'] . "')";
        $res = mysqli_query($_SQL) or die("sub slogan in lang_text : " . mysqli_error());
        
         $_SQL = "insert into advertise_keyword(`advertise_id`,`offer_keyword`) values('" . $advertiseId . "','" . $keywordId . "')";
        $res = mysqli_query($_SQL) or die("keyword in relational table : " . mysqli_error());
         }



        $SystemkeyId = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $SystemkeyId . "','" . $arrUser['lang'] . "','" . $advertiseId . "')";
        $res = mysqli_query($_SQL) or die(mysqli_error());

        $_SQL = "insert into advertise_keyword(`advertise_id`,system_key) values('" . $advertiseId . "','" . $SystemkeyId . "')";
        $res = mysqli_query($_SQL) or die(mysqli_error());


          
        $Systemkey_companyId = uuid();  // company ID as Key 
        $_SQL = "insert into lang_text(id,lang,text) values('" . $Systemkey_companyId . "','" . $arrUser['lang'] . "','" . $companyId . "')";
        $res = mysqli_query($_SQL) or die(mysqli_error());

        $_SQL = "insert into advertise_keyword(`advertise_id`,system_key) values('" . $advertiseId . "','" . $Systemkey_companyId . "')";
        $res = mysqli_query($_SQL) or die(mysqli_error());
        
        

        ///Slogan and language table relation entry ///
        $_SQL = "insert into advertise_offer_slogan_lang_list(`advertise_id`,`offer_slogan_lang_list`) values('" . $advertiseId . "','" . $sloganLangId . "')";
        $res = mysqli_query($_SQL) or die("Tital slogan id in relational table : " . mysqli_error());


        ///Sub slogan and language table relation entry ///
        $_SQL = "insert into advertise_offer_sub_slogan_lang_list(`advertise_id`,`offer_sub_slogan_lang_list`) values('" . $advertiseId . "','" . $subSloganLangId . "')";
        $res = mysqli_query($_SQL) or die("Sub slogan id in relational table : " . mysqli_error());

       

        $query = "UPDATE user SET activ='3' WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res = mysqli_query($query) or die("Update user for status : " . mysqli_error());


        $_SESSION['preview'] = "";
        $_POST = "";
        $_SESSION['MESSAGE'] = ADVERTISE_OFFER_SUCCESS;
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

    function rejectAdvertiseReseller($advertiseid, $uId, $ccode) {
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $error = '';

        $query = "SELECT * FROM company WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res = mysqli_query($query);
        $rs = mysqli_fetch_array($res);
        $resellerId = $rs['seller_id'];
        $companyId = $rs['company_id'];
        $codeCheck = $rs['ccode'];

        //// select company id using reseller id
        $query1 = "SELECT company_id FROM employer WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res1 = mysqli_query($query1);
        $rs1 = mysqli_fetch_array($res1);
        $emplyCompanyId = $rs1['company_id'];


        $query2 = "SELECT seller_id FROM company WHERE company_id = '" . $emplyCompanyId . "'";
        $res2 = mysqli_query($query2);
        $rs2 = mysqli_fetch_array($res2);
        $emplyResellerId = $rs2['seller_id'];

        if (($resellerId == '') && ($emplyResellerId == '')) {
            $message = RESELLER_REPLY;
            $url = BASE_URL . "viewResellerAdvertise.php?advertiseId=" . $advertiseid . '&alt=' . alt;
            $inoutObj->reDirect($url);
            exit;
        } else if (($uId == $resellerId) || ($uId == $emplyResellerId)) {
            if ($codeCheck == '') {

                $query = "SELECT * FROM ccode WHERE ccode = '" . $ccode . "'";
                $res = mysqli_query($query) or die(mysqli_error());
                $rs = mysqli_fetch_array($res);
                $ccValue = $rs['value'];

                // $date = date('Y-m-d H:i:s');
                $query = "UPDATE company SET  `ccode` = '" . $ccode . "', `cc_value` = '" . $ccValue . "'  WHERE u_id = '" . $_SESSION['userid'] . "'";
                $res = mysqli_query($query) or die(mysqli_error());
            }

            $query = "UPDATE advertise SET `reseller_status` = 'R'  WHERE advertise_id = '" . $advertiseid . "' ";
            $res = mysqli_query($query);

            $url = BASE_URL . 'showAdvertise.php';
            $inoutObj->reDirect($url);
            exit;
        } else if (($uId != $resellerId) || ($uId != $emplyResellerId)) {
            $message = RESELLER_REPLY;
            $url = BASE_URL . "viewResellerAdvertise.php?advertiseId=" . $advertiseid . '&alt=' . alt;
            $inoutObj->reDirect($url);
            exit;
        }
    }

    function acceptAdvertiseReseller($advertiseid, $uId, $ccode) {
        $inoutObj = new inOut();
        $db = new db();
        $arrUser = array();
        $error = '';

        ////check reseller_id null or not
        $query = "SELECT * FROM company WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res = mysqli_query($query);
        $rs = mysqli_fetch_array($res);
        $resellerId = $rs['seller_id'];
        $companyId = $rs['company_id'];
        $codeCheck = $rs['ccode'];


        //// select company id using reseller id
        $query1 = "SELECT company_id FROM employer WHERE u_id = '" . $_SESSION['userid'] . "'";
        $res1 = mysqli_query($query1);
        $rs1 = mysqli_fetch_array($res1);
        $emplyCompanyId = $rs1['company_id'];


        $query2 = "SELECT seller_id FROM company WHERE company_id = '" . $emplyCompanyId . "'";
        $res2 = mysqli_query($query2);
        $rs2 = mysqli_fetch_array($res2);
        $emplyResellerId = $rs2['seller_id'];

        if (($resellerId == '') && ($emplyResellerId == '')) {
            $message = RESELLER_REPLY;
            $url = BASE_URL . "viewResellerAdvertise.php?advertiseId=" . $advertiseid . '&alt=' . alt;
            $inoutObj->reDirect($url);
            exit;
        } else if (($uId == $resellerId) || ($uId == $emplyResellerId)) {

            //get ccvalue according ccode
            $query = "SELECT * FROM ccode WHERE ccode = '" . $ccode . "'";
            $res = mysqli_query($query) or die(mysqli_error());
            $rs = mysqli_fetch_array($res);
            $ccValue = $rs['value'];


            //////////////////check ccode which is exist in company table or not//////////
            if ($codeCheck == '') {

                //$date = date('Y-m-d H:i:s');
                $query = "UPDATE company SET `ccode` = '" . $ccode . "', `cc_value` = '" . $ccValue . "'  WHERE u_id = '" . $_SESSION['userid'] . "'";
                $res = mysqli_query($query) or die(mysqli_error());
            }

            //////////////////if ccode already exist in table//////////

            if ($companyId == '') {
                $companyId = $emplyCompanyId;
            }
            $query = "UPDATE advertise SET `reseller_status` = 'A' , `company_id` = '" . $companyId . "'  WHERE advertise_id = '" . $advertiseid . "' ";
            $res = mysqli_query($query);

            $url = BASE_URL . 'showAdvertise.php';
            $inoutObj->reDirect($url);
            exit;
        } else if (($uId != $resellerId) || ($uId != $emplyResellerId)) {
            $message = RESELLER_REPLY;
            $url = BASE_URL . "viewResellerAdvertise.php?advertiseId=" . $advertiseid . '&alt=' . alt;
            $inoutObj->reDirect($url);
            exit;
        }
    }

}

?>
