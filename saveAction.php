<?php 

	header('Content-Type: text/html; charset=utf-8');
	//header ('Content-type: text/html; charset=utf-8');



	include('lib/resizer/resizer.php');
	require_once('classes/db.php');
	require_once('config/dbConfig.php');
	require_once('classes/inOut.php');
	//use classes\db.php;

	if(isset($_POST['Languang']))
	{
		$inoutObj = new inOut();
        $db = new db();
        $conn = $db->makeConnection();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{}
        $arrUser = array();
        $error = '';

        $arrUser['lang'] = $_POST['Languang'];
        $arrUser['dishType'] = $_POST['DishType'];

        $query = "SELECT * FROM company WHERE u_id='" . $_POST['userId'] . "'";
        $res = mysqli_query($conn , $query) or die(mysql_error());
        $rs_comp = mysqli_fetch_array($res);

        if($rs_comp['company_id'] != ''){
            $query = "INSERT INTO dish_type(`dish_lang`,`dish_name`,`company_id`, `u_id`)
        VALUES ('" . $arrUser['lang'] . "','" . $arrUser['dishType'] . "','" . $rs_comp['company_id'] . "', '" . $_POST['userId'] . "');";
        $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
        } 

        $q = $db->query("SELECT dish_id,dish_name FROM dish_type WHERE u_id = '" . $_POST['userId'] . "' AND  dish_activate='1'");
        while ($rs = mysqli_fetch_array($q)) {
            $data[] = $rs;
        }

        echo json_encode($data);
	}
?>