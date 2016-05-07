<?php
/* File Name   : addEditCategory.php
 *  Description : addEditCategory
 *  
*/
header('Content-Type: text/html; charset=ISO-8859-15');
include_once("cumbari.php");
$menu = "cat";
$cat = 'class="selected"';
include("mainSupport.php");
$supportObj = new support();
$editId = $_GET['editId'];

if($editId)
{
   $data = $supportObj->getCategory($editId);
  //echo"<pre>"; print_r($data);echo"</pre>";
}
if (isset($_POST['continue']) AND $editId == '') {
    $supportObj->addCategory();
}

if (isset($_POST['continue']) AND $editId != '') {
    $supportObj->editCategory($editId);
}
//after post

/////////////////////



?>
<?php include 'config/defines.php'; ?>
 <script language="JavaScript" src="client/js/jquery.js" type="text/javascript"></script>
 <script language="JavaScript" src="client/js/jsAddCategory.js" type="text/javascript"></script><style type="text/css">
<!--
.center{width:900px; margin-left:auto; margin-right:auto;}

-->
</style>
 <div class="center">

<table width="100%" border="0">
		<tr>
				<td >&nbsp;</td>
		</tr>
		<tr>
				<td >&nbsp;</td>
		</tr>
		<tr>
                           <? if($editId == '') {?>
                    <td class="redwhitebutton">ADD CATEGORY</td>
                    <? }  else { ?>
 
				 <td class="redwhitebutton">EDIT CATEGORY</td>
                           <? } ?>
                                
		</tr>
</table>


<div align="center">
		<form name="category" action="" id="category" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="names_lang_swe" value="<?=$data[1]['names_lang_list']?>"/>
                    <input type="hidden" name="names_lang_eng" value="<?=$data[0]['names_lang_list']?>"/>
       <br>
        <input type="hidden" name="m" value="">
        <div id="msg" align="center">

            <?php

            if($_SESSION['MESSAGE']) {
                echo $_SESSION['MESSAGE'];
                $_SESSION['MESSAGE']="";
            }
            ?>
        </div>

       



        <td width="100%"><table BORDER=0 cellspacing="10" width="100%" >

                <tr>
                    <td colspan="3" ></td>
                </tr>

                <tr>
                    <td width="50%" align="left" class="inner_grid"> Category Name In German<span class='mandatory'>*</span> :</td>
                    <td width="50%" align="left">
                         <INPUT class="text_field_new" type="text" name="cNGer" id="cNGer" value="<?=$data[0]['text']?>">
                       <a title="<?=CAT_NAME_GER?>" class="vtip"><b><small>?</small></b></a><br/>
                        <div id='error_cnger' class="error"></div></td>
                </tr>
                <tr>
                    <td width="50%" align="left" class="inner_grid"> Category Name In English<span class='mandatory'>*</span> :</td>
                    <td width="50%" align="left">
                         <INPUT class="text_field_new" type="text" name="cNEng" id="cNEng" value="<?=$data[0]['text']?>">
                       <a title="<?=CAT_NAME_ENG?>" class="vtip"><b><small>?</small></b></a><br/>
                        <div id='error_cneng' class="error"></div></td>
                </tr>

                <tr>

                    <td align="left" class="inner_grid">Category Name In Swedish<span class='mandatory'>*</span>:</td>
                    <td align="left">
                        <INPUT class="text_field_new" type="test" name="cNSwe" id="cNSwe" value="<?=$data[1]['text']?>"/>
                        <a title="<?=CAT_NAME_SWE?>" class="vtip"><b><small>?</small></b></a><br/>
                        <div id='error_cnswe' class="error"></div></td>
                </tr>


                                           <? if($editId == '') {?>

                 <tr>

                    <td align="left" class="inner_grid">Icon<span class='mandatory'>*</span>:</td>
                    <td align="left">
                        <input type="file" name="icon" id="icon" />
                        <img src="<?=$data[0]['small_image']?>"/>
                         <a title="<?=ICON?>" class="vtip"><b><small>?</small></b></a><br/>
                        <div id='error_icon' class="error"></div></td>
                </tr>
                                               <? }  else { ?>
                 <tr>

                    <td align="left" class="inner_grid">Icon:</td>
                    <td align="left">
                        <input type="file" name="icon" id="icon" />
                        <img src="<?=$data[0]['small_image']?>"/>
                         <a title="<?=ICON?>" class="vtip"><b><small>?</small></b></a><br/>
                        <div id='error_icon' class="error"></div></td>
                </tr>
                                               <? } ?> 
			 <td align="left">&nbsp;</td>
			 <td align="left">&nbsp;</td></tr>
              <? if($editId == '') {?>
        <tr>
                    <td colspan='3' align="center">
                        <INPUT style="margin-left:160px;" type="submit" value="Continue" class="button" name="continue" id="continue">
                        <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showCategory.php';" >
                </tr>
             <? }  else { ?>
                 <tr>
                    <td colspan='3' align="center">
                        <INPUT style="margin-left:160px;" type="submit" value="Update" class="button" name="continue" id="update">
                        <INPUT type="button" value="Back" name="continue" id="continue" class="button" onClick="javascript:location.href='showCategory.php';" >
                </tr>
           <? } ?>
                
            </table>
        </td>

    </form>
</div><span class='mandatory'>* These Fields Are Mandatory</span></div>
<? include("footer.php"); ?>

</body>
</html>

