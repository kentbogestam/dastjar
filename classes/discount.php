<?php
class discount {
	/**
	 * Get list of of added discount for logged-in user
	 * @param  string $paging_limit [description]
	 * @return [type]               [description]
	 */
	function getDiscountList($paging_limit = '0 , 10') {
		$db = new db();
		$db->makeConnection();
		$data = array();

		$q = $db->query("SELECT pd.id, pd.code, pd.discount_value, pd.start_date, pd.end_date, pd.status, s.store_name FROM promotion_discount AS pd INNER JOIN store AS s ON pd.store_id = s.store_id WHERE pd.status = '1' AND s.u_id = '{$_SESSION['userid']}' AND s.s_activ = '1' LIMIT {$paging_limit}");

		while ($rs = mysqli_fetch_array($q)) {
			$data[] = $rs;
		}

		return $data;
    }

    /**
     * Get discount by ID
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    function getDiscountById($id) {
    	$db = new db();
		$db->makeConnection();
		$data = array();

		$q = $db->query("SELECT pd.id, pd.code, pd.discount_value, pd.start_date, pd.end_date, pd.status, pd.store_id FROM promotion_discount AS pd INNER JOIN store AS s ON pd.store_id = s.store_id WHERE s.u_id = '{$_SESSION['userid']}' AND s.s_activ = '1' AND pd.id = '{$id}'");

		while ($rs = mysqli_fetch_array($q)) {
			$data = $rs;
		}

		return $data;
    }

    /**
     * Get count of added discount for logged-in user 
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
		$q = "SELECT pd.id FROM promotion_discount AS pd INNER JOIN store AS s ON pd.store_id = s.store_id WHERE pd.status = '1' AND s.u_id = '{$_SESSION['userid']}' AND s.s_activ = '1'";

		$res = mysqli_query($conn,$q) or die(mysql_error());
		$total_records = $db->numRows($res);

		return $total_records;
	}

	/**
	 * Check if discount not already exit for remote validation 
	 * @return [type] [description]
	 */
	function remoteCheckDiscount()
	{
		$db = new db();
		$conn = $db->makeConnection();
		
		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		$status = 'true';
		$data = $_POST;

		// Check if discount is not already exist
		if( !isset($data['id']) )
		{
			$query = "SELECT id FROM promotion_discount WHERE code = '{$data['code']}' AND status = '1'";
		}
		else
		{
			$query = "SELECT id FROM promotion_discount WHERE id NOT IN ('{$data['id']}') AND code = '{$data['code']}' AND status = '1'";
		}
		
		$res = mysqli_query($conn, $query) or die(mysql_error());
		
		if( $db->numRows($res) )
		{
			$status = 'false';
		}

		echo $status;
		exit;
	}

	/**
	 * Create discount
	 * @return [type] [description]
	 */
	function createDiscount() {
		$inoutObj = new inOut();
		$db = new db();
		$conn = $db->makeConnection();
		
		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		$error = '';
		$data = $_POST;

		// Check validation
		if( $data['store_id'] == '' || $data['code'] == '' || $data['discount_value'] == '' || $data['start_date_utc'] == '' || $data['end_date_utc'] == '' )
		{
			$error .= "<li class='notice_error'>Required field cann't be empty.</li>";
		}
		elseif( strtotime($data['start_date_utc']) >= strtotime($data['end_date_utc']) )
		{
			$error .= "<li class='notice_error'>Coupon end date should be greater than coupon start date.</li>";
		}

		// Check if discount is not already exist
		$query = "SELECT id FROM promotion_discount WHERE code = '{$data['code']}' AND status = '1'";
		$res = mysqli_query($conn, $query) or die(mysql_error());
		
		if( $db->numRows($res) )
		{
			$error .= "<li class='notice_error'>This code is already exist for any store.</li>";
		}

		// Redirect if error
		if ($error != '') {
			$_SESSION['MESSAGE'] = $error;
			$_SESSION['post'] = $_POST;
			$url = BASE_URL . 'add-discount.php';

			$inoutObj->reDirect($url);
			exit();
		}

		// Create discount
		$query = "INSERT INTO promotion_discount (store_id, code, discount_value, start_date, end_date) VALUES ('{$data['store_id']}', '{$data['code']}', '{$data['discount_value']}', '{$data['start_date_utc']}', '{$data['end_date_utc']}')";
		$res = mysqli_query($conn , $query) or die(mysqli_error($conn));

		// Redirect
		$_SESSION['MESSAGE'] = 'Discount created successfully!';
		$url = BASE_URL . 'list-discount.php';

        $inoutObj->reDirect($url);
        exit();
	}

	/**
	 * Update discount
	 * @return [type] [description]
	 */
	function updateDiscount($id)
	{
		$inoutObj = new inOut();
		$db = new db();
		$conn = $db->makeConnection();
		
		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		$error = '';
		$data = $_POST;

		// Check validation
		if( $data['store_id'] == '' || $data['code'] == '' || $data['discount_value'] == '' || $data['start_date_utc'] == '' || $data['end_date_utc'] == '' )
		{
			$error .= "<li class='notice_error'>Required field cann't be empty.</li>";
		}
		elseif( strtotime($data['start_date_utc']) >= strtotime($data['end_date_utc']) )
		{
			$error .= "<li class='notice_error'>Coupon end date should be greater than coupon start date.</li>";
		}

		// Check if discount is not already exist
		$query = "SELECT id FROM promotion_discount WHERE id NOT IN ('{$id}') AND code = '{$data['code']}' AND status = '1'";
		$res = mysqli_query($conn, $query) or die(mysql_error());
		
		if( $db->numRows($res) )
		{
			$error .= "<li class='notice_error'>This code is already exist for any store.</li>";
		}

		// Redirect if error
		if ($error != '') {
			$_SESSION['MESSAGE'] = $error;
			$_SESSION['post'] = $_POST;
			$url = BASE_URL . 'edit-discount.php?'.$id;

			$inoutObj->reDirect($url);
			exit();
		}

		// Create discount
		$query = "UPDATE promotion_discount SET store_id = '{$data['store_id']}', discount_value = '{$data['discount_value']}', start_date = '{$data['start_date_utc']}', end_date = '{$data['end_date_utc']}' WHERE id = '{$id}'";
		$res = mysqli_query($conn , $query) or die(mysqli_error($conn));

		// Redirect
		$_SESSION['MESSAGE'] = 'Discount updated successfully!';
		$url = BASE_URL . 'list-discount.php';

        $inoutObj->reDirect($url);
        exit();
	}

	/**
	 * Delete discount
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	function deleteDiscount($id)
	{
		$inoutObj = new inOut();
		$db = new db();
		$conn = $db->makeConnection();
		
		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		// Delete discount
		$query = "UPDATE promotion_discount SET status = '2' WHERE id = '{$id}'";
		$res = mysqli_query($conn , $query) or die(mysqli_error($conn));

		// Redirect
		$_SESSION['MESSAGE'] = 'Discount deleted successfully!';
		$url = BASE_URL . 'list-discount.php';

        $inoutObj->reDirect($url);
        exit();
	}

	/**
	 * Function to generate alphanumeric random number
	 * @param  [type] $size [description]
	 * @return [type]       [description]
	 */
	public function random_num($size) {
        $alpha_key = '';
        $keys = range('A', 'Z');

        for ($i = 0; $i < 3; $i++) {
            $alpha_key .= $keys[array_rand($keys)];
        }

        $length = $size - 3;

        $key = '';
        $keys = range(0, 9);

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $alpha_key . $key;
    }
}
?>