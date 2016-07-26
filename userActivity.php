<?php
/*  File Name   : login.php
*   Description : Login form
*   Author      : Sushil Singh  Date: 12th,Nov,2010  Creation
*/
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
$menu = "user";
$user = 'class="selected"';
include("Paging.php");
include("mainSupport.php");

$inoutObj = new inOut();

if(!isset($_SESSION['supportuserid'])) {
    $url = BASE_URL . 'support.php';
    $inoutObj->reDirect($url);
    exit;
}
else
{
	$supportObj = new support();
    //$records_per_page = PAGING;
    $records_per_page = PAGING;
    $total_records = $supportObj->showUsers();
    //echo $total_records;
    $pager = new pager($total_records, $records_per_page, @$_GET['_p']);
    $paging_limit = $pager->get_limit();
    $data = $supportObj->showUserDetails($paging_limit);
    //echo"<pre>";print_r($data);echo"</pre>";
}

?>
<script language="JavaScript" src="client/js/jsLogin.js" type="text/javascript"></script>
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
<link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="client/css/mouseovertabs.css">
<body>
<div class="center">
<div style="font-size: 22px; margin-top:20px;">
<b>User Activity</b>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

	  <form id="submitFrm" name="submitFrm" action="" method="get" >
            
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
                                                                    <td height="25" colspan="2" align="left" class='bg_lightgray' name="title"><strong>User Name</strong></td>
                                                                    <td width="80%" align="left" class='bg_lightgray'><input type="text" name="ke" id="name" size="48" value="<?=isset($_GET['ke']) ? $_GET['ke'] : ''
        ?>" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="25" colspan="2" align="left" class='bg_lightgray' name="title"><strong>Company</strong></td>
                                                                    <td width="80%" align="left" class='bg_lightgray'><input type="text" name="key" id="name" size="48" value="<?=isset($_GET['key']) ? $_GET['key'] : ''
        ?>" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="25" colspan="2" align="left" class='bg_lightgray' name="title"><strong>Email</strong></td>
                                                                    <td width="80%" align="left" class='bg_lightgray'><input type="text" name="keyword" id="name" size="48" value="<?=isset($_GET['keyword']) ? $_GET['keyword'] : ''
        ?>" /></td>
                                                                </tr>


                                                                <tr>
                                                                    <td height="25" colspan="3" align="center"  class='bg_lightgray'><table width="100%"  cellpadding="0" cellspacing="0">
                                                                            <tr>
                                                                                <td width="14%" align="center">&nbsp;</td>
                                                                                <td width="28%"  height="43" align="center"><input name='submitFrm' type='submit' class="submit-search-button" id="submitFrm" value="Search" /></td>

                                                                                <td width="58%" align="left" valign="middle">
                                                                                    <a href="userActivity.php"><strong>View All</strong></a>																				</td>
                                                                            </tr>

                                                                        </table>  </td>
                                                                </tr>
                                                            </table>                                                        </td>
                                                        <td width="26%" align="left" valign="top">                                                        </td>
                                                    </tr>
                                                </table>                                        
<!-- </form> -->                                           
<table width="100%" border="0" cellpadding="6" cellspacing="0" class="border">
                                                    <tr>
                                                        <td width="49%" align="left"><?php //echo $pager->get_title('&nbsp;Displaying results {FROM} to {TO} of {TOTAL}');         ?></td>
                                                         <td width="51%" align="right" style="color:#881d0a;">
                                                             <img src="lib/grid/images/loginsupport.jpg" align="absmiddle">Login&nbsp;&nbsp;&nbsp;
                                                            <img src="lib/grid/images/detail.png" align="absmiddle">Show Activities</td>
  </tr>
</table>  
                                            
                                       
</tr>
		
<tr>
            <td height="373" valign="top"><br />

                    <input type="hidden" name="m" value="support_in">

                   
					    <table width="100%" cellpadding="0" cellspacing="2" class="border">
                                                    
			    <tr align="center" height="26" >
									  <td width="24%" height="25" class="bg_darkgray1" align="center"><strong>User Name</strong></td>
									  <td width="24%" class="bg_darkgray1"><strong>Company</strong></td>
									  <td width="24%" class="bg_darkgray1"><strong>Email</strong></td>
									  <td width="28%" align="center" class="bg_darkgray1"><strong>Action</strong></td>
						  </tr>
									<?php
									foreach($data as $data1)
										{
									?>

										<tr align="center" height="26" >
											<td align="center"><?php echo $data1['fname'].' '.$data1['lname']; ?></td>
											<td align="center"><?php echo $data1['company_name']; ?></td>
											<td align="center"><?php echo $data1['email']; ?></td>
											<td align="center"><strong><a href="#" title="Login" onClick="showUser('<?php echo $data1['u_id'];?>');"><img src="lib/grid/images/loginsupport.jpg" align="absmiddle"></a></strong>&nbsp;&nbsp;|&nbsp;&nbsp;<strong><a href="#" title="Show Activities" onClick="showActivities('<?php echo $data1['u_id'];?>');"> <img src="lib/grid/images/detail.png" align="absmiddle"></a></strong></td>
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
			
		function showUser(userid)
		{
			window.open('supportLogin.php?userid='+userid+'&action=showUser','showUser','width=1000,height=1000,toolbar=yes,location=yes,directories=yes,statusbars=yes,menubar=yes,scrollbars=yes,copyhistory=yes,resizable=yes');

		}

		function showActivities(userid)
		{
			window.open('supportLogin.php?userid='+userid+'&action=showActivities','showActivities','width=1000,height=1000,toolbar=yes,location=yes,directories=yes,statusbars=yes,menubar=yes,scrollbars=yes,copyhistory=yes,resizable=yes');

		}

</script>