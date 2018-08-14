function changeStatus(id,type)
{
    var url ='category_action.php?action=status&id='+id+'&type='+type;
    window.location = url;
}

function delete_record(id)
{
    if(confirm('Are you sure you want to delete this record?')) {
        var url ='showStore.php?m=deleteStore&'+id;
        window.location = url;
    }
}

function delete_record_dish(id)
{
    if(confirm('Are you sure you want to delete this record?')) {
        var url ='showDishes.php?m=deleteDish&'+id;
        window.location = url;
    }
}

function delete_recd(id)
{
    if(confirm('Are you sure you want to delete this record?')) {
        var url ='showCampaign.php?m=deleteOutdatedCampaign&'+id;
        window.location = url;
    }
}

function delete_rec(id,reseller)
{      
    if(confirm('Are you sure you want to delete this record?')) {
        var url ='showCampaign.php?m=deleteCampaign&'+id+'&'+reseller;
        window.location = url;
    }
}



function delete_advertise(id)
{
    if(confirm('Are you sure you want to delete this record?')) {
        var url ='showAdvertise.php?m=deleteOutdatedAdvertise&'+id;
        window.location = url;
    }
}

function delete_advertise_reseller(id,reseller)
{      
    if(confirm('Are you sure you want to delete this record?')) {
        var url ='showAdvertise.php?m=deleteAdvertise&'+id+'&'+reseller;
        window.location = url;
    }
}

function delete_standard(id,reseller)
{
    if(confirm('Are you sure you want to delete this record?')) {
        var url ='showStandard.php?m=deleteStandardOffer&'+id+'&'+reseller;
        //alert(url);exit;
        window.location = url;
    }
}

function checkall(objForm)
{
    var ele,len,i;
    ele= document.getElementsByTagName("input");
    len=ele.length;
    for(i=0;i<len;i++){
    if(ele[i].type=='checkbox'){
        ele[i].checked=objForm;
        }
    }

}

function confirm_msg()
{
    if(confirm('Are you sure you want to perform this action?')) {
        document.myform.submit();
        return true;
    } else {
        return false;
    }
}
function delete_newUser(id)
{
    if(confirm('Are you sure you want to delete this record?')) {
        var url ='viewNewUser.php?m=deleteNewUser&'+id;
        window.location = url;
    }
}

function askForStore(offerId){

  {
    if(confirm('Do you want to add location now for this Campaign?')) {
        var url ='addStore.php?campaignId='+offerId;
        window.location = url;
    }
}
}


function askForAdvertiseStore(advtId){
    if(confirm('Do you want to add location now for this Advertise?')) {
        var url ='addAdvertiseStore.php?advertiseId='+advtId;
        window.location = url;
    }

}

//function askCreateStore(){
//
//  {
//    if(confirm('You dont have any location do you want to add?')) {
//        var url ='newCreateStore.php';
//        window.location = url;
//    }
//}
//}

function askForStoreStand(standId){

  {
    if(confirm('Do you want to add location now for this Product?')) {
        var url ='addStandStore.php?productId='+standId;
        window.location = url;
    }
}
}

function deleteBrand_rec(id){
   // alert(1);

  {
    if(confirm('Are you sure you want to delete this record?')) {
        var url ='getBrandView.php?m=deleteBrand&'+id;
        window.location = url;
    }
}
}
function displayHelpInfo(id){
     //alert(id);
    if(id!=0){
         alert( "You have already registered a brand");
         return false;
        }
		return true;
       
}