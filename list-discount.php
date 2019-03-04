<?php
/**
 * File Name 	: list-discount.php
 * Description 	: Show list of discounts created for specific store
 * Author      	: Ajit Singh
 * Date        	: Feb 27, 2019 
 */
header('Content-Type: text/html; charset=utf-8');
include("cumbari.php");

$menu = "account";
$$menu = 'class="selected"';
$is_discount_show = 'checked="checked"';

include("main.php");
include("Paging.php");

// echo '<pre>'; print_r($_SESSION); exit;

if ($_SESSION['userid']) {
	$discount = new discount();

	if(isset($_REQUEST['action']) && isset($_REQUEST['id']) && $_REQUEST['action'] == 'deleteDiscount' && is_numeric($_REQUEST['id']))
	{
		$discount->deleteDiscount($_REQUEST['id']);
	}
	else
	{
		//
		$records_per_page = PAGING;
		$_SESSION["storeDetail"] = $discount;
		$total_records = $discount->getTotalRecord();
		// $total_records = 0;

		$pager = new pager($total_records, $records_per_page, @$_GET['_p']);
		$paging_limit = $pager->get_limit();
		$data = $discount->getDiscountList($paging_limit);
		// echo '<pre>'; print_r($data); exit;
	}
} else {
	$_SESSION['MESSAGE'] = "Please Login";
	header("location:login.php");
}
?>
<!-- <link href="lib/grid/css/grid.css" rel="stylesheet" type="text/css" />
<link href="client/css/stylesheet123.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="lib/grid/js/grid.js" type="text/javascript"></script> -->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="//momentjs.com/downloads/moment-with-locales.min.js"></script>
<body>
	<div class="center">
		<div id="msg" align="center" style="margin-top:20px;">
			<?php
			if ($_SESSION['MESSAGE']) {
				echo $_SESSION['MESSAGE'];
				$_SESSION['MESSAGE'] = "";
			}
			?>
		</div>
		<div id="container">
			<div class="row">
				<div class="col-md-12">
					<h1>List Discount</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-right">
					<a href="add-discount.php" title="Add Discount" class="btn btn-link	">Add Discount</a>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<table class="table table-bordered">
							<tr>
								<th width="30%">Store</th>
								<th width="15%">Discount Code</th>
								<th width="15%">Discount Value</th>
								<th width="15%">Start Date</th>
								<th width="15%">End Date</th>
								<th width="10%" class="text-center">Action</th>
							</tr>
							<?php
							if( !empty($data) )
							{
								foreach($data as $row)
								{
									?>
									<tr>
										<td><?php echo $row['store_name']; ?></td>
										<td><?php echo $row['code']; ?></td>
										<td><?php echo $row['discount_value']; ?></td>
										<!-- <td><?php echo $row['start_date']; ?></td> -->
										<td><?php echo "<script type='text/javascript'>document.write(moment.utc('{$row['start_date']}').local().format('YYYY/MM/DD HH:mm'))</script>" ?></td>
										<td><?php echo "<script type='text/javascript'>document.write(moment.utc('{$row['end_date']}').local().format('YYYY/MM/DD HH:mm'))</script>" ?></td>
										<td align="center">
											<a href="edit-discount.php?id=<?php echo $row['id']; ?>" title="Edit Discount"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> 
											<a href="javascript:deleteDiscount(<?php echo $row['id']; ?>)" title="Delete Discount"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
										</td>
									</tr>
									<?php
								}
							}
							else
							{
								?>
								<tr>
									<td colspan='5' align="center">No record found.</td>
								</tr>
								<?php
							}
							?>
						</table>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div><? include("footer.php"); ?></div>
</body>

<script>
	// Delete discount
	function deleteDiscount(id)
	{
		if( confirm('Are you sure you want to delete this discount?') )
		{
			var url = 'list-discount.php?action=deleteDiscount&id='+id;
			window.location = url;
		}
	}
</script>