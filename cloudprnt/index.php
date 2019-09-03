<?php
	function handlePost()
	{
		header('Content-Type: application/json');
		$arr;

		// Get JSON payload recieved from the request and parse it
		$receivedJson = file_get_contents("php://input");
		$parsedJson = json_decode($receivedJson, true);
		
		if (!isset($parsedJson['printerMAC'])) exit;

		$str = "\n\nPost: handlePost ".date('Y-m-d H:i')."============\n";
		updateLog($str);
		
		// Setup printer storage directories
		$printerDir = getPrinterDir($parsedJson['printerMAC']);
		// Create any local directories for storing printer data if they do not exist already (i.e. the first time the printer polls to the server)
		// if (!is_dir($printerDir)) mkdir($printerDir, 0755);

		$file = $printerDir."/print.txt";
		updateLog($file);

		if (file_exists($file))
		{
			$arr = array("jobReady" => true,
			"mediaTypes" => array('text/plain'),
			"deleteMethod" => "GET");		
		}
		else $arr = array("jobReady" => false);
		echo json_encode($arr);
	}
	
	function handleGet()
	{
		$mac = $_GET['mac'];
		if ($mac == "") return;

		$str = "\n\nGet: handleGet ".date('Y-m-d H:i')."============\n";
		updateLog($str);

		$printerDir = getPrinterDir($_GET['mac']);
		$file = $printerDir."/print.txt";

		if (file_exists($file)) 
		{
			header('Content-Type: text/plain');
			echo file_get_contents($file);
		}
		else if (file_exists("print.png"))
		{
			header('Content-Type: image/png');
			$fh = fopen("print.png", 'rb');
			fpassthru($fh);
		}
		exit;
	}
	
	function handleDelete()
	{
		$str = isset($_GET) ? "\n\nGet: handleDelete ".date('Y-m-d H:i')."============\n" : "\n\nPost: handleDelete ".date('Y-m-d H:i')."============\n";

		header('Content-Type: text/plain');
		if (isset($_GET['code']) && ($_GET['code'] == '200 OK'))
		{
			$printerDir = getPrinterDir($_GET['mac']);
			$file = $printerDir."/print.txt";
			$str .= $file."\n";

			if (file_exists($file)) {
				unlink($file);
				$str .= "Unlinked: ".$file;
			}
			else if (file_exists("print.png")) {
				unlink("print.png");
			}
			else {
				$str .= "File not found: ".$file;
			}
		}
		else
		{
			$str .= "Code: ".$_GET['code'];
		}

		updateLog($str);
	}

	function getPrinterDir($mac)
	{
		$whitelist = array('127.0.0.1', '::1');
		if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
			$printerDir = $_SERVER['DOCUMENT_ROOT']."/dastjar/cloudprnt/printerdata/".getPrinterFolder($mac);
		}
		else {
			$printerDir = $_SERVER['DOCUMENT_ROOT']."/cloudprnt/printerdata/".getPrinterFolder($mac);
		}

		return $printerDir;
	}

	function getPrinterFolder($printerMac)
	{
		return str_replace(":", ".", $printerMac);
	}
	
	function getPrinterMac($printerFolder)
	{
		return str_replace(".", ":", $printerFolder);
	}

	function updateLog($str)
	{
		$fileName = 'log.txt';
		$filePath = dirname(__DIR__).'/cloudprnt/';

		$fp = fopen($filePath.$fileName, 'a');
		fwrite($fp, print_r($str, true));
		fclose($fp);
	}

	// Setup document headers, these headers apply for all requests.
	header("Cache-Control: no-cache, no-store, must-revalidate");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// POST requests from the printer come with a JSON payload
		// The below code reads the payload and parses it into an array
		// The parsed data can then be used, although this is not mandatory
		$receivedJson = file_get_contents("php://input");
		$parsedJson = json_decode($receivedJson, true);
		// Handle the post request
		handlePost();
	}
	else if ($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		// By default a GET request usually means the printer is requesting
		// data that it can print.  When printing is done the printer sends a
		// HTTP DELETE request to indicate the job has been printed, however some
		// servers only support HTTP POST and HTTP GET so if you specify the deleteMethod
		// as GET in your HTTP POST JSON response, then the printer will send a HTTP GET
		// request and add "delete" into the parameters, e.g. http://<ip>/index.php?mac=<mac>&delete.
		// So in this case if the delete parameter exists we count the job as printed, otherwise we
		// handle it as a standard GET request and provide data for printing
		if (isset($_GET['delete'])) handleDelete();
		else handleGet();
	}
	// A delete request indicates printing has finished and the current job can be marked as complete / deleted
	else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') handleDelete();
?>