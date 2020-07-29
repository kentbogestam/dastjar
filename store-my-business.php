<?php
/*  File Name  : viewStore.php
 *  Description : view Store Form
 *  Author      : Deo  Date: 20th,Dec,2010  Creation
 */
header('Content-Type: text/html; charset=utf-8');

require_once('cumbari.php');
require_once('vendor/autoload.php');
require_once('classes/inOut.php');
require_once 'MyBusiness.php';

if( isset($_GET['storeId']) )
{
	$storeId = $_GET['storeId'];
	$_SESSION['storeId'] = $storeId;
}
else
{
	$storeId = $_SESSION['storeId'];
}
// unset($_SESSION['access_token']);

$storeObj = new store();
$data = $storeObj->getStoreDetailById($storeId);

// 
if(isset($_SERVER['HTTPS']))
{
	$redirect_uri = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
}
else
{
	$redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
}

// 
$clientId = '511904643392-kd5h566kjh6phbf4k4d3pntvfduaq35n.apps.googleusercontent.com';
$clientSecret = 'r4FBNQxqIzZiSXKtk_D6JZCc';

$client = new Google_Client();
$client->setClientId($clientId);
$client->setClientSecret($clientSecret);
$client->setScopes(['https://www.googleapis.com/auth/plus.business.manage']);
$client->setRedirectUri($redirect_uri);

// Step 2: If we have a code back from the OAuth 2.0 flow
if( isset($_GET['code']) )
{
    $client->authenticate($_GET['code']);
	$_SESSION['access_token'] = $client->getAccessToken();
	header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

// Step 3: set the access token as part of the client
if( isset($_SESSION['access_token']) && $_SESSION['access_token'] )
{
	$client->setAccessToken($_SESSION['access_token']);
	
	if ($client->isAccessTokenExpired()) {
		unset($_SESSION['access_token']);
		header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
	}

	// 
	accountLocationCreate($client, $storeId);
}

// Create new business location
function accountLocationCreate($client, $storeId)
{
	$storeObj = new store();
	// $location = $service->accounts_locations->listAccountsLocations($parent);
	$storeBusinessLocation = $storeObj->getStoreBusinessLocation($storeId);

	if( empty($storeBusinessLocation) )
	{
		// $service->accounts_locations->delete($storeBusinessLocation['location_name']);
		// $storeObj->deleteStoreBusinessLocation($storeId);
		$data = $storeObj->getStoreDetailById($storeId);
		
		$service = new Google_Service_MyBusiness($client);
		$accounts = $service->accounts->listAccounts();

		if( isset($accounts['accounts']['0']['name']) )
		{
			$parent = $accounts['accounts']['0']['name'];

			$postBody = new Google_Service_Mybusiness_Location();
			$postBody->setLocationName($data[0]['store_name']);
			// $postBody->setStoreCode('URJA177');
			$postBody->setLanguageCode('en-GB');
			$postBody->setPrimaryPhone($data[0]['phone']);

			if( !empty($data[0]['store_link']) )
			{
				$postBody->setWebsiteUrl($data[0]['store_link']);
			}

			$primaryCategory = new Google_Service_Mybusiness_Category();
			$primaryCategory->setCategoryId("gcid:restaurant");
			$primaryCategory->setDisplayName($data[0]['store_name']);
			$postBody->setPrimaryCategory($primaryCategory);

			$latlng = new Google_Service_MyBusiness_LatLng();
			$latlng->setLatitude($data[0]['latitude']);
			$latlng->setLongitude($data[0]['longitude']);
			$postBody->setLatlng($latlng);

			$businessHours = new Google_Service_MyBusiness_BusinessHours();
			$timePeriods = array();
			$days = array("MONDAY", "TUESDAY", "WEDNESDAY", "THURSDAY", "FRIDAY", "SATURDAY", "SUNDAY");

			$openCloseList = explode(",",$data[0]['store_open_close_day_time']);
			foreach ($openCloseList as $key => $value)
			{
				$getDay = explode("::",$value);
      			$getDay[0] = str_replace(' ', '', $getDay[0]);
      			$getTime = explode("to",$getDay[1]);
		        $allDayOpen = date('H:i', strtotime($getTime[0]));
		        $allDayClose = date('H:i', strtotime($getTime[1]));

      			if($getDay[0] == 'All')
      			{
      				foreach ($days as $day)
					{
						$timePeriod = new Google_Service_Mybusiness_TimePeriod();
						$timePeriod->setOpenDay($day);
						$timePeriod->setOpenTime($allDayOpen);
						$timePeriod->setCloseTime($allDayClose);
						$timePeriod->setCloseDay($day);
						$timePeriods[] = $timePeriod;
					}
      			}
      			else
      			{
					if($getDay[0] == 'Mon'){
						$day = $days[0];
					}
					if($getDay[0] == 'Tue'){
						$day = $days[1];
					}
					if($getDay[0] == 'Wed'){
						$day = $days[2];
					}
					if($getDay[0] == 'Thu'){
						$day = $days[3];
					}
					if($getDay[0] == 'Fri'){
						$day = $days[4];
					}
					if($getDay[0] == 'Sat'){
						$day = $days[5];
					}
					if($getDay[0] == 'Sun'){
						$day = $days[6];
					}

					$timePeriod = new Google_Service_Mybusiness_TimePeriod();
					$timePeriod->setOpenDay($day);
					$timePeriod->setOpenTime($allDayOpen);
					$timePeriod->setCloseTime($allDayClose);
					$timePeriod->setCloseDay($day);
					$timePeriods[] = $timePeriod;
      			}
			}
			$businessHours->setPeriods($timePeriods);
			$postBody->setRegularHours($businessHours);

			$address = new Google_Service_MyBusiness_PostalAddress();
			$address->setAddressLines($data[0]['street']);
			$address->setLocality($data[0]['city']);
			$address->setAdministrativeArea("Haryana");
			$address->setLanguageCode("en");
			$address->setPostalCode($data[0]['zip']);
			$address->setRegionCode($data[0]['country_code']);
			$postBody->setAddress($address);

	        $requestId = uuid();
	        $optParams = array('validateOnly' => false, 'requestId' => $requestId);
	        
			try {
				$location = $service->accounts_locations->create($parent, $postBody, $optParams);
				$storeObj->createStoreBusinessLocation($storeId, $location->name);
				// echo json_encode($location);
			} catch (Exception $e) {
				print_r($e->__toString());
			}
		}
	}
}

// 
if($storeId)
{
	$storeObj = new store();
	$data = $storeObj->viewStoreDetailById($storeId);
}
else
{
	header("location:showStore.php");
}

include_once("main.php");
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<body>
	<style>
		input[readonly]{
			background-color:transparent;
			border: 0;
			font-size: 1em;
		}
	</style>
	<div class="center">
		<div id="msg" align="center" style="margin-top:20px;">
			<?php
			if ($_SESSION['MESSAGE']) {
				echo $_SESSION['MESSAGE'];
				$_SESSION['MESSAGE'] = "";
			}
			?>
		</div>
		<div id="container py-5">
			<div class="row">
				<div class="col-md-12">
					<h4>View Store Detail</h4>
				</div>
			</div>
			<div class="row">
		        <div class="col-md-12 mx-auto">
		            <form action="" method="post">
		                <div class="form-group row">
		                    <div class="col-sm-6">
		                        <label for="store_name">Location Name</label>
		                        <input type="text" class="form-control" id="store_name" value="<?php echo $data[0]['store_name']; ?>" readonly>
		                    </div>
		                    <div class="col-sm-6">
		                        <label for="phone">Restaurant phone</label>
		                        <input type="text" class="form-control" id="phone" value="<?php echo $data[0]['phone']; ?>" readonly>
		                    </div>
		                </div>
		                <div class="form-group row">
		                    <div class="col-sm-12">
		                        <label for="store_link">Restaurant homepage</label>
		                        <input type="text" class="form-control" id="store_link" value="<?php echo $data[0]['store_link']; ?>" readonly>
		                    </div>
		                </div>
		                <div class="form-group row">
		                    <div class="col-sm-6">
		                        <label for="latitude">Latitude</label>
		                        <input type="text" class="form-control" id="latitude" value="<?php echo $data[0]['latitude']; ?>" readonly>
		                    </div>
		                    <div class="col-sm-6">
		                        <label for="longitude">Longitude</label>
		                        <input type="text" class="form-control" id="longitude" value="<?php echo $data[0]['longitude']; ?>" readonly>
		                    </div>
		                </div>
		                <div class="form-group row">
		                    <div class="col-sm-6">
		                        <label for="street">Address Street</label>
		                        <input type="text" class="form-control" id="street" value="<?php echo $data[0]['street']; ?>" readonly>
		                    </div>
		                    <div class="col-sm-6">
		                        <label for="city">City</label>
		                        <input type="text" class="form-control" id="city" value="<?php echo $data[0]['city']; ?>" readonly>
		                    </div>
		                </div>
		                <div class="form-group row">
		                    <div class="col-sm-6">
		                        <label for="zip">Zip</label>
		                        <input type="text" class="form-control" id="zip" value="<?php echo $data[0]['zip']; ?>" readonly>
		                    </div>
		                    <div class="col-sm-6">
		                        <label for="country">Country</label>
		                        <input type="text" class="form-control" id="country" value="<?php echo $data[0]['country']; ?>" readonly>
		                    </div>
		                </div>
		                <?php
		                // Step 1: If we're signed in then
						if( !$client->getAccessToken() && !isset($_SESSION['access_token']) )
						{
							$authUrl = $client->createAuthUrl();
							?>
							<a href='<?php echo $authUrl; ?>' class='btn btn-primary btn-block px-4 float-right login'>Submit</a>
							<?php
						}
						else
						{
							?>
							<!-- <button type="submit" name="continue" id="continue" class="btn btn-primary btn-block px-4 float-right">Save</button> -->
							<?php
						}
		                ?>
		            </form>
		        </div>
		    </div>
		</div>
	</div>
	<br>
	<div><? include("footer.php"); ?></div>
</body>