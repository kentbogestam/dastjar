<?php

/*  File Name : brandView.php
 *  Description : Brand View class and functions.
 * Author  :Himanshu Singh  Date: 10th,December,2010  Creation
*/
//$_SESSION['COMP_ID']="";
include('lib/resizer/resizer.php');

class brandView {
    /* Function Header :svrBrandDflt()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: User Brand Details default function
    */

    function svrBrandDflt() {

        if (isset($_REQUEST['m']) && $_REQUEST['m'] != '') {
            $mode = $_REQUEST['m'];
        } else {
            $mode = '';
        }

        switch ($mode) {

            case 'submitBrand':
                return $this->submitBrandDetails();
                break;

            case 'getBrandView':
                return $this->getBrandViewDetails();
                break;

            case 'registerBrands':
                return $this->registerBrandDetails();
                break;

            case 'editBrandIcon':
                return $this->editBrandIconDetails();
                break;
            case 'deleteBrand':
            //echo "here"; die();
                $this->deleteBrandById();
                break;
            
        }
    }

    /* Function Header : getBrandViewDetails()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: Get  Brand View Details related to respective Company.
    */

    function getBrandViewDetails() {
        $db = new db();
        $db->makeConnection();
        $data = array();
        $error = '';

        $query = "SELECT company_id FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
        $res = mysql_query($query) or die(mysql_error());
        $row = mysql_fetch_array($res);
        $data1 = $row['company_id'];
        //print_r($data1);

        $query = "SELECT id,brand_name, icon FROM brands where active='1' AND brands.company_id='$data1' ";
        $res = mysql_query($query) or die(mysql_error());
        while ($rs = mysql_fetch_array($res)) {
            $datas[] = $rs;
        }
        return $datas;
    }
    function getBrandViewDetailsByRows($brandid) {
        $db = new db();
        $db->makeConnection();
        $data = array();
        $error = '';

//        $query = "SELECT company_id FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
//        $res = mysql_query($query) or die(mysql_error());
//        $row = mysql_fetch_array($res);
//        $data1 = $row['company_id'];
//        //print_r($data1);

        $query = "SELECT id,brand_name, icon FROM brands where active='1' AND brands.id='$brandid' ";
        $res = mysql_query($query) or die(mysql_error());
        while ($rs = mysql_fetch_array($res)) {
            $datas[] = $rs;
        }
        return $datas;
    }

    function registerBrandDetails() {

        $db = new db();
        $db->makeConnection();
        $data = array();
        $error = '';

        $query = "SELECT company_name FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
        $res = mysql_query($query) or die(mysql_error());
        $row = mysql_fetch_array($res);
        $data1 = $row['company_name'];

        $query = "SELECT country FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
        $res = mysql_query($query) or die(mysql_error());
        $row = mysql_fetch_array($res);
        $data3 = $row['country'];

        $query = "SELECT name FROM country WHERE iso='" . $data3 . "'";
        $res = mysql_query($query) or die(mysql_error());
        $row = mysql_fetch_array($res);
        $data3 = $row['name'];


        $query = "SELECT brand_fee FROM cost WHERE country='" . $data3 . "'";
        $res = mysql_query($query) or die(mysql_error());
        $row = mysql_fetch_array($res);
        $data2 = $row['brand_fee'];
        $data['company_name'] = $data1;
        $data['brand_fee'] = $data2;
//exit;
        return $data;
    }

    function submitBrandDetails() {
//echo "Inhere";exit;
        $db = new db();
        $inoutObj = new inOut();
        $db->makeConnection();
        $data = array();
        $error = '';

        $arrUser['brand_name'] = $_POST['brandName'];
        $arrUser['icon'] = $_POST['picture'];
        $arrUser['amount'] = $_POST['amount'];

        $coupenName = "cpn_" . md5(time());
        $info = pathinfo($_FILES["picture"]["name"]);
//echo "here";exit;
        if (!empty($_FILES["picture"]["name"])) {

            if (strtolower($info['extension']) == "png") {
                if ($_FILES["picture"]["error"] > 0) {
                    $error.=$_FILES["picture"]["error"] . "<br />";
                } else {
                    $coupon_filename = $coupenName . "." . strtolower($info['extension']);
                    $fileOriginal = $_FILES['picture']['tmp_name'];
                    $crop = '5';
                    $size = 'brand';
                    $path = UPLOAD_DIR . "brands/";
                    $fileThumbnail = $path . $coupon_filename;
                    createFileThumbnail($fileOriginal, $fileThumbnail, $size, $frontUpload = 0, $crop, $errorMsg);
//echo "Done"; die();
                    $arrUser['icon'] = $coupon_filename;
                }
            } else {
                $error.=NOT_VALID_EXT;
            }
        } else {
            if ($_SESSION['preview']['icon'] != "") {
                $arrUser['icon'] = $_SESSION['preview']['icon'];
            } elseif ($_POST['icon'] == "") {
                $error.=ERROR_LARGE_STANDARD_IMAGE;
            } else {
                if ($_SESSION['preview']['icon'] != "") {
                    $arrUser['icon'] = $_SESSION['preview']['icon'];
                } elseif ($_POST['icon'] == "") {
                    $error.= ERROR_SMALL_IMAGE;
                } else {
                    $arrUser['icon'] = $_POST['icon'];
                }
            }
        }

/////////////////////////// upload smallimages into server///////////////////
        $file1 = _UPLOAD_IMAGE_ . 'brands/' . $arrUser['icon'];
        $dir1="brands";
        $command = IMAGE_DIR_PATH . $file1 ." ". $dir1;
        system ($command) ;

// echo $error; die();
        if ($error != '') {

            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            $url = BASE_URL . 'getBrandView.php';
            $inoutObj->reDirect($url);
            exit();
        }
        
        /*Start Implemented To skip Payment Option*/
        $query = "SELECT company_id FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
        $res = mysql_query($query) or die(mysql_error());
        $row = mysql_fetch_array($res);
        $compId = $row['company_id'];
        
        $brandImg = IMAGE_AMAZON_PATH.'brands/'.$arrUser['icon'];
        $brandId = uuid();
        $_SQL = "INSERT into brands(`id`,`company_id`,`brand_name`,`icon`,active) VALUES('" . $brandId . "','" . $compId . "','" . $arrUser['brand_name'] . "','" . $brandImg . "','1')";
        $res = mysql_query($_SQL) or die(mysql_error());   
        $_SESSION['MESSAGE'] = BRAND_REGISTER_SUCCESS;
        $url = BASE_URL . 'getBrandView.php';
        $inoutObj->reDirect($url);
        exit();
        /*End Implemented To skip Payment Option*/
        
        /*Start skip Old Payment Option*/
        /*
        $query = "SELECT company_id,pre_loaded_value FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
        $res = mysql_query($query) or die(mysql_error());
        $row = mysql_fetch_array($res);
        $compId = $row['company_id'];
        $pre_loaded_value = $row['pre_loaded_value'];

        $query = "SELECT brand_name FROM brands where company_id='".$compId."'";
        $res = mysql_query($query) or die(mysql_error());
        $row = mysql_fetch_array($res);
        $companyId = $row['company_id'];
         //print_r($companyId); die();
        
        if($pre_loaded_value>$arrUser['amount']) {


            $brandImg = IMAGE_AMAZON_PATH.'brands/'.$arrUser['icon'];

            $brandId = uuid();
            $_SQL = "INSERT into brands(`id`,`company_id`,`brand_name`,`icon`,active)
            VALUES('" . $brandId . "','" . $compId . "','" . $arrUser['brand_name'] . "','" . $brandImg . "','1')";
            $res = mysql_query($_SQL) or die(mysql_error());
            
            //remainder value in the account
            $total =$pre_loaded_value - $arrUser['amount'];

            //updating the company table

            $_SQL = "UPDATE company SET pre_loaded_value='$total' WHERE  company_id='$compId'";
            $q = $db->query($_SQL);
            $_SESSION['MESSAGE'] = BRAND_REGISTER_SUCCESS;
             $url = BASE_URL . 'getBrandView.php';
             $inoutObj->reDirect($url);
           
            exit();
        }
        else {
            $brandImg = IMAGE_AMAZON_PATH.'brands/'.$arrUser['icon'];

            $brandId = uuid();
            $_SQL = "INSERT into brands(`id`,`company_id`,`brand_name`,`icon`,active)
            VALUES('" . $brandId . "','" . $compId . "','" . $arrUser['brand_name'] . "','" . $brandImg . "','0')";
            $res = mysql_query($_SQL) or die(mysql_error());
            //$_SESSION['MESSAGE'] = BRAND_REGISTER_SUCCESS;
            $url = BASE_URL . 'payment.php?action=registerBrand&amount='.$_POST['amount'].'&userId='.$_SESSION['userid'].'&brandId='.$brandId;
            $inoutObj->reDirect($url);
            exit();
        }*/
        /*End skip Old Payment Option*/
        
    }



    function editBrandIconDetails() {
        $db = new db();
        $inoutObj = new inOut();
        $db->makeConnection();
        $data = array();
        $error = '';

        $arrUser['icon'] = $_POST['picture'];
        $arrUser['brandName'] = $_POST['brandName'];

        $coupenName = "cpn_" . md5(time());
        $info = pathinfo($_FILES["picture"]["name"]);
        if (!empty($_FILES["picture"]["name"])) {
            if (strtolower($info['extension']) == "png") {
                if ($_FILES["picture"]["error"] > 0) {
                    $error.=$_FILES["picture"]["error"] . "<br />";
                } else {
                    $coupon_filename = $coupenName . "." . strtolower($info['extension']);
                    $fileOriginal = $_FILES['picture']['tmp_name'];
                    $crop = '5';
                    $size = 'brand';
                    $path = UPLOAD_DIR . "brands/";
                    $fileThumbnail = $path . $coupon_filename;
                    createFileThumbnail($fileOriginal, $fileThumbnail, $size, $frontUpload = 0, $crop, $errorMsg);
                    $arrUser['icon'] = $coupon_filename;
                }
            } else {
                $error.=NOT_VALID_EXT;
            }
        } else {
            if ($_SESSION['preview']['icon'] != "") {
                $arrUser['icon'] = $_SESSION['preview']['icon'];
            } elseif ($_POST['icon'] == "") {
                $error.=ERROR_LARGE_STANDARD_IMAGE;
            } else {
                if ($_SESSION['preview']['icon'] != "") {
                    $arrUser['icon'] = $_SESSION['preview']['icon'];
                } elseif ($_POST['icon'] == "") {
                    $error.= ERROR_SMALL_IMAGE;
                } else {
                    $arrUser['icon'] = $_POST['icon'];
                }
            }
        }

        /////////////////////////// upload smallimages into server///////////////////
        $file1 = _UPLOAD_IMAGE_ . 'brands/' . $arrUser['icon'];
        $dir1="brands";
        $command = IMAGE_DIR_PATH . $file1 ." ". $dir1;
        system ($command) ;

        if ($error != '') {

            $_SESSION['MESSAGE'] = $error;
            $_SESSION['post'] = $_POST;
            $url = BASE_URL . 'getBrandView.php';
            $inoutObj->reDirect($url);
            exit();
        }

        $query = "SELECT * FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
        $res = mysql_query($query) or die(mysql_error());
        $row = mysql_fetch_array($res);
        $compId = $row['company_id'];

        $query = "SELECT icon FROM brands WHERE company_id='" . $compId . "'";
        $res = mysql_query($query) or die(mysql_error());
        $row = mysql_fetch_array($res);
        $iconName = $row['icon'];
        //unlink(UPLOAD_DIR . 'brands/' . $iconName);

        $brandImg = IMAGE_AMAZON_PATH.'brands/'.$arrUser['icon'];

        $query = "UPDATE brands SET icon ='" .$brandImg. "',brand_name  ='" .$arrUser['brandName']. "' WHERE company_id  = '" . $compId . "'";
        $res = mysql_query($query) or die(mysql_error());

        $_SESSION['MESSAGE'] = EDIT_ICON_SUCCESS;
        $url = BASE_URL . 'getBrandView.php';
        $inoutObj->reDirect($url);
        exit();
    }

    function registeredBrandUpdate($brandId) {
        $inoutObj = new inOut();
        $query = "SELECT * FROM company WHERE u_id='" . $_SESSION['userid'] . "'";
        $res = mysql_query($query) or die(mysql_error());
        $row = mysql_fetch_array($res);
        $compId = $row['company_id'];

        $query = "UPDATE brands SET active ='1' WHERE id  = '" . $brandId . "'";
        $res = mysql_query($query) or die(mysql_error());
        if($res) {
            $_SESSION['MESSAGE'] = BRAND_REGISTER_SUCCESS;
        } else {
            $_SESSION['MESSAGE'] = BRAND_REGISTER_FAIL;
        }
        $url = BASE_URL . 'getBrandView.php';
        $inoutObj->reDirect($url);
        exit();
        //print_r($_POST); die();
    }

    function  uploadCategory() {

        $inoutObj = new inOut();
        //$_SESSION['campaign_for_edit'] = serialize($_POST);
        $db = new db();
        $arrUser = array();
        $error = '';

        $arrUser['small_image'] = $_POST['Image'];
        $arrUser['text'] = $_POST['categoryName'];

        $categoryId = uuid();
        $query = "INSERT INTO category(`category_id`,`small_image`)
                VALUES ('" . $categoryId . "','" . $arrUser['small_image'] . "',);";
        $res = mysql_query($query) or die("Inset campaign : " . mysql_error());

        $nameLangList = uuid();
        $_SQL = "insert into category_names_lang_list(`category`,`names_lang_list`) values('" . $categoryId . "','" . $nameLangList . "')";
        $res = mysql_query($_SQL) or die("Insert limit period : " . mysql_error());


        $_SQL = "insert into lang_text(id,lang,text) values('" . $nameLangList . "','" . $arrUser['lang'] . "','" . $arrUser['text']. "')";
        $res = mysql_query($_SQL) or die("sub slogan in lang_text : " . mysql_error());



    }

    function deleteBrandById() {
        //print_r($data); die("dssdada");

        $db = new db();
        $inoutObj = new inOut();
        $db->makeConnection();
        $_SQL = "UPDATE brands SET active='2' WHERE  id='" . $_GET['brandId'] . "'";
        $q = $db->query($_SQL);
        $url = BASE_URL . 'getBrandView.php';
        $inoutObj->reDirect($url);
    }

}
?>
