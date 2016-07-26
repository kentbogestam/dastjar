<?php
/*  File Name : addCompany.php
*  Description : Add Company Form
*  Author  :Himanshu Singh  Date: 25th,Nov,2010  Creation
*/
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
include_once("header.php");
?>
<UL>
    <LI> "<a href='login.php'>Login as a Reseller</a>"
    <LI> "<a href='login.php'>Login as a Product admin</a>"
    <LI> "<a href='login.php'>Login as a User admin</a>"
</UL>
<SELECT NAME="Select your Role">
    <OPTION value="<a href='login.php'></a>"> Login as a Reseller
    <OPTION value="<a href='login.php'></a>"> Login as a Product admin
    <OPTION value="<a href='login.php'></a>"> Login as a User admin
</SELECT><P>

    <script type="text/javascript">
        function link_go(){
            if (document.link_form.link_sel.options[document.link_form.link_sel.selectedIndex].value != "none") {
                location = document.link_form.link_sel.options[document.link_form.link_sel.selectedIndex].value
            }
        }

        document.write('<form name="link_form"><select name="link_sel" size=1 onchange="link_go()">');
        document.write('<option value=none>Select your Role');
        document.write('<option value=none>--------------------');
        document.write('<option value="http://localhost/cumbari_admin/login.php">Login as a Reseller');
        document.write('<option value="http://localhost/cumbari_admin/login.php">Login as a Product admin');
        document.write('<option value="http://localhost/cumbari_admin/login.php">Login as a User admin');
        document.write('</select>');
        document.write('</form>');
    </script>


</body>
</html>