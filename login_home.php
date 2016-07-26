<?php
//phpinfo();
/*  File Name   : index.php
 *  Description : index file 
 *  Author      : Sushil Singh  Date: 12th,Nov,2010  Creation
 * 
 * 
*/ 	
	header('Content-Type: text/html; charset=utf-8');
     include_once("header.php");
	 
?>



<div id="main" style="width:900px; margin-left:auto; margin-right:auto;">
<div id="singbutton_portion"><table width="100%" border="0">
<tr>
		<td height="102">&nbsp;</td>
		<td width="74%" valign="bottom">&nbsp;</td>
		<td width="22%" align="right" valign="bottom" ><a href="login.php"><img src="images/signin.png" /></a></td>
		<td width="1%" valign="bottom" >&nbsp;</td>
</tr>
<tr>
<td width="3%" height="102">&nbsp;</td>
<td colspan="3" valign="bottom"><table width="100%" border="0">
<tr>
<td class="textbold"><h1>Don't have an <br />
		account on cumbari?</h1></td>
</tr>
<tr>
<td class="textnormal" style="color:#666666;" colspan="2"><strong><h3>Register now to post your first deal.</h3></strong></td>
</tr>
</table></td>
</tr>
</table>
</div>
<div id="mainbutton"><table width="100%" cellspacing="15">
		
		<tr>
				
				<td width="53%" class="redwhitebutton"  style="background-position:center;" ><a href="registrationProcess.php">1 Register</a></td>
				
		</tr>
		<tr>
				
                                <td class="redgraybutton">2 Add Company</td>
				
		</tr>
		<tr>
				
				<td  class="redgraybutton">3 Add Offer</td>
				
		</tr>
		<tr>
				
				<td  class="redgraybutton">4 Activate</td>
				
		</tr>
		<tr>
				<td>&nbsp;</td>
			
		</tr>
</table>
</div>

</div>

<? include_once("footer.php");?>


</div>
</body>
</html>
