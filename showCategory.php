<?php
/*  File Name   : login.php
*   Description : Login form
*   
*/
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
$menu = "cat";
$cat = 'class="selected"';
include("Paging.php");
include("mainSupport.php");

$inoutObj = new inOut();
$case = $_GET['m'];

if($case == 'deleteCategory')
{
    $catId = $_GET['catId'];
    $supportObj = new support();
    $supportObj->deleteCategory($catId);
}
$lang = 'ENG';
 $selectLanguage = $_GET['lang'];
if(!empty($selectLanguage))
    {
        $lang = $selectLanguage;
    }

if(!isset($_SESSION['supportuserid'])) {
    $url = BASE_URL . 'support.php';
    $inoutObj->reDirect($url);
    exit;
}
else
{
    $supportObj = new support();
    $records_per_page = PAGING;
    
    $total_records = $supportObj->showCategory();
   // echo $total_records;die();
    $pager = new pager($total_records, $records_per_page, @$_GET['_p']);
    $paging_limit = $pager->get_limit();
    $data = $supportObj->showCategoryDetails($paging_limit,$lang);
   // echo"<pre>";  print_r($data);echo"</pre>";//die();
}

?>



<script language="JavaScript" src="client/js/jsLogin.js" type="text/javascript"></script>
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />

<body><div class="center">
   <div style="font-size: 22px; margin-top:20px;">
<b>Category</b>
</div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">

	  <form id="submitFrm" name="submitFrm" action="" method="get" >

        <tr>
            <td height="20"></td>
        </tr>
<div align="center"><h2><?php
                                                            if ($_SESSION['MESSAGE']) {
                                                                echo $_SESSION['MESSAGE'];
                                                                $_SESSION['MESSAGE'] = "";
                                                            }
                                                                    ?></h2></div>
                                                                

                                                            
		 <tr>
                                                        <td width="26%">&nbsp;</td>
                                                        <td  align="right" width="455"><table width="100%"  align="center" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td width="8%" height="25" align="left" class="bg_darkgray1"></td>
                                                                    <td width="12%" height="25" align="left" class="bg_darkgray1" style="font-size:16px;"><strong>Search </strong></td>
                                                                    <td height="25" align="left" class="bg_darkgray1">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="3" colspan="2" align="center"  name="title"></td>
                                                                    <td align="left" ></td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="25" colspan="2" align="left" class='bg_lightgray' name="title"><strong> Category Name</strong></td>
                                                                    <td width="80%" align="left" class='bg_lightgray'><input type="text" name="key" id="name" size="48" value="<?=isset($_GET['key']) ? $_GET['key'] : ''
        ?>" /></td>
                                                                </tr>
                                                                
                                                               


                                                                <tr>
                                                                    <td height="25" colspan="3" align="center"  class='bg_lightgray'><table width="100%"  cellpadding="0" cellspacing="0">
                                                                            <tr>
                                                                                <td width="14%" align="center">&nbsp;</td>
                                                                                <td width="28%"  height="43" align="center"><input name='submitFrm' type='submit' class="submit-search-button" id="submitFrm" value="Search" /></td>

                                                                                <td width="58%" align="left" valign="middle">
                                                                                    <a href="showcategory.php"><strong>View All</strong></a>
																				</td>
                                                                            </tr>

                                                                        </table>  </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                       <td width="26%" align="left" valign="top"><div align="center" class="main_bg"  ><a href="addEditCategory.php" ><strong>ADD CATEGORY</strong></a></div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            <!-- </form> -->
<table width="100%" border="0" cellpadding="6" cellspacing="0" class="border">
                                                    <tr>
                                                        <td width="49%" align="left"><?php //echo $pager->get_title('&nbsp;Displaying results {FROM} to {TO} of {TOTAL}');         ?></td>
                                                         <td width="51%" align="right" style="color:#881d0a;">
                                                            <img src="lib/grid/images/edite.gif">Edit&nbsp;&nbsp;&nbsp;
                                                            <img src="lib/grid/images/delete.gif">Delete</td>
                                                    </tr>
                                                </table>
                                                
                                        </td>
</tr>

<tr>
            <td height="373" valign="top"><br />

                  


<table border="0" width="95%" cellspacing="5" align="center" >
        <tr>
        		

          <td width="515" class="inner_grid">Choose Language:<br>            </td>
            <td width="469" align="left" >
                 <input type="hidden" name="m" value="support_in">

                   <select style="width:406px; background-color:#e4e3dd;" onChange="langChange(this.value);" class="text_field_new" name="lang" id="lang" >
                    <option <? if ($lang == "GER")echo "selected='selected'"; ?> value="GER">German</option>
                    <option <? if ($lang == "ENG")echo "selected='selected'"; ?> value="ENG">English</option>
                    <option <? if ($lang == "SWE")echo "selected='selected'"; ?> value="SWE">Swedish</option>
                </select>
                <div id='error_langStand' class="error"></div>            </td>
        </tr>
        <!--<?php /* ?>
                         <form action="" method="post" name="standard_use" id="standard_use" enctype="multipart/form-data"><?php */ ?>-->
       
      
       <!-- <tr>
            <td colspan="4" align="center" height="20"><strong><button onclick="ajaxUpload(this.form,'classes/ajx/ajxUpload.php?filename=icon&amp;maxW=200','upload_area'); return false;">Click here</button> to check how your short campaign proposal looks like</strong></td>
        </tr> -->
    </table>




<table width="100%" cellpadding="0" cellspacing="2" class="border">

<tr align="center" height="26" >
										<td width="15%" height="25" class="bg_darkgray1" align="center"><strong>Category Name In <? echo $lang;?></strong></td>
                                                                                <td width="6%" class="bg_darkgray1"><strong>Icon</strong></td>
										<td width="29%" align="center" class="bg_darkgray1"><strong>Action</strong></td>
									</tr>
									<?php
									foreach($data as $data1)
										{
									?>

										<tr align="center" height="26" >
											<td align="center"><?php echo $data1['text']; ?></td>
											<td align="center"><img src="<?php echo $data1['small_image']; ?>"/></td>
											<td align="center"><strong><a href="#" title="Edit" onClick="editCategory('<?=$data1['category_id'];?>');"><img src="lib/grid/images/edite.gif"></a></strong>&nbsp;&nbsp;|&nbsp;&nbsp;<strong><a href="#" title="Delete" onClick="deleteCategory('<?=$data1['category_id'];?>');"> <img src="lib/grid/images/delete.gif"></a></strong></td>
										</tr>

									<?php } ?>


                         </table>

    <br>
						<table width='100%'  cellpadding="0" cellspacing="0">
							 <?php
								if ($total_records == 0) {
									echo "No Records Found";
								}
								?>
						</table>

						 <table width="100%"  cellpadding="0" cellspacing="0" class="border">
									<tr>
										<td width="67%" align="left"><?php echo $pager->get_title('Displaying Results {FROM} to {TO} of {TOTAL}'); ?></td>
										<td width="33%" align="right">
											<?php
												echo $pager->get_prev('<a href="{LINK_HREF}">Prev</a>&nbsp;');
												echo $pager->get_range('<a href="{LINK_HREF}">{LINK_LINK}</a>', ' &raquo ') . '';
												echo $pager->get_next('<a href="{LINK_HREF}">&nbsp;Next</a>');
											?>
										</td>
									</tr>
                         </table>

                </form>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td height="30" align="left">

            </td>
        </tr>
    </table>
    </div>
    <?php
    include_once("footer.php");
    ?>


 <script>
function langChange(lang)
{
    javascript:location.href = "showCategory.php?lang="+lang;
}

function deleteCategory(catId)
{ 
   var answer = confirm('Are you sure you want to delete this category')
    if(answer)
        {
     var url = 'showCategory.php?m=deleteCategory&catId='+catId;
    window.location = url;
        }


}

function editCategory(catId)
{
    javascript:location.href = "addEditCategory.php?editId="+catId;
}
     
 </script>





