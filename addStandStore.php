<?php
header('Content-Type: text/html; charset=utf-8');
include_once("cumbari.php");
$menu = "standard";
$standard = 'class="selected"';
$show = 'class="selected"';
//echo $_SESSION['userid'];
//exit;
include("main.php");
$regObj = new registration();
$storeObj = new store();

//$regObj->isValidRegistrationStep();
$offerObj = new offer();
  
$productid = $_GET['productId']; //die();
 $data = $offerObj->viewStandardDetailById($productid);
// Total Location
$stores = $storeObj->totalStoreDetails();
if (isset($_POST['continue'])) {
    $offerObj->saveNewCouponStandardDetails();
}
include_once("header.php");
?>
<?php include 'config/defines.php'; ?>

<script language="JavaScript" src="client/js/ajaxuploadStand.js" type="text/javascript"></script>

    <link href="//stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet"
    href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/css/bootstrap-material-design.min.css"/>
    <link rel="stylesheet"
    href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/css/ripples.min.css"/>
    <link rel="stylesheet" href="client/css/bootstrap-material-datetimepicker.css" />
    <link href='//fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


<style type="text/css">

    a { }
    img { border: 0 }.center{width:900px; margin-left:auto; margin-right:auto;}
	
		.dtp > .dtp-content > .dtp-date-view > header.dtp-header{
		    background: #821015;
		}

		.dtp div.dtp-date, .dtp div.dtp-time {
    		background: #a72626;
		}

        body{
            background-color: #fff; 
        }
</style>
<script language="JavaScript" src="client/js/jsAddStandCoupon.js" type="text/javascript"></script>
<body>
<div class="center">
<div>
    <div id="preview_frame"></div>
</div>
<form name="register" action="" id="registerform" method="Post" enctype="multipart/form-data">
<input type="hidden" name="preview" value="1">
<input type="hidden" name="m" value="saveNewCouponStandard">
<input type="hidden" name="productId" value="<?=$_GET['productId']; ?>">
<div id="msg" align="center">
    <?php
    if ($_SESSION['MESSAGE']) {
        echo $_SESSION['MESSAGE'];
        $_SESSION['MESSAGE'] = "";
    }
    ?>
</div>
<div class="redwhitebutton_small123" style="margin-top:20px; margin-bottom:5px;">Add the Offer <?=$data[0]['product_name']?> to a Location</div>
<table width="100%" border="0" cellspacing="15">
<div align="right"  >
    <a href="newCreateStore.php?productId=<?=$productid?>" >ADD LOCATION</a>
</div>
		<tr>
		  <td width="50%" align="left" >Select Location<span class='mandatory'>*</span>:</td>
<td align="left" ><div align="center" class="normalfont">
        

                    <select style="background-color:#e4e3dd; width:406px; border: 1px solid #99999b;" class="text_field_new" name="selectStore" id="selectStore">
                         <option <? if ($stores1['store_name'] == ''

            )echo "selected='selected'"; ?> value="">Select Location</option>
                        <?php foreach ($stores as $stores1) {
                              ?>
                            <option  value="<?=$stores1['store_id'] ?>"><? echo $stores1['store_name']; ?></option>
						<? } ?>
                    </select>
                    <div id='error_selectStore' class="error123"></div>
    </div></td>
	  </tr>
		<tr>
		  <td width="50%" align="left">Price<span class='mandatory'>*</span>:</td>
		  <td align="left"><div align="center" class="normalfont" >
    
        <input class="text_field_new" type="text" name="price" id="price" value="">
         <div id='error_price' class="error123"></div>

</div></td>
		</tr>

        <tr>
            <td width="50%" align="left">Publishing Start Date<span class='mandatory'>*</span>:</td>
            <td align="left"><div align="center" class="normalfont" >
        
            <input class="dp-applied text_field_new" type="text" name="" id="publishing_start_date" value="<?php echo date('d/m/Y 00:00'); ?>" required>
            <input type="hidden" id="date-start-utc" name="publishing_start_date" value="">

            <div id='error_price' class="error123"></div>

            </div></td>
        </tr>

        <tr>
            <td width="50%" align="left">Publishing End Date<span class='mandatory'>*</span>:</td>
            <td align="left"><div align="center" class="normalfont" >
        
            <input class="text_field_new" type="text" name="" id="publishing_end_date" value="<?php echo date('d/m/Y 23:59'); ?>" required>
            <input type="hidden" id="date-end-utc" name="publishing_end_date" value="">

             <div id='error_price' class="error123"></div>

            </div></td>
        </tr>

</table>




  <div align="center"><br />
<br />

            <INPUT  style="margin-left:115px;"type="submit" value="Submit" name="continue" id="continue" class="button" ><br />
<br />

        </div>

 <span class='mandatory'>* These Fields Are Mandatory</span>
</form>
</div>
    <? include("footer.php"); ?>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/ripples.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/material.min.js"></script>
<script type="text/javascript" src="//rawgit.com/FezVrasta/bootstrap-material-design/master/dist/js/material.min.js"></script>
<script type="text/javascript" src="//momentjs.com/downloads/moment-with-locales.min.js"></script>
<script type="text/javascript" src="client/js/bootstrap-material-datetimepicker.js"></script>

<script type="text/javascript">

                dStart = "<?php echo date('Y-m-d 00:00:00'); ?>";  
                dStart = moment(dStart).toDate();
                dStart = moment.utc(dStart).format("DD/MM/YYYY HH:mm");
                $('#date-start-utc').val(dStart);

                dEnd = "<?php echo date('Y-m-d 23:59:00'); ?>";
                dEnd = moment(dEnd).toDate();
                dKEnd = moment(dEnd).local().format("YYYY-MM-DD HH:mm");                                    
                dEnd = moment.utc(dEnd).format("DD/MM/YYYY HH:mm");
                $('#date-end-utc').val(dEnd);

        $(document).ready(function(){

            var dateToday = new Date();

            $('#publishing_start_date').bootstrapMaterialDatePicker
            ({
                weekStart: 0, format: 'DD/MM/YYYY HH:mm', minDate: dateToday, clearButton: true
            }).on('change', function(e, date)
            {
                if(new Date(date)>new Date(dKEnd)){
                    alert("Publishing start date must be smaller than publishing end date");
                    $('#publishing_start_date').val("<?php echo date('d/m/Y 00:00'); ?>");
                    return false;
                }
                $('#publishing_end_date').bootstrapMaterialDatePicker('setMinDate', date);
                $('#date-start-utc').val(moment.utc(date).format('DD/MM/YYYY HH:mm'));
            });

            $('#publishing_end_date').bootstrapMaterialDatePicker
            ({
                weekStart: 0, format: 'DD/MM/YYYY HH:mm', minDate: dateToday, clearButton: true
            }).on('change', function(e, date)
            {
                dKEnd = date;
                $('#publishing_start_date').bootstrapMaterialDatePicker('setMaxDate', date);
                $('#date-end-utc').val(moment.utc(date).format('DD/MM/YYYY HH:mm'));
            });

            $.material.init();
        });
</script>
</body>
</html>