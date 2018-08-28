/*  File Name : addCompany.php
 *  Description : Add Company Form
 *  Author :Mayank  Date: 12th,Nov,2010  Creation
 */
$(document).ready(function(){
    $("#continue1").click(function(){
        $("#error_dishName").html('');
        checkDishTypeExist();
    });
});



/* Function Header :checkDishTypeExist()
*             Args: none
*           Errors: none
*     Return Value: none
*      Description:To check whether the email_id exist or not
*/


function checkDishTypeExist()
{
    if($("#dishName").val().length<1)
    {
        var errorMsg = "Please Enter Dish Type.<br />";
        $("#error_dishName").html(errorMsg);
    }else{
        $.post('classes/ajx/ajxCommon.php',{
            dish_type:$("#dishName").val(),
            lang:$("#lang").val(),
            m:"existdishtype"
        },
        function(data){
            if(data>0)
            {
                var errorMsg = "This dish type already exists.<br />";
                $("#error_dishName").html(errorMsg);
            }
            else
            {
                var errorMsg = "Available.<br />";
                $("#error_dishName").html(errorMsg);
                $("#registerform").submit();
            }
        }
        );
    }
}