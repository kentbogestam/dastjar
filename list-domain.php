<?php
include_once("cumbari.php");

// print_r($_SESSION); exit;

if ($_SESSION['userid']) {
	$obj = new domain();

	// Remote check if discount code is not already exist
	if( isset($_POST['isRemoteCheck']) )
	{
	    $obj->remoteCheck(); exit;
	}

	if(isset($_REQUEST['action']))
	{
		if( isset($_REQUEST['id']) && $_REQUEST['action'] == 'delete' && is_numeric($_REQUEST['id']) )
		{
			$obj->delete($_REQUEST['id']);
		}
		elseif( $_REQUEST['action'] == 'create' )
		{
			$obj->create($_REQUEST);
		}
	}
	else
	{
		$data = $obj->getDomainList();
	}
} else {
	$_SESSION['MESSAGE'] = "Please Login";
	header("location:login.php");
	exit();
}
$menu = "domain";
$domain = 'class="selected"';
include("main.php");
?>
<body class="center">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<div class="container">
	<br>
	<?php
	if ($_SESSION['MESSAGE']) {
		?>
		<div class="alert alert-secondary" role="alert"><?php echo $_SESSION['MESSAGE']; ?></div>
		<?php
		unset($_SESSION['MESSAGE']);
	}
	?>
	<div class="row">
		<div class="col-md-10"><h2>Domain</h2></div>
		<!-- <div class="col-md-2 text-right"><a href="add-domain.php" class="btn btn-primary">Add Domain</a></div> -->
		<div class="col-md-2 text-right"><button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add Domain</button></div>
	</div>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Domain name</th>
				<th>Brand name</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if( !empty($data) )
			{
				foreach($data as $row)
				{
					?>
					<tr>
						<td><?php echo $row['domain']; ?></td>
						<td><?php echo $row['brandname']; ?></td>
						<td><?php echo ($row['status'] == '1') ? 'Active' : 'In-active'; ?></td>
						<td>
							<!-- <a href="edit-domain.php?<?php echo $row['id']; ?>" class="btn"><i class="fa fa-pencil-square-o"></i></a> -->
							<button class="btn"><i class="fa fa-trash-o" onclick="javascript:deleteRecord(<?php echo $row['id']; ?>)"></i></button>
						</td>
					</tr>
					<?php
				}
			}
			else
			{
				?>
				<tr class="text-center">
					<td colspan="4">No record found</td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>

	<!-- The Add Modal -->
	<div class="modal" id="addModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<form name="add" method="POST" id="add">
					<div class="modal-header">
						<h4 class="modal-title">Add Domain</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="domain">Domain</label>
								<input type="text" name="domain" class="form-control" id="domain" placeholder="test.example.com">
							</div>
							<div class="form-group col-md-6">
								<label for="brandname">Brand name</label>
								<input type="text" name="brandname" class="form-control" id="brandname">
							</div>
						</div>
						<div class="form-group">
							<label for="introheading">Intro heading</label>
							<input type="text" name="introheading" class="form-control" id="introheading">
						</div>
						<div class="form-group">
							<label for="introduction">Introduction</label>
							<input type="text" name="introduction" class="form-control" id="introduction">
						</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" name="action" value="create">
						<button type="submit" class="btn btn-primary">Save</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
        // Form validation
        $("#add").validate({
            rules: {
                domain: {
                    required: true,
                    remote: {
                        url: 'list-domain.php',
                        type: 'post',
                        data: {
                            isRemoteCheck: 1,
                            domain: function() {
                                return $("#domain").val();
                            }
                        }
                    }
                }
            },
            messages: {
                domain: {
                    remote: 'This domain is already added.'
                }
            }
        });
    });

    <?php
     // Call .sh script on homes server to create subdomain on AWS if created new domain
     if( isset($_SESSION['domain']) )
     {
        $data = array('u_id' => $_SESSION['userid'], 'domain' => $_SESSION['domain']);
        $url = HOMES_BASE_URL."config/create-domain";
        unset($_SESSION['domain']);
        ?>

        // 
        var data = <?php echo json_encode($data); ?>;

        $.ajax({
           type: 'GET',
           url: "<?php echo $url; ?>",
           data: data,
           success: function(response) {

           }
        });
        <?php
     }
     ?>

	// Delete discount
	function deleteRecord(id)
	{
		if( confirm('Are you sure you want to delete this?') )
		{
			var url = 'list-domain.php?action=delete&id='+id;
			window.location = url;
		}
	}
</script>
</body>
