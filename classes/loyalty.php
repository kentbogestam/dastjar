<?php
class loyalty {
	/**
	 * Get loyalty list for logged-in user
	 * @param  string $paging_limit [description]
	 * @return [type]               [description]
	 */
	function getList($paging_limit = '0 , 10') {
		$db = new db();
		$db->makeConnection();
		$data = array();

		// $q = $db->query("SELECT pl.id, pl.quantity_to_buy, pl.quantity_get, validity, pl.start_date, pl.end_date, s.store_name, dt.dish_name FROM promotion_loyalty AS pl INNER JOIN store AS s ON pl.store_id = s.store_id INNER JOIN dish_type AS dt ON pl.dish_id = dt.dish_id WHERE pl.status = '1' AND s.u_id = '{$_SESSION['userid']}' AND s.s_activ = '1' LIMIT {$paging_limit}");
		
		$q = $db->query("SELECT PL.id, PL.quantity_to_buy, PL.quantity_get, PL.validity, PL.start_date, PL.end_date, S.store_name, GROUP_CONCAT(DT.dish_name) AS dish_name FROM promotion_loyalty AS PL INNER JOIN store AS S ON PL.store_id = S.store_id INNER JOIN promotion_loyalty_dish_type AS PLDT ON PLDT.loyalty_id = PL.id INNER JOIN dish_type AS DT ON PLDT.dish_type_id = DT.dish_id WHERE PL.status = '1' AND S.u_id = '{$_SESSION['userid']}' AND S.s_activ = '1' GROUP BY PL.id LIMIT {$paging_limit}");

		while ($rs = mysqli_fetch_array($q)) {
			$data[] = $rs;
		}

		return $data;
    }

    /**
     * Get count of list
     * @return [type] [description]
     */
	function getTotalRecord() {
		$db = new db();
		$conn = $db->makeConnection();
		
		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}else{}
		
		$data = array();

		//
		$q = "SELECT PL.id FROM promotion_loyalty AS PL INNER JOIN store AS S ON PL.store_id = S.store_id INNER JOIN promotion_loyalty_dish_type AS PLDT ON PLDT.loyalty_id = PL.id INNER JOIN dish_type AS DT ON PLDT.dish_type_id = DT.dish_id WHERE PL.status = '1' AND S.u_id = '{$_SESSION['userid']}' AND S.s_activ = '1' GROUP BY PL.id";

		$res = mysqli_query($conn,$q) or die(mysql_error());
		$total_records = $db->numRows($res);

		return $total_records;
	}

	/**
	 * Create loyalty
	 * @return [type] [description]
	 */
	function create() {
		$inoutObj = new inOut();
		$db = new db();
		$conn = $db->makeConnection();
		
		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		$error = '';
		$data = $_POST;

		// echo '<pre>'; print_r($data); exit;

		// Check validation
		if( $data['store_id'] == '' || empty($data['dish_type_id']) || $data['quantity_to_buy'] == '' || $data['quantity_get'] == '' || $data['validity'] == '' || $data['start_date_utc'] == '' || $data['end_date_utc'] == '' )
		{
			$error .= "<li class='notice_error'>Required field cann't be empty.</li>";
		}
		elseif( strtotime($data['start_date_utc']) >= strtotime($data['end_date_utc']) )
		{
			$error .= "<li class='notice_error'>End date should be greater than start date.</li>";
		}

		// Check if loyalty is not already exist
		$query = "SELECT id FROM promotion_loyalty WHERE (start_date BETWEEN '{$data['start_date_utc']}' AND '{$data['end_date_utc']}' OR end_date BETWEEN '{$data['start_date_utc']}' AND '{$data['end_date_utc']}') AND store_id = '{$data['store_id']}' AND status = '1'";
		$res = mysqli_query($conn, $query) or die(mysql_error());
		
		if( $db->numRows($res) )
		{
			$error .= "<li class='notice_error'>Loyalty is already exist between start and end date and for selected store.</li>";
		}

		// Redirect if error
		if ($error != '') {
			$_SESSION['MESSAGE'] = $error;
			$_SESSION['post'] = $_POST;
			$url = BASE_URL . 'add-loyalty.php';

			$inoutObj->reDirect($url);
			exit();
		}

		// exit;

		// Create loyalty
		$query = "INSERT INTO promotion_loyalty (store_id, quantity_to_buy, quantity_get, validity, start_date, end_date) VALUES ('{$data['store_id']}', '{$data['quantity_to_buy']}', '{$data['quantity_get']}', '{$data['validity']}', '{$data['start_date_utc']}', '{$data['end_date_utc']}')";
		// $res = mysqli_query($conn , $query) or die(mysqli_error($conn));
		if(mysqli_query($conn , $query))
		{
			$loyalty_id = mysqli_insert_id($conn);

			// Add dish_type into 'promotion_loyalty_dish_type'
			$dish_type = $data['dish_type_id'];

			if( !empty($dish_type) )
			{
				foreach($dish_type as $dish_type_id)
				{
					$query = "INSERT INTO promotion_loyalty_dish_type (loyalty_id, dish_type_id) VALUES ('{$loyalty_id}', '{$dish_type_id}')";
					mysqli_query($conn , $query);
				}
			}
		}
		else
		{
			die(mysqli_error($conn));
		}

		// Redirect
		$_SESSION['MESSAGE'] = 'Loyalty created successfully!';
		$url = BASE_URL . 'list-loyalty.php';

        $inoutObj->reDirect($url);
        exit();
	}
}
?>