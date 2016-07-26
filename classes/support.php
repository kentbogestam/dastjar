<?php
/*  File Name : addCompany.php
 *  Description : Add Company Form
 *  Author  :Himanshu Singh  Date: 23rd,Nov,2010  Creation
*/

include('lib/resizer/resizer.php');

class support {
    /* Function Header :svrOfferDflt()
     *             Args: none
     *           Errors: none
     *     Return Value: none
     *      Description: User Campaign Offer default function
    */

    function svrOfferDflt($paging_limit='0 , 10') {

        if (isset($_REQUEST['m']) && $_REQUEST['m'] != '') {
            $mode = $_REQUEST['m'];
        } else {
            $mode = '';
        }

        switch ($mode) {

            

        }
    }

   
	 function showUsers() {

			$db = new db();
			$db->makeConnection();
			$data = array();

			$res = $this->searchUsers();

			$total_records = $db->numRows($res);

			return $total_records;
		}
		
	
	 function searchUsers($paging_limit=0) {

        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key']) OR isset($_REQUEST['ke'])) {
            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'email LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
            if ($_REQUEST['key']) {
                $set_keywords.= 'company_name LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }
            if ($_REQUEST['ke']) {
                $set_keywords.= 'fname  LIKE "%' . trim($_REQUEST['ke']) . '%"  OR lname  LIKE "%' . trim($_REQUEST['ke']) . '%" OR concat_ws(" ",fname,lname) LIKE "%' . trim($_REQUEST['ke']) . '%" AND ';
            }
        }
        else
            $set_keywords = " 1 AND ";

        if($paging_limit)
            $limit = "limit ".$paging_limit;

  
        $QUE = "SELECT user.u_id,email,fname,lname,company_name,role  FROM user LEFT JOIN company ON  user.u_id = company.u_id WHERE user.role = 'Store Admin' AND $set_keywords 1 ".$limit;

        $res = mysql_query($QUE);

        return $res;
    }
	
	
	
	function showUserDetails($paging_limit='0 , 10')
	{
		
        $db = new db();
        $db->makeConnection();
        $data = array();

        $q = $this->searchUsers($paging_limit);

        while ($rs = mysql_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
	}

        /////////////category related code ////////////
        
   function showCategory()
   {
      $db = new db();
      $db->makeConnection();
      $data = array();

      $res = $this->searchCategory();
      $total_records = $db->numRows($res);
      return $total_records;
      
   }

   
    function searchCategory($paging_limit=0,$lang='eng')
    {
     if (isset($_REQUEST['key'])) {
            $set_keywords = "";
            if ($_REQUEST['key']) {
                $set_keywords.= 'lang_text.text LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }
            
        }
        else
            $set_keywords = " 1 AND ";

        if($paging_limit)
            $limit = "limit ".$paging_limit;

         $QUE = "SELECT * FROM category_names_lang_list LEFT JOIN lang_text ON lang_text.id = category_names_lang_list.names_lang_list
                LEFT JOIN category ON category.category_id = category_names_lang_list.category
                  WHERE lang_text.lang = '" . $lang . "' AND $set_keywords 1 ".$limit;
         $res = mysql_query($QUE);



        return $res;

    }

    function showCategoryDetails($paging_limit='0 , 10',$lang='eng')
	{
		
        $db = new db();
        $db->makeConnection();
        $data = array();

        $q = $this->searchCategory($paging_limit,$lang);

        while ($rs = mysql_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
	}

        
   function addCategory()
   {
       $db = new db();
        $db->makeConnection();
        $data = array();
        $inoutObj = new inOut();
        
        $arrUser['cNEng'] = $_POST['cNEng'];
        $arrUser['cNSwe'] = $_POST['cNSwe'];
       $arrUser['icon'] = $_POST['icon'];

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
                        $size = 'new_cat_icon';
                        $path = UPLOAD_DIR . "category_lib/";
                        $fileThumbnail = $path . $cat_filename;
                        createFileThumbnail($fileOriginal, $fileThumbnail, $size, $frontUpload = 0, $crop, $errorMsg);
                        $arrUser['small_image'] = $cat_filename;
                    }
                } else {
                    $error.=NOT_VALID_EXT;
                }
            }
        } 

        $catImg = _UPLOAD_URLDIR_ . 'category_lib/' . $arrUser['small_image'];

        $langId1 = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $langId1 . "','ENG','" . $arrUser['cNEng'] . "')";
        $res = mysql_query($_SQL) or die("sub slogan in lang_text : " . mysql_error());

        $langId2 = uuid();
        $_SQL = "insert into lang_text(id,lang,text) values('" . $langId2 . "','SWE','" . $arrUser['cNSwe'] . "')";
        $res = mysql_query($_SQL) or die("sub slogan in lang_text : " . mysql_error());

        $catNameId = uuid();
        $_SQL = "insert into category_names_lang_list(category,names_lang_list) values('" . $catNameId . "','" . $langId1 . "')";
        $res = mysql_query($_SQL) or die("sub slogan in lang_text : " . mysql_error());

        $_SQL = "insert into category_names_lang_list(category,names_lang_list) values('" . $catNameId . "','" . $langId2 . "')";
        $res = mysql_query($_SQL) or die("sub slogan in lang_text : " . mysql_error());

        $_SQL = "insert into category(category_id,small_image) values('" . $catNameId . "','" . $catImg . "')";
        $res = mysql_query($_SQL) or die("sub slogan in lang_text : " . mysql_error());

         $_SQL = "SELECT * FROM categories";
        $res = mysql_query($_SQL) or die("sub slogan in lang_text : " . mysql_error());
        $rs = mysql_fetch_array($res);
        $id = $rs['id'];
        
        $_SQL = "insert into categories_list_of_categories(categories,list_of_categories) values('" . $id . "','" . $catNameId . "')";
        $res = mysql_query($_SQL) or die("sub slogan in lang_text : " . mysql_error());

    

         $_SESSION['MESSAGE'] = ADD_CATEGORY;
        $url = BASE_URL . 'showCategory.php';
        $inoutObj->reDirect($url);
        exit();

   }


   function deleteCategory($catId)

   {
        $db = new db();
        $db->makeConnection();
        $data = array();
        $inoutObj = new inOut();

        $query = "DELETE FROM categories_list_of_categories WHERE list_of_categories = '" . $catId . "'";
        $res = mysql_query($query) or die(mysql_error());

        $query="SELECT small_image FROM category WHERE category_id = '" . $catId . "'";
        $res = mysql_query($query) or die(mysql_error());
        $rs = mysql_fetch_array($res);
        $small_img = $rs['small_image'];
        $pathArr = explode("/",$small_img);
        $arrSize = count($pathArr);
   
        $imageName = $pathArr[$arrSize-1];
        $actualPath=UPLOAD_DIR.'category_lib/'.$imageName;
        @unlink($actualPath);
        

        $query = "DELETE FROM category WHERE category_id = '" . $catId . "'";
        $res = mysql_query($query) or die(mysql_error());

        $query = "SELECT * FROM category_names_lang_list WHERE category = '" . $catId . "'";
        $res = mysql_query($query) or die(mysql_error());
        while($rs = mysql_fetch_array($res))
        {
             $nameLang = $rs['names_lang_list'];
             $query1 = "DELETE FROM lang_text WHERE id = '" . $nameLang . "'";
             $res1 = mysql_query($query1) or die(mysql_error());

        }

        $query = "DELETE FROM category_names_lang_list WHERE category = '" . $catId . "'";
         $res = mysql_query($query) or die(mysql_error());
            
     
   }

   function getCategory($editId)
   {
       $db = new db();
        $db->makeConnection();
        $data = array();
        $inoutObj = new inOut();

        
        $QUE = "SELECT * FROM category_names_lang_list LEFT JOIN lang_text ON lang_text.id = category_names_lang_list.names_lang_list
        LEFT JOIN category ON category.category_id = category_names_lang_list.category
        WHERE category.category_id = '" . $editId . "' order by lang";

         $res = mysql_query($QUE);
        while($rs = mysql_fetch_array($res))
        {
        $data[] = $rs;
        
        }

        return $data;

   }

   function editCategory($editId)
   {
      $db = new db();
        $db->makeConnection();
        $data = array();
        $inoutObj = new inOut();

        $arrUser['cNEng'] = $_POST['cNEng'];
        $arrUser['cNSwe'] = $_POST['cNSwe'];
        $arrUser['icon'] = $_FILES['icon']['name'];
        $arrUser['names_lang_swe'] = $_POST['names_lang_swe'];
        $arrUser['names_lang_eng'] = $_POST['names_lang_eng'];

        ///////////delete previous icon////

        if($arrUser['icon'] != '')
        {
        
        $query = "SELECT * FROM category WHERE category_id = '" . $editId . "'";
        $res = mysql_query($query) or die(mysql_error());
        $rs = mysql_fetch_array($res);
        $image = $rs['small_image'];
       $path =  explode("/",$image);
       $count = count($path);
       $imageName = $path[$count-1];
       $actualPath=UPLOAD_DIR.'category_lib/'.$imageName;
       @unlink($actualPath);
        }



       

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
                        $size = 'new_cat_icon';
                        $path = UPLOAD_DIR . "category_lib/";
                        $fileThumbnail = $path . $cat_filename;
                        createFileThumbnail($fileOriginal, $fileThumbnail, $size, $frontUpload = 0, $crop, $errorMsg);
                        $arrUser['small_image'] = $cat_filename;
                    }
                } else {
                    $error.=NOT_VALID_EXT;
                }
            }
        }

        $catImg = _UPLOAD_URLDIR_ . 'category_lib/' . $arrUser['small_image'];


       

       if($arrUser['icon'] != '')
       {
        $_SQL = "UPDATE category SET small_image = '" .  $catImg  . "' WHERE category_id = '" . $editId . "'";
        $res = mysql_query($_SQL) or die("sub slogan in lang_text : " . mysql_error());

       }

        $_SQL = "UPDATE lang_text SET text = '" .  $arrUser['cNEng'] . "' WHERE id = '" . $arrUser['names_lang_eng'] . "' AND lang = 'ENG' ";
        $res = mysql_query($_SQL) or die("sub slogan in lang_text : " . mysql_error());

        $_SQL = "UPDATE lang_text SET text = '" .  $arrUser['cNSwe'] . "' WHERE id = '" . $arrUser['names_lang_swe'] . "' AND lang = 'SWE' ";
        $res = mysql_query($_SQL) or die("sub slogan in lang_text : " . mysql_error());


        $_SESSION['MESSAGE'] = EDIT_CATEGORY;
      $url = BASE_URL . 'showCategory.php';
        $inoutObj->reDirect($url);
        exit();
   }
////////////////////////////////partner related code////////////

   function showPartner()
   {
      $db = new db();
      $db->makeConnection();
      $data = array();

      $res = $this->searchPartner();
      $total_records = $db->numRows($res);
      return $total_records;

   }


    function searchPartner($paging_limit=0)
    {
    if (isset($_REQUEST['key']) OR isset($_REQUEST['ke'])) {
            $set_keywords = "";
            
            if ($_REQUEST['key']) {
                $set_keywords.= 'company_name LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }
            if ($_REQUEST['ke']) {
                $set_keywords.= 'country  LIKE "%' . trim($_REQUEST['ke']) .  '%" AND ';
            }
        }
        else
            $set_keywords = " 1 AND ";

        if($paging_limit)
            $limit = "limit ".$paging_limit;


        $QUE = "SELECT * FROM partner  WHERE $set_keywords 1 ".$limit;

        $res = mysql_query($QUE);

        return $res;

    }

    function showPartnerDetails($paging_limit='0 , 10')
	{

        $db = new db();
        $db->makeConnection();
        $data = array();

        $q = $this->searchPartner($paging_limit);

        while ($rs = mysql_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
	}

    function addPartner()
    {
       $db = new db();
        $db->makeConnection();
        $data = array();
        $inoutObj = new inOut();

        $arrUser['company'] = $_POST['company'];
        $arrUser['country'] = $_POST['country'];
       $arrUser['city'] = $_POST['city'];
        $arrUser['street'] = $_POST['street'];
        $arrUser['orgnr'] = $_POST['orgnr'];
       $arrUser['version'] = $_POST['version'];
        $arrUser['zip'] = $_POST['zip'];
        

        $partnerId = uuid();
        $_SQL = "insert into partner(partner_id,city,company_name,country,orgnr,street,version,zip) 
            values('" . $partnerId . "','" . $arrUser['city'] . "','" . $arrUser['company'] . "','" . $arrUser['country'] . "','" . $arrUser['orgnr'] . "','" .  $arrUser['street'] . "','" .  $arrUser['version'] . "','" .  $arrUser['zip'] . "')";
        $res = mysql_query($_SQL) or die("sub slogan in lang_text : " . mysql_error());

       $_SESSION['MESSAGE'] = ADD_PARTNER;
        $url = BASE_URL . 'showPartner.php';
        $inoutObj->reDirect($url);
        exit();
    }


    function deletePartner($partId)

   {
        $db = new db();
        $db->makeConnection();
        $data = array();
        $inoutObj = new inOut();

        $query = "DELETE FROM partner WHERE partner_id  = '" . $partId . "'";
        $res = mysql_query($query) or die(mysql_error());

        

   }

   function getPartner($editId)
   {
       $db = new db();
        $db->makeConnection();
        $data = array();
        $inoutObj = new inOut();


        $QUE = "SELECT * FROM partner WHERE partner_id = '" . $editId . "'";
        

         $res = mysql_query($QUE);
        while($rs = mysql_fetch_array($res))
        {
        $data[] = $rs;

        }

        return $data;

   }

   function editPartner($editId)
   {
        $db = new db();
        $db->makeConnection();
        $data = array();
        $inoutObj = new inOut();

        $arrUser['company'] = $_POST['company'];
        $arrUser['country'] = $_POST['country'];
       $arrUser['city'] = $_POST['city'];
        $arrUser['street'] = $_POST['street'];
        $arrUser['orgnr'] = $_POST['orgnr'];
       $arrUser['version'] = $_POST['version'];
        $arrUser['zip'] = $_POST['zip'];

        $_SQL = "UPDATE partner SET city = '" .  $arrUser['city']  . "',company_name = '" .  $arrUser['company']  . "',country = '" .  $arrUser['country']  . "'
            ,orgnr = '" .  $arrUser['orgnr']  . "',street = '" .  $arrUser['street']  . "',version = '" .  $arrUser['version']  . "',zip  = '" .  $arrUser['zip']  . "' WHERE partner_id = '" . $editId . "'";
        $res = mysql_query($_SQL) or die("sub slogan in lang_text : " . mysql_error());

        $_SESSION['MESSAGE'] = EDIT_PARTNER;
        $url = BASE_URL . 'showPartner.php';
        $inoutObj->reDirect($url);
        exit();
   }


   function addCcode()
    {
       $db = new db();
        $db->makeConnection();
        $data = array();
        $inoutObj = new inOut();

        $arrUser['start_of_publishing'] = $_POST['startDate'];
        $arrUser['end_of_publishing'] = $_POST['endDate'];
       $arrUser['value'] = $_POST['value'];
        


        $ccodeId = uuid();
        $_SQL = "insert into ccode(ccode,start_of_validity,end_of_validity,activ,value)
            values('" . $ccodeId . "','" . $arrUser['start_of_publishing'] . "','" . $arrUser['end_of_publishing'] . "','1','" . $arrUser['value'] . "')";
        $res = mysql_query($_SQL) or die("sub slogan in lang_text : " . mysql_error());

       $_SESSION['MESSAGE'] = ADD_CCODE;
        $url = BASE_URL . 'showCcode.php';
        $inoutObj->reDirect($url);
        exit();
    }


    function showCcode()
   {
      $db = new db();
      $db->makeConnection();
      $data = array();

      $res = $this->searchCcode();
      $total_records = $db->numRows($res);
      return $total_records;

   }


    function searchCcode($paging_limit=0)
    {
    if (isset($_REQUEST['value']) OR isset($_REQUEST['status']) OR isset($_REQUEST['start']) OR isset($_REQUEST['end'])) {
            $set_keywords = "";

            if ($_REQUEST['value']!='') {
                $set_keywords.= 'value = "' . trim($_REQUEST['value']) . '" AND ';
            }

             if ($_REQUEST['status']!='') {
                $set_keywords.= 'activ = "' . trim($_REQUEST['status']) . '" AND ';
            }

             if ($_REQUEST['start']) {
                $set_keywords.= 'start_of_validity = "' . trim($_REQUEST['start']) . '" AND ';
            }

             if ($_REQUEST['end']) {
                $set_keywords.= 'end_of_validity = "' . trim($_REQUEST['end']) . '" AND ';
            }


            
        }
        else
            $set_keywords = " 1 AND ";

        if($paging_limit)
            $limit = "limit ".$paging_limit;


        $QUE = "SELECT * FROM ccode  WHERE $set_keywords 1 ".$limit;

        $res = mysql_query($QUE);

        return $res;

    }

    function showCcodeDetails($paging_limit='0 , 10')
	{

        $db = new db();
        $db->makeConnection();
        $data = array();

        $q = $this->searchCcode($paging_limit);

        while ($rs = mysql_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
	}



        function getCcode($editId)
   {
       $db = new db();
        $db->makeConnection();
        $data = array();
        $inoutObj = new inOut();


        $QUE = "SELECT * FROM ccode WHERE ccode = '" . $editId . "'";


         $res = mysql_query($QUE);
        while($rs = mysql_fetch_array($res))
        {
        $data[] = $rs;

        }

        return $data;

   }

   function editCcode($editId)
   {
      // echo $editId;die();
        $db = new db();
        $db->makeConnection();
        $data = array();
        $inoutObj = new inOut();

       $arrUser['start_of_publishing'] = $_POST['startDate'];
        $arrUser['end_of_publishing'] = $_POST['endDate'];
       $arrUser['value'] = $_POST['value'];

        $_SQL = "UPDATE ccode SET start_of_validity  = '" .  $arrUser['start_of_publishing']  . "',end_of_validity = '" .  $arrUser['end_of_publishing']  . "',value = '" .  $arrUser['value']  . "'
            WHERE ccode = '" . $editId . "'";
        $res = mysql_query($_SQL) or die("sub slogan in lang_text : " . mysql_error());

        $_SESSION['MESSAGE'] = EDIT_CCODE;
        $url = BASE_URL . 'showCcode.php';
        $inoutObj->reDirect($url);
        exit();
   }

   function deleteCcode($cId)

   {
        $db = new db();
        $db->makeConnection();
        $data = array();
        $inoutObj = new inOut();

        $query = "DELETE FROM ccode WHERE ccode  = '" . $cId . "'";
        $res = mysql_query($query) or die(mysql_error());

       

   }

    function changeStatusActive($cId)

   {
        $db = new db();
        $db->makeConnection();
        $data = array();
        $inoutObj = new inOut();

         $_SQL = "UPDATE ccode SET activ   = '0'
            WHERE ccode = '" . $cId . "'";
        $res = mysql_query($_SQL) or die("sub slogan in lang_text : " . mysql_error());

      // $_SESSION['MESSAGE'] = ACTIVE;
        $url = BASE_URL . 'showCcode.php';
        $inoutObj->reDirect($url);
        exit();

   }

    function changeStatusDeactive($cId)

   {
        $db = new db();
        $db->makeConnection();
        $data = array();
        $inoutObj = new inOut();

         $_SQL = "UPDATE ccode SET activ   = '1'
            WHERE ccode = '" . $cId . "'";
        $res = mysql_query($_SQL) or die("sub slogan in lang_text : " . mysql_error());

       //$_SESSION['MESSAGE'] = DEACTIVE;
        $url = BASE_URL . 'showCcode.php';
        $inoutObj->reDirect($url);
        exit();

   }

  

   ////////////// permanent delete script

function getAllUser()
{

    $db = new db();
    $db->makeConnection();
     $data = array();
    $inoutObj = new inOut();

    $query = "SELECT * FROM user";
        $res = mysql_query($query);
         while($rs = mysql_fetch_array($res)) {
        $data[] = $rs;

         }
         return $data;
}

function getTotalCampaign($uId) {

        //$inoutObj = new inOut();
        $db = new db();
        $db->makeConnection();
        $data = array();

        $res = $this->searchAllCampaign($paging_limit='',$uId);

        $total_records = $db->numRows($res);

        return $total_records;
    }
    
function getCampaignDetails($paging_limit='0 , 10',$uId) {

        //$inoutObj = new inOut();
        $db = new db();
        $db->makeConnection();
        $data = array();

        $q = $this->searchAllCampaign($paging_limit,$uId);

        while ($rs = mysql_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }

function searchAllCampaign($paging_limit=0,$uId) {

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

        if($paging_limit)
            $limit = "limit ".$paging_limit;

        $query = "select * from employer where u_id = '" . $uId . "'";
        $res = mysql_query($query);
        $rs = mysql_fetch_array($res);
        $companyId = $rs['company_id'];

       
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
                        campaign.company_id='" . $companyId . "' AND $set_keywords 1 AND (s_activ='0' or s_activ='3') AND lang_text.lang = subsloganT.lang AND (reseller_status = 'A' OR reseller_status = '') GROUP BY campaign_id ".$limit;
    

        $res = mysql_query($QUE);

        return $res;
    }

     function permanentDeleteCampaign($campaignId,$uId){
        $db = new db();
        $db->makeConnection();
        $data = array();
        $inoutObj = new inOut();


        //////////////////// delete campaign
            

            $query2 = "select * from campaign_limit_period_list  where campaign_id = '".$campaignId."'";
            $res2 = mysql_query($query2) or die('1' . mysql_error());//die();
            $rs2 = mysql_fetch_array($res2);
            $limitId = $rs2['limit_period_list'];//die();


            $_SQL3 = "DELETE FROM campaign_limit_period_list  WHERE campaign_id = '". $campaignId ."' AND limit_period_list = '" . $limitId . "' ";
            $res3 = mysql_query($_SQL3) or die(mysql_error());

            $_SQL4 = "DELETE FROM limit_period WHERE limit_id = '" . $limitId . "'";
            $res4 = mysql_query($_SQL4) or die(mysql_error());


              ///////// delete small image and large image

            //$file="https://s3-eu-west-1.amazonaws.com/cumbari-coupons/upload/coupon/cpn_abc.jpg";
           // system ("/usr/local/bin/cumbari_s3del.sh $file ");

            $querydel = "select * from campaign where campaign_id = '".$campaignId."'";
            $resdel = mysql_query($querydel);
            $rsdel = mysql_fetch_array($resdel);
            $small_image = $rsdel['small_image'];
            $large_image = $rsdel['large_image'];

             $file1 = $small_image;
             $command1 = IMAGE_DIR_PATH_DELETE . $file1;
             system ($command1) ;

             $file2 = $large_image;
             $command2 = IMAGE_DIR_PATH_DELETE . $file2;
             system ($command2) ;

              /////////////////


            $query1 = "DELETE FROM campaign WHERE campaign_id = '".$campaignId."'";
            $res1 = mysql_query($query1) or die(mysql_error());

          
            
            $query5 = "select * from campaign_offer_slogan_lang_list  where campaign_id = '".$campaignId."'";
            $res5 = mysql_query($query5) or die('1' . mysql_error());
            while($rs5 = mysql_fetch_array($res5))
            {
            $offslogen = $rs5['offer_slogan_lang_list'];

            $_SQL6 = "DELETE FROM campaign_offer_slogan_lang_list  WHERE campaign_id = '".$campaignId."'";
            $res6 = mysql_query($_SQL6) or die(mysql_error());

            $_SQL7 = "DELETE FROM lang_text WHERE id = '" . $offslogen . "'";
            $res7 = mysql_query($_SQL7) or die(mysql_error());
            }


            $query8 = "select * from campaign_offer_sub_slogan_lang_list  where campaign_id = '".$campaignId."'";
            $res8 = mysql_query($query8) or die('1' . mysql_error());
            while($rs8 = mysql_fetch_array($res8))
            {
            $offtitle = $rs8['offer_sub_slogan_lang_list'];

            $_SQL9 = "DELETE FROM campaign_offer_sub_slogan_lang_list WHERE campaign_id = '".$campaignId."'";
            $res9 = mysql_query($_SQL9) or die(mysql_error());

            $_SQL10 = "DELETE FROM lang_text WHERE id = '" . $offtitle . "'";
            $res10 = mysql_query($_SQL10) or die(mysql_error());
            }

            $query11 = "select * from campaign_keyword  where campaign_id = '".$campaignId."'";
            $res11 = mysql_query($query11) or die('1' . mysql_error());
            while($rs11 = mysql_fetch_array($res11))
            {
            $ckeyword = $rs11['offer_keyword'];

            $_SQL12 = "DELETE FROM campaign_keyword WHERE campaign_id = '".$campaignId."'";
            $res12 = mysql_query($_SQL12) or die(mysql_error());

            $_SQL13 = "DELETE FROM lang_text WHERE id = '" . $ckeyword . "'";
            $res13 = mysql_query($_SQL13) or die(mysql_error());

            }


        $query14 = "select * from c_s_rel  where campaign_id = '" . $campaignId . "'";
        $res14 = mysql_query($query14) or die(mysql_error());
        while ($rs14 = mysql_fetch_array($res14)) {
            $couponId = $rs14['coupon_id'];


          if($couponId) {
     /////////// delete coupon
             $query15 = "DELETE FROM coupon WHERE coupon_id = '".$couponId."'";
                    $res15 = mysql_query($query15) or die(mysql_error());

                    $query16 = "select * from coupon_limit_period_list  where coupon = '" . $couponId . "'";
                    $res16 = mysql_query($query16) or die('1' . mysql_error());
                    $rs16 = mysql_fetch_array($res16);
                    $limitId = $rs16['limit_period_list'];


                    $_SQL17 = "DELETE FROM coupon_limit_period_list WHERE coupon = '" . $couponId . "' AND limit_period_list = '" . $limitId . "' ";
                    $res17 = mysql_query($_SQL17) or die(mysql_error());

                    $_SQL18 = "DELETE FROM limit_period WHERE limit_id = '" . $limitId . "'";
                    $res18 = mysql_query($_SQL18) or die(mysql_error());

                    $query19 = "select * from coupon_offer_slogan_lang_list  where coupon = '" . $couponId . "'";
                    $res19 = mysql_query($query19) or die('1' . mysql_error());
                    while($rs19 = mysql_fetch_array($res19))
                 {
                    $offslogen = $rs19['offer_slogan_lang_list'];

                    $_SQL26 = "DELETE FROM coupon_offer_slogan_lang_list WHERE coupon = '" . $couponId . "'";
                    $res26 = mysql_query($_SQL26) or die(mysql_error());

                    $_SQL27 = "DELETE FROM lang_text WHERE id = '" . $offslogen . "'";
                    $res27 = mysql_query($_SQL27) or die(mysql_error());
                 }


                    $query20 = "select * from coupon_offer_title_lang_list  where coupon = '" . $couponId . "'";
                    $res20 = mysql_query($query20) or die('1' . mysql_error());
                    while($rs20 = mysql_fetch_array($res20))
                  {
                    $offtitle = $rs20['offer_title_lang_list'];

                    $_SQL21 = "DELETE FROM coupon_offer_title_lang_list WHERE coupon = '" . $couponId . "'";
                    $res21 = mysql_query($_SQL21) or die(mysql_error());

                    $_SQL22 = "DELETE FROM lang_text WHERE id = '" . $offtitle . "'";
                    $res22 = mysql_query($_SQL22) or die(mysql_error());
                  }

                     $query23 = "select * from coupon_keywords_lang_list  where coupon = '" . $couponId . "'";
                    $res23 = mysql_query($query23) or die('1' . mysql_error());
                    while($rs23 = mysql_fetch_array($res23))
                  {
                    $ckeyword = $rs23['keywords_lang_list'];

                    $_SQL24 = "DELETE FROM coupon_keywords_lang_list WHERE coupon = '" . $couponId . "'";
                    $res24 = mysql_query($_SQL24) or die(mysql_error());

                    $_SQL25 = "DELETE FROM lang_text WHERE id = '" . $ckeyword . "'";
                     $res25 = mysql_query($_SQL25) or die(mysql_error());

                    }


          }

           $_SQL28 = "DELETE FROM c_s_rel WHERE coupon_id='" . $couponId . "'";
            $res28 = mysql_query($_SQL28) or die(mysql_error());
        }

        $url = BASE_URL . 'showPermntDeleteCampaign.php?uId='.$uId;
        $inoutObj->reDirect($url);
        exit();

   }


   function getTotalStandard($uId) {

        //$inoutObj = new inOut();
        $db = new db();
        $db->makeConnection();
        $data = array();

        $res = $this->searchAllStandard($paging_limit='',$uId);

        $total_records = $db->numRows($res);

        return $total_records;
    }

    function getStandardDetails($paging_limit='0 , 10',$uId) {

        //$inoutObj = new inOut();
        $db = new db();
        $db->makeConnection();
        $data = array();

        $q = $this->searchAllStandard($paging_limit,$uId);

        while ($rs = mysql_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }


    function searchAllStandard($paging_limit=0,$uId) {
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
            //echo"here";die();
        }

        if($paging_limit)
            $limit = "limit ".$paging_limit;

        $query = "select * from employer where u_id = '" . $uId . "'";
        $res = mysql_query($query);
        $rs = mysql_fetch_array($res);
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
           WHERE product.company_id='" . $companyId . "' AND $set_keywords s_activ='0' AND cat.lang = lang_text.lang GROUP BY product_id ".$limit;



        $res = mysql_query($QUE);

        return $res;
    }

function permanentDeleteStandard($productId,$uId){
        $db = new db();
        $db->makeConnection();
        $data = array();
        $inoutObj = new inOut();


        //////////////////// delete product

        ///////// delete small image and large image

            //$file="https://s3-eu-west-1.amazonaws.com/cumbari-coupons/upload/coupon/cpn_abc.jpg";
           // system ("/usr/local/bin/cumbari_s3del.sh $file ");

            $querydel = "select * from product where product_id = '".$productId."'";
            $resdel = mysql_query($querydel);
            $rsdel = mysql_fetch_array($resdel);
            $small_image = $rsdel['small_image'];
            $large_image = $rsdel['large_image'];

             $file1 = $small_image;
             $command1 = IMAGE_DIR_PATH_DELETE . $file1;
             system ($command1) ;

             $file2 = $large_image;
             $command2 = IMAGE_DIR_PATH_DELETE . $file2;
             system ($command2) ;

              /////////////////


          $query14 = "DELETE FROM product WHERE product_id = '".$productId."'";
                $res14 = mysql_query($query14) or die(mysql_error());

                $query15 = "select * from product_offer_slogan_lang_list  where product_id = '" . $productId . "'";
                $res15 = mysql_query($query15) or die('1' . mysql_error());
               while($rs15 = mysql_fetch_array($res15))
                   {
                $offslogen = $rs15['offer_slogan_lang_list'];


                $_SQL16 = "DELETE FROM product_offer_slogan_lang_list WHERE product_id = '" . $productId . "'";
                $res16 = mysql_query($_SQL16) or die(mysql_error());

                $_SQL17 = "DELETE FROM lang_text WHERE id = '" . $offslogen . "'";
                $res17 = mysql_query($_SQL17) or die(mysql_error());

                   }

               

                $query18 = "select * from product_keyword  where product_id = '" . $productId . "'";
                $res18 = mysql_query($query18) or die('1' . mysql_error());
                while($rs18 = mysql_fetch_array($res18))
                    {
                $ckeyword = $rs18['offer_keyword'];

                $_SQL19 = "DELETE FROM product_keyword  WHERE product_id = '" . $productId . "'";
                $res19 = mysql_query($_SQL19) or die(mysql_error());

                $_SQL20 = "DELETE FROM lang_text WHERE id = '" . $ckeyword . "'";
                $res20 = mysql_query($_SQL20) or die(mysql_error());
                    }

                $query21 = "select * from product_price_list  where product_id = '" . $productId . "'";
                $res21 = mysql_query($query21) or die('1' . mysql_error());
                while($rs21 = mysql_fetch_array($res21))
                    {
              
                $_SQL22 = "DELETE FROM product_price_list  WHERE product_id = '" . $productId . "'";
                $res22 = mysql_query($_SQL22) or die(mysql_error());

                    }

//////////////// delete coupon

                     $query1 = "select * from c_s_rel  where product_id = '" . $productId . "'";
        $res1 = mysql_query($query1) or die(mysql_error());
        while ($rs1 = mysql_fetch_array($res1)) {
            $productId = $rs1['product_id'];
            $couponId =$rs1['coupon_id'];
            $storeId =$rs1['store_id'];
            // die();


            if($couponId) {
                $query3 = "DELETE FROM coupon WHERE coupon_id = '".$couponId."'";
                $res3 = mysql_query($query3) or die(mysql_error());

                $query4 = "select * from coupon_offer_slogan_lang_list  where coupon = '" . $couponId . "'";
                $res4 = mysql_query($query4) or die('1' . mysql_error());
               while($rs4 = mysql_fetch_array($res4))
                   {
                $offslogen = $rs4['offer_slogan_lang_list'];


                $_SQL5 = "DELETE FROM coupon_offer_slogan_lang_list WHERE coupon = '" . $couponId . "'";
                $res5 = mysql_query($_SQL5) or die(mysql_error());

                $_SQL6 = "DELETE FROM lang_text WHERE id = '" . $offslogen . "'";
                $res6 = mysql_query($_SQL6) or die(mysql_error());

                   }

                $query7 = "select * from coupon_offer_title_lang_list  where coupon = '" . $couponId . "'";
                $res7 = mysql_query($query7) or die('1' . mysql_error());
                while($rs7 = mysql_fetch_array($res7))
                    {
                 $offtitle = $rs7['offer_title_lang_list'];

                $_SQL8 = "DELETE FROM coupon_offer_title_lang_list WHERE coupon = '" . $couponId . "'";
                $res8 = mysql_query($_SQL8) or die(mysql_error());

                  $_SQL9 = "DELETE FROM lang_text WHERE id = '" . $offtitle . "'";
                  $res9 = mysql_query($_SQL9) or die(mysql_error());

                    }

                $query10 = "select * from coupon_keywords_lang_list  where coupon = '" . $couponId . "'";
                $res10 = mysql_query($query10) or die('1' . mysql_error());
                while($rs10 = mysql_fetch_array($res10))
                    {
                $ckeyword = $rs10['keywords_lang_list'];

                $_SQL11 = "DELETE FROM coupon_keywords_lang_list WHERE coupon = '" . $couponId . "'";
                $res11 = mysql_query($_SQL11) or die(mysql_error());

                $_SQL12 = "DELETE FROM lang_text WHERE id = '" . $ckeyword . "'";
                $res12 = mysql_query($_SQL12) or die(mysql_error());
                    }

                

            }
            $_SQL13 = "DELETE FROM c_s_rel WHERE coupon_id='" . $couponId . "'";
            $res13 = mysql_query($_SQL13) or die(mysql_error());

        }
       
        $url = BASE_URL . 'showPermntDeleteStandard.php?uId='.$uId;
        $inoutObj->reDirect($url);
        exit();

   }

/////////////////////// store


     function getTotalStore($uId) {
        // print_r($data); die("dssdada");
        $db = new db();
        $db->makeConnection();
        $data = array();

        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key'])) {
//            $qstr1 = " store_name REGEXP '[[:<:]]".trim($_REQUEST['keyword'])."[[:>:]]' ";
//            $qstr2 = " email REGEXP '[[:<:]]".trim($_REQUEST['key'])."[[:>:]]' ";
            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'store_name LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
            if ($_REQUEST['key']) {
                $set_keywords.= 'email LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }

            //$set_keywords = "(u_id='".$_SESSION['userid']."' AND ".$qstr1.") OR
            //              (u_id='".$_SESSION['userid']."' AND ".$qstr2.")";
        }
        else
            $set_keywords = " 1 AND ";

        if ($_REQUEST['m'] == "showOutdatedStore") {
           $QUE = "SELECT * FROM store WHERE u_id = '" . $uId . "' AND $set_keywords  s_activ='2'";
        } else {
           $QUE = "SELECT * FROM store WHERE u_id = '" . $uId . "' AND $set_keywords  s_activ='1'";
        }
        //echo $QUE;
        // $res = mysql_query($query) or die(mysql_error());
        $res = mysql_query($QUE) or die(mysql_error());
        $total_records = $db->numRows($res);

        return $total_records;
    }

  function getStoreDetails($paging_limit='0 , 10',$uId) {
        // print_r($data); die("dssdada");
        $db = new db();
        $db->makeConnection();
        $data = array();

        if (isset($_REQUEST['keyword']) OR isset($_REQUEST['key'])) {
            // $qstr1 = " store_name REGEXP '[[:<:]]".trim($_REQUEST['keyword'])."[[:>:]]' ";
            // $qstr2 = " email REGEXP '[[:<:]]".trim($_REQUEST['key'])."[[:>:]]' ";
            $set_keywords = "";
            if ($_REQUEST['keyword']) {
                $set_keywords.= 'store_name LIKE "%' . trim($_REQUEST['keyword']) . '%" AND ';
            }
            if ($_REQUEST['key']) {
                $set_keywords.= 'email LIKE "%' . trim($_REQUEST['key']) . '%" AND ';
            }
            // $set_keywords = "(u_id='".$_SESSION['userid']."' AND ".$qstr1.") OR
            //                  (u_id='".$_SESSION['userid']."' AND ".$qstr2.")";
        }
        else
            $set_keywords = " 1 AND ";

        $q = $db->query("SELECT * FROM store WHERE u_id = '" . $uId . "' AND $set_keywords s_activ='1'  LIMIT {$paging_limit} ");

        // $res = mysql_query($query) or die(mysql_error());
        while ($rs = mysql_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }

 function viewSupportStoreId($storeid,$uid) {
        
        $db = new db();
        $db->makeConnection();
        $data = array();
     
        $q = $db->query("SELECT * FROM store LEFT JOIN coupon_delivery_method ON (coupon_delivery_method.store = store.store_id)
            WHERE store.u_id = '" . $uid . "' AND store.store_id='" . $storeid . "'");
        while ($rs = mysql_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }

    function permanentDeleteStore($storeId,$uId)
    {   
        $db = new db();
        $inoutObj = new inOut();
        $db->makeConnection();
        $_SQL = "DELETE FROM store WHERE u_id = '" . $uId . "' AND store_id='" . $storeId . "'";
        $q = $db->query($_SQL);
        $url = BASE_URL . 'showPermanentDeleteStore.php?uId='.$uId;
        $inoutObj->reDirect($url);
    }


    function getCompanyDetail($ccode='')
    {
        $db = new db();
       $inoutObj = new inOut();
       $data = array();
        $db->makeConnection();
        if($ccode != '')
        {
        $_SQL = "select * from company left join country on (country.iso = company.country) where company.ccode = '" . $ccode . "'";
        $res = mysql_query($_SQL);
        }else {
        $_SQL = "select * from company";
        $res = mysql_query($_SQL);
        }
        while($rs = mysql_fetch_array($res))
        {
            $data[] = $rs;
        }
          return $data;
    }

   function assignCcodeToCompany()
   {
       $db = new db();
       $inoutObj = new inOut();
       $data = array();
       $db->makeConnection();

       $companyId = $_POST['selectCompany'];
       $ccode = $_POST['ccode'];
       $value = $_POST['value'];
      // echo $companyId;
       $_SQL = "select ccode from company where company_id = '" .$companyId . "'";
       $res = mysql_query($_SQL);
       $rs = mysql_fetch_array($res);
       $checkCcode = $rs['ccode'];

       if($checkCcode == '')
       {
         $query = "update company set `ccode` = '" . $ccode . "',`cc_value` = '" . $value . "' where company_id = '" . $companyId . "' ";
         $res = mysql_query($query);
         $_SESSION['MESSAGE'] = ASSIGNCCODE;
         $url = BASE_URL . 'showCcode.php';
        $inoutObj->reDirect($url);
        exit();
       }else{
          $_SESSION['MESSAGE'] = ALREADYCCODE;
          $url = BASE_URL . 'showCcode.php';
        $inoutObj->reDirect($url);
        exit();
       }

   }

   
   
   //*************************************** Advertise Option ********************************************
   
   function getTotalAdvertise($uId) {

        //$inoutObj = new inOut();
        $db = new db();
        $db->makeConnection();
        $data = array();

        $res = $this->searchAllAdvertise($paging_limit='',$uId);

        $total_records = $db->numRows($res);

        return $total_records;
    }
    
function getAdvertiseDetails($paging_limit='0 , 10',$uId) {

        //$inoutObj = new inOut();
        $db = new db();
        $db->makeConnection();
        $data = array();

        $q = $this->searchAllAdvertise($paging_limit,$uId);

        while ($rs = mysql_fetch_array($q)) {
            $data[] = $rs;
        }
        return $data;
    }

function searchAllAdvertise($paging_limit=0,$uId) {

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

        if($paging_limit)
            $limit = "limit ".$paging_limit;

        $query = "select * from employer where u_id = '" . $uId . "'";
        $res = mysql_query($query);
        $rs = mysql_fetch_array($res);
        $companyId = $rs['company_id'];

       
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
                        advertise.company_id='" . $companyId . "' AND $set_keywords 1 AND (s_activ='0' or s_activ='3') AND lang_text.lang = subsloganT.lang AND (reseller_status = 'A' OR reseller_status = '') GROUP BY advertise_id ".$limit;
    

        $res = mysql_query($QUE);

        return $res;
    }

     function permanentDeleteAdvertise($advertiseId,$uId){
        $db = new db();
        $db->makeConnection();
        $data = array();
        $inoutObj = new inOut();


        //////////////////// delete advertise           
        
            $querydel = "select * from advertise where advertise_id = '".$advertiseId."'";
            $resdel = mysql_query($querydel);
            $rsdel = mysql_fetch_array($resdel);
            $small_image = $rsdel['small_image'];
            $large_image = $rsdel['large_image'];

             $file1 = $small_image;
             $command1 = IMAGE_DIR_PATH_DELETE . $file1;
             system ($command1) ;

             $file2 = $large_image;
             $command2 = IMAGE_DIR_PATH_DELETE . $file2;
             system ($command2) ;

              /////////////////


            $query1 = "DELETE FROM advertise WHERE advertise_id = '".$advertiseId."'";
            $res1 = mysql_query($query1) or die(mysql_error());

          
            
            $query5 = "select * from advertise_offer_slogan_lang_list  where advertise_id = '".$advertiseId."'";
            $res5 = mysql_query($query5) or die('1' . mysql_error());
            while($rs5 = mysql_fetch_array($res5))
            {
            $offslogen = $rs5['offer_slogan_lang_list'];

            $_SQL6 = "DELETE FROM advertise_offer_slogan_lang_list  WHERE advertise_id = '".$advertiseId."'";
            $res6 = mysql_query($_SQL6) or die(mysql_error());

            $_SQL7 = "DELETE FROM lang_text WHERE id = '" . $offslogen . "'";
            $res7 = mysql_query($_SQL7) or die(mysql_error());
            }


            $query8 = "select * from advertise_offer_sub_slogan_lang_list  where advertise_id = '".$advertiseId."'";
            $res8 = mysql_query($query8) or die('1' . mysql_error());
            while($rs8 = mysql_fetch_array($res8))
            {
            $offtitle = $rs8['offer_sub_slogan_lang_list'];

            $_SQL9 = "DELETE FROM advertise_offer_sub_slogan_lang_list WHERE advertise_id = '".$advertiseId."'";
            $res9 = mysql_query($_SQL9) or die(mysql_error());

            $_SQL10 = "DELETE FROM lang_text WHERE id = '" . $offtitle . "'";
            $res10 = mysql_query($_SQL10) or die(mysql_error());
            }

            $query11 = "select * from advertise_keyword  where advertise_id = '".$advertiseId."'";
            $res11 = mysql_query($query11) or die('1' . mysql_error());
            while($rs11 = mysql_fetch_array($res11))
            {
            $ckeyword = $rs11['offer_keyword'];

            $_SQL12 = "DELETE FROM advertise_keyword WHERE advertise_id = '".$advertiseId."'";
            $res12 = mysql_query($_SQL12) or die(mysql_error());

            $_SQL13 = "DELETE FROM lang_text WHERE id = '" . $ckeyword . "'";
            $res13 = mysql_query($_SQL13) or die(mysql_error());

            }


        $query14 = "select * from c_s_rel  where advertise_id = '" . $advertiseId . "'";
        $res14 = mysql_query($query14) or die(mysql_error());
        while ($rs14 = mysql_fetch_array($res14)) {
            $couponId = $rs14['coupon_id'];


          if($couponId) {
     /////////// delete coupon
             $query15 = "DELETE FROM coupon WHERE coupon_id = '".$couponId."'";
                    $res15 = mysql_query($query15) or die(mysql_error());        

                    $query19 = "select * from coupon_offer_slogan_lang_list  where coupon = '" . $couponId . "'";
                    $res19 = mysql_query($query19) or die('1' . mysql_error());
                    while($rs19 = mysql_fetch_array($res19))
                 {
                    $offslogen = $rs19['offer_slogan_lang_list'];

                    $_SQL26 = "DELETE FROM coupon_offer_slogan_lang_list WHERE coupon = '" . $couponId . "'";
                    $res26 = mysql_query($_SQL26) or die(mysql_error());

                    $_SQL27 = "DELETE FROM lang_text WHERE id = '" . $offslogen . "'";
                    $res27 = mysql_query($_SQL27) or die(mysql_error());
                 }


                    $query20 = "select * from coupon_offer_title_lang_list  where coupon = '" . $couponId . "'";
                    $res20 = mysql_query($query20) or die('1' . mysql_error());
                    while($rs20 = mysql_fetch_array($res20))
                  {
                    $offtitle = $rs20['offer_title_lang_list'];

                    $_SQL21 = "DELETE FROM coupon_offer_title_lang_list WHERE coupon = '" . $couponId . "'";
                    $res21 = mysql_query($_SQL21) or die(mysql_error());

                    $_SQL22 = "DELETE FROM lang_text WHERE id = '" . $offtitle . "'";
                    $res22 = mysql_query($_SQL22) or die(mysql_error());
                  }

                     $query23 = "select * from coupon_keywords_lang_list  where coupon = '" . $couponId . "'";
                    $res23 = mysql_query($query23) or die('1' . mysql_error());
                    while($rs23 = mysql_fetch_array($res23))
                  {
                    $ckeyword = $rs23['keywords_lang_list'];

                    $_SQL24 = "DELETE FROM coupon_keywords_lang_list WHERE coupon = '" . $couponId . "'";
                    $res24 = mysql_query($_SQL24) or die(mysql_error());

                    $_SQL25 = "DELETE FROM lang_text WHERE id = '" . $ckeyword . "'";
                     $res25 = mysql_query($_SQL25) or die(mysql_error());

                    }


          }

           $_SQL28 = "DELETE FROM c_s_rel WHERE coupon_id='" . $couponId . "'";
            $res28 = mysql_query($_SQL28) or die(mysql_error());
        }

        $url = BASE_URL . 'showPermntDeleteAdvertise.php?uId='.$uId;
        $inoutObj->reDirect($url);
        exit();

   }

   
   
   
   
   
   
   
   
   
   
   
   
 }
?>
