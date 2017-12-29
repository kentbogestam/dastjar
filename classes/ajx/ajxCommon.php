<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
header('Content-Type: text/html; charset=utf-8');
include_once("../../cumbari.php");
if (isset($_REQUEST['m']) && $_REQUEST['m'] != '') {
    $mode = $_REQUEST['m'];
} else {
    $mode = '';
}

switch ($mode) {
    case 'emailvarification':
        //$search_html = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        $ajxObj = new ajxCommon();
        $ajxObj->emailVarification($_POST['email']);
        break;
    case 'existemail':
        //$search_html = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        $ajxObj = new ajxCommon();
        $ajxObj->checkEmailExist($_POST['email']);
        break;
    case 'getCatImg':
        //$search_html = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        $ajxObj = new ajxCommon();
        $ajxObj->getCategoryImage($_POST['catId']);
        break;
     case 'getLangImg':
        //$search_html = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        $ajxObj = new ajxCommon();
        $ajxObj->getCategoryLang($_REQUEST['langId']);
        break;
     case 'getLangSingleImg':
        //$search_html = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        $ajxObj = new ajxCommon();
        $ajxObj->getLangSingleImg($_REQUEST['$selectedId'],$_REQUEST['langId']);
        break;
    case 'existorgnsation':
        //$search_html = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        $ajxObj = new ajxCommon();
        $ajxObj->checkOrganisationExist($_REQUEST['orgnisation']);
        break;
}

class ajxCommon {

    function checkEmailExist($emailid) {

       
        $_SQL = "SELECT email FROM user WHERE email ='$emailid'";
      
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
         
        // $res = mysql_query($_SQL) or die(mysql_error());
        
        $res = $db->query($_SQL);
        $count = $db->numRows($res);
        if ($count > 0) {
            echo $count;
        } else {
            //$rec = $db->fetchRow($res);

            echo $count;
        }
    }

    function getCategoryImage($catId) {
        //echo $catId;
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $QUE = "select small_image from category where category_id='" . $catId . "'";
        $res = mysqli_query($conn , $QUE) or die(mysqli_error($conn));
        $row = mysqli_fetch_array($res);
        $icon = $row['small_image'];
        $icon_new = explode("/",$icon);
		$iconlngth = count($icon_new);
		echo $icon_new[$iconlngth-1]; 
       /* if ($catId == "1") {
            $image = "Shopping.png";
        } elseif ($catId == "2") {
            $image = "FoodSnacks.png";
        } elseif ($catId == "3") {
            $image = "HealthBeauty.png";
        }*/
        //$image = "HealthBeauty.png";
        //echo $image;
       // echo $image;
    }

   function getCategoryLang($lang) {

    $db = new db();
    $conn = $db->makeConnection();
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
   
    $options = "";
     $query = "SELECT cat.category_id, ltext.text, cat.small_image FROM category as cat left join category_names_lang_list as cat_lang
            ON (cat.category_id = cat_lang.category)
            LEFT JOIN lang_text as ltext ON (cat_lang.names_lang_list = ltext.id) WHERE ltext.lang='" . $lang . "' ";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        while ($rs = mysql_fetch_array($res)) {
            $data[] = $rs;

            if ($selectedId == $rs['category_id']) {
                $selected = "selected='selected'";
            } else {
                $selected = "";
            }
            $options.="<option value='" . $rs['category_id'] . "' " . $selected . " >" . $rs['text'] . "</option>";
        }

        echo $options;
        
    }


    function getLangSingleImg($selectedId=0,$lang) {
    $db = new db();
    $conn = $db->makeConnection();
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

      
     $query = "SELECT ltext.text FROM category as cat left join category_names_lang_list as cat_lang
            ON (cat.category_id = cat_lang.category)
            LEFT JOIN lang_text as ltext ON (cat_lang.names_lang_list = ltext.id) WHERE ltext.lang='" . $lang . "' AND cat.category_id = '" . $selectedId . "' ";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
       $rs = mysqli_fetch_array($res);
            $data = $rs[text];


        echo $data;

    }

     function checkOrganisationExist($orgcode) {
         
      $_SQL = "SELECT orgnr FROM company WHERE orgnr ='$orgcode'";

        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // $res = mysql_query($_SQL) or die(mysql_error());

        $res = $db->query($_SQL);
        $count = $db->numRows($res);
        if ($count > 0) {
            echo $count;
        } else {
            //$rec = $db->fetchRow($res);

            echo $count;
        }
    }


}
?>
