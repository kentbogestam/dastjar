<?php
class domain {
	/**
	 * Get list of of added discount for logged-in user
	 * @param  string $paging_limit [description]
	 * @return [type]               [description]
	 */
	function getDomainList($paging_limit = '0 , 100') {
		$db = new db();
		$db->makeConnection();
		$data = array();

		$q = $db->query("SELECT id, domain, brandname, introheading, introduction, status FROM hm_sites WHERE u_id = '{$_SESSION['userid']}' AND status != '2' order by id LIMIT {$paging_limit}");

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
    function getDomainById($id) {
    	$db = new db();
		$db->makeConnection();
		$data = array();

		$q = $db->query("SELECT id, domain, brandname, introheading, introduction, status FROM hm_sites WHERE id = '{$id}' AND u_id = '{$_SESSION['userid']}'");

		while ($rs = mysqli_fetch_array($q)) {
			$data = $rs;
		}

		return $data;
    }

	/**
	 * Check if discount not already exit for remote validation 
	 * @return [type] [description]
	 */
	function remoteCheck()
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
			$query = "SELECT id FROM hm_sites WHERE domain = '{$data['domain']}' AND status != '2'";
		}
		else
		{
			$query = "SELECT id FROM hm_sites WHERE id NOT IN ('{$data['id']}') AND domain = '{$data['domain']}' AND status = '1'";
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
	 * Create
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

		// Check validation
		if( $data['domain'] == '' )
		{
			$error .= "<li class='notice_error'>Required field cann't be empty.</li>";
		}

		// Check if domain is not already exist
		$query = "SELECT id FROM hm_sites WHERE domain = '{$data['domain']}' AND status != '2'";
		$res = mysqli_query($conn, $query) or die(mysql_error());
		
		if( $db->numRows($res) )
		{
			$error .= "<li class='notice_error'>This domain is already exist.</li>";
		}

		// Redirect if error
		if ($error != '') {
			$_SESSION['MESSAGE'] = $error;
			$_SESSION['post'] = $_POST;
			$url = BASE_URL . 'list-domain.php';

			$inoutObj->reDirect($url);
			exit();
		}

		// Create discount
		$query = "INSERT INTO hm_sites (domain, u_id, brandname, introheading, introduction) VALUES ('{$data['domain']}', '{$_SESSION['userid']}', '{$data['brandname']}', '{$data['introheading']}', '{$data['introduction']}')";
		$res = mysqli_query($conn , $query) or die(mysqli_error($conn));

		// Redirect
		$_SESSION['domain'] = $data['domain'];
		$_SESSION['MESSAGE'] = 'Domain created successfully!';
		$url = BASE_URL . 'list-domain.php';

        $inoutObj->reDirect($url);
        exit();
	}

	/**
	 * Delete
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	function delete($id)
	{
		$inoutObj = new inOut();
		$db = new db();
		$conn = $db->makeConnection();
		
		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		// Delete discount
		$query = "UPDATE hm_sites SET status = '2' WHERE id = '{$id}'";
		$res = mysqli_query($conn , $query) or die(mysqli_error($conn));

		// Redirect
		$_SESSION['MESSAGE'] = 'Domain deleted successfully!';
		$url = BASE_URL . 'list-domain.php';

        $inoutObj->reDirect($url);
        exit();
	}
}
?>