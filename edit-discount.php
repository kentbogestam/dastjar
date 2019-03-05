<?php
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");

// Redirect if ID not exist
if( isset($_GET['id']) && is_numeric($_GET['id']) )
{
    $id = $_GET['id'];
}

// Get discount by ID
$discountObj = new discount();

// Get discount
$discount = $discountObj->getDiscountById($id);

if( empty($discount) || !is_array($discount) )
{
    header('Location: list-discount.php');
    exit();
}

// Update discount
if ( isset($_POST) && !empty($_POST) ) {
    $discountObj->updateDiscount($id);
}

// Get all stores for logged-in user
if( isset($_SESSION['userid']) )
{
    $storeObj = new store();
    $stores = $storeObj->getStoreDetail($_SESSION['userid']);
}

// Remote check if discount code not already exist
if( isset($_POST['code']) && !empty($_POST['code']) )
{
    echo 0; exit;
}

$menu = "account";
$$menu = 'class="selected"';
// $is_discount_show = 'checked="checked"';

include_once("main.php");
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<!-- Start material datetimepicker CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/css/bootstrap-material-design.min.css"/>
<link rel="stylesheet" href="client/css/bootstrap-material-datetimepicker.css" />
<link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!-- End -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<!-- Start material datetimepicker JS -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/material.min.js"></script>
<script type="text/javascript" src="//momentjs.com/downloads/moment-with-locales.min.js"></script>
<script type="text/javascript" src="client/js/bootstrap-material-datetimepicker.js"></script>
<!-- End -->
<!-- Start validation JS -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<!-- End -->
<style>
body{
    background-color: #fff; 
}

label.error {
    color: red !important;
}

button.btn {
    background-color: #EBEBEB !important;
}
</style>
<body>
    <div class="center">
        <table width="100%"  border="0">
            <tr>
                <td class="redwhitebutton">Edit Discount</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </table>
        <div id="msg" align="center" style="margin-top:20px;">
            <?php
            if ($_SESSION['MESSAGE']) {
                echo $_SESSION['MESSAGE'];
                $_SESSION['MESSAGE'] = "";
            }
            ?>
        </div>
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <form name="frm-discount" method="POST" id="frm-discount">
                    <div class="form-group">
                        <label for="store_id">Select Store <span class='mandatory'>*</span>:</label>
                        <select name="store_id" class="form-control" id="store_id" data-rule-required="true">
                            <option value="">Select</option>
                            <?php
                            if( !empty($stores) )
                            {
                                foreach($stores as $row)
                                {
                                    $is_selected = ($discount['store_id'] == $row['store_id']) ? "selected" : '';
                                    
                                    echo "<option value='{$row['store_id']}'{$is_selected}>{$row['store_name']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="code">Discount Code <span class='mandatory'>*</span>:</label>
                        <input type="text" name="code" value="<?php echo $discount['code']; ?>" placeholder="Enter discount code" readonly class="form-control" id="code">
                    </div>
                    <div class="form-group">
                        <label for="discount_value">Discount Value <span class='mandatory'>*</span>:</label>
                        <input type="number" name="discount_value" value="<?php echo $discount['discount_value']; ?>" placeholder="Enter discount value in %" class="form-control" id="discount_value" data-rule-required="true">
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="start_date">Start Date <span class='mandatory'>*</span>:</label>
                                <input type="text" name="start_date" placeholder="Enter coupon start date" class="form-control" id="start_date" data-rule-required="true">
                                <input type="hidden" name="start_date_utc" id="start_date_utc">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="end_date">End Date <span class='mandatory'>*</span>:</label>
                                <input type="text" name="end_date" placeholder="Enter coupon end date" class="form-control" id="end_date" data-rule-required="true">
                                <input type="hidden" name="end_date_utc" id="end_date_utc">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>" id="id">
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div><? include("footer.php"); ?></div>
</body>

<script>
    $(document).ready(function() {
        // Form validation
        $("#frm-discount").validate();

        // 
        var startDate = "<?php echo $discount['start_date'] ?>";
        var endDate = "<?php echo $discount['end_date'] ?>";

        $('#start_date').val(moment.utc(startDate).local().format('DD/MM/YYYY HH:mm'));
        $('#start_date_utc').val(moment.utc(startDate).format('YYYY/MM/DD HH:mm'));
        $('#end_date').val(moment.utc(endDate).local().format('DD/MM/YYYY HH:mm'));
        $('#end_date_utc').val(moment.utc(endDate).format('YYYY/MM/DD HH:mm'));

        // Initialize start/end datetimepicker
        $('#start_date').bootstrapMaterialDatePicker
        ({
            weekStart: 0,
            format: 'DD/MM/YYYY HH:mm',
            clearButton: true
        }).on('change', function(e, date) {
            $('#start_date_utc').val(moment.utc(date).format('YYYY/MM/DD HH:mm'));
            $('#end_date').bootstrapMaterialDatePicker('setMinDate', date);
        });

        $('#end_date').bootstrapMaterialDatePicker
        ({
            weekStart: 0,
            format: 'DD/MM/YYYY HH:mm',
            clearButton: true
        }).on('change', function(e, date) {
            $('#end_date_utc').val(moment.utc(date).format('YYYY/MM/DD HH:mm'));
        });

        // Initialize material
        $.material.init();
    });
</script>