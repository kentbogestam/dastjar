<?php
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");

$loyaltyObj = new loyalty();

// Remote check if loyalty code is not already exist
/*if( isset($_POST['isRemoteCheck']) )
{
    $loyaltyObj->remoteCheckDiscount(); exit;
}*/

// Create loyalty form submit
if ( isset($_POST) && !empty($_POST) ) {
    $loyaltyObj->create();
}

// Get all stores for logged-in user
if( isset($_SESSION['userid']) )
{
    // Get stores
    $storeObj = new store();
    $stores = $storeObj->getStoreDetail($_SESSION['userid']);

    // Get offer
    $offerObj = new offer();
    $listDishes = $offerObj->listDishes();
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
                <td class="redwhitebutton">Add Loyalty</td>
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
                <form name="frm-create" method="POST" id="frm-create">
                    <div class="form-group">
                        <label for="store_id">Select Store <span class='mandatory'>*</span>:</label>
                        <select name="store_id" class="form-control" id="store_id" data-rule-required="true">
                            <option value="">Select</option>
                            <?php
                            if( !empty($stores) )
                            {
                                foreach($stores as $row)
                                {
                                    echo "<option value='{$row['store_id']}'>{$row['store_name']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dish_type_id">Dish Type <span class='mandatory'>*</span>:</label>
                        <select multiple name="dish_type_id[]" class="form-control" id="dish_type_id" data-rule-required="true">
                            <option value="">Select</option>
                            <?php
                            if( !empty($listDishes) )
                            {
                                foreach($listDishes as $row)
                                {
                                    echo "<option value='{$row['dish_id']}'>{$row['dish_name']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity_to_buy">Quantity to Buy <span class='mandatory'>*</span>:</label>
                        <input type="number" name="quantity_to_buy" placeholder="Enter quantity to buy" class="form-control" id="quantity_to_buy" data-rule-required="true">
                    </div>
                    <div class="form-group">
                        <label for="quantity_get">Quantity Get <span class='mandatory'>*</span>:</label>
                        <input type="number" name="quantity_get" placeholder="Enter quantity to get" class="form-control" id="quantity_get" data-rule-required="true">
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="start_date">Start Date <span class='mandatory'>*</span>:</label>
                                <input type="text" name="start_date" placeholder="Enter start date" class="form-control" id="start_date" data-rule-required="true">
                                <input type="hidden" name="start_date_utc" id="start_date_utc">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="end_date">End Date <span class='mandatory'>*</span>:</label>
                                <input type="text" name="end_date" placeholder="Enter end date" class="form-control" id="end_date" data-rule-required="true">
                                <input type="hidden" name="end_date_utc" id="end_date_utc">
                            </div>
                        </div>
                    </div>
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
        $("#frm-create").validate();

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