 <?php
 /*  File Name : addCompany.php
 *  Description : Add Company Form
 *  Author  :Mayank Pathak  Date: 15rd,Aug,2018  Creation
*/

require_once("cumbari.php");
require_once('vendor/autoload.php');

class Billing{

 function createPlan(){

    $productName = $_POST['product_name'];
    $planNickname = $_POST['plan_nickname'];
    $price = $_POST['price'];
    $currency = $_POST['currency'];
    $description = $_POST['description'];
    $usageType = $_POST['usage_type'];

    \Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);
    // Creates a subscription plan. This can also be done through the Stripe dashboard.
    // You only need to create the plan once.

    $product = \Stripe\Product::create([
        'name' => $productName,
        'type' => 'service',
        'statement_descriptor' => $description
    ]);

    $productId = $product->id;

    $plan = \Stripe\Plan::create(array(
        "nickname" => $planNickname,
        "amount" => $price,
        "interval" => "month",
        "currency" => $currency,
        'product' => $productId,
        "usage_type" => $usageType         
    ));

    $planId = $plan->id;

    $db = new db();
    $db->makeConnection();

    $query = "insert into billing_products(product_id, product_name, plan_id, plan_nickname, currency, price, usage_type, description) values('$productId', '$productName', '$planId', '$planNickname', '$currency', '$price', '$usageType', '$description')";

    $res = $db->query($query);

    if($res){
        $_SESSION['MESSAGE'] = PRODUCT_SUCCESS;
        $url = BASE_URL . 'productSupport.php';
        $inoutObj = new inOut();
        $inoutObj->reDirect($url);
        exit();
    }

    exit();
   }

   function updatePlan(){
        $editId = $_POST['edit_id'];
        $productId = $_POST['product_id'];
        $planId = $_POST['plan_id'];

        $productName = $_POST['product_name'];
        $planNickname = $_POST['plan_nickname'];
        $price = $_POST['price'];
        $currency = $_POST['currency'];
        $description = $_POST['description'];
        $usageType = $_POST['usage_type'];

        \Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);
        // Creates a subscription plan. This can also be done through the Stripe dashboard.
        // You only need to create the plan once.

        $product = \Stripe\Product::retrieve($productId);
        $product->name = $productName;
        $product->statement_descriptor = $description;
        $product->save();  

        $plan = \Stripe\Plan::retrieve($planId);
        $plan->nickname = $planNickname;
        $plan->save();

        $db = new db();
        $db->makeConnection();

        $query = "update billing_products set product_name='$productName', plan_nickname='$planNickname', currency='$currency', price='$price', usage_type='$usageType', description='$description' where id='$editId'";

        $res = $db->query($query);

        if($res){
            $_SESSION['MESSAGE'] = PRODUCT_SUCCESS;
            $url = BASE_URL . 'productSupport.php';
            $inoutObj = new inOut();
            $inoutObj->reDirect($url);
            exit();
        }

        exit();
   }

   function showPlan(){
        $db = new db();
        $db->makeConnection();

        $query = "select * from billing_products where s_activ<>2";
        $res = $db->query($query);


        return $res;
   }

   function getTotalProduct($uId) {
        $db = new db();
        $db->makeConnection();
        $data = array();

        $query = "SELECT COUNT(*) FROM billing_products";

        $total_records = $db->query($query);

        return $total_records;
    }

    function getBillingProduct($editId){
        $db = new db();
        $db->makeConnection();
        $data = array();

        $query = "SELECT * FROM billing_products where id=$editId limit 1";

        $res = $db->query($query);

        while ($rs = mysqli_fetch_array($res)) {
            $data[] = $rs;
        }

        return $data;  
    }

    function deletePlan($id){
        $db = new db();
        $db->makeConnection();
        $data = array();

        $query = "SELECT * FROM billing_products where id=$id limit 1";
        $res = $db->query($query);

        while ($rs = mysqli_fetch_array($res)) {
            $data[] = $rs;
        }

        $productId = $data[0]['product_id'];
        $planId = $data[0]['plan_id'];


        \Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);

        $plan = \Stripe\Plan::retrieve($planId);
        $plan->delete();

        $product = \Stripe\Product::retrieve($productId);
        $product->delete();

        $query = "update billing_products set s_activ=2 where id=$id";
        $res = $db->query($query);

        if($res){
            $_SESSION['MESSAGE'] = "You have successfully deleted your Product.";
            $url = BASE_URL . 'productSupport.php';
            $inoutObj = new inOut();
            $inoutObj->reDirect($url);
            exit();
        }
    }

    function subscribe(){
        $db = new db();
        $db->makeConnection();
        $data = array();

        $planIds = $_POST['plan_id'];

        $plans = [];
        $user_plans = "";

        $q = "select plan_id,product_name from billing_products where product_name='Anar Base Package'";
        $res = $db->query($q);

        while ($rs = mysqli_fetch_array($res)) {
            $data[] = $rs;
        }

        $firstPlanId = $data[0][0];
        $firstPlanName = $data[0][0];

        $planIds[$firstPlanId] = $firstPlanName;

        foreach ($planIds as $key => $value) {
            $plans[] = ["plan" => $value];
            $user_plans .= "('".$_SESSION['userid']."','". $value."')";
            if(count($planIds) != ($key+1)){
                $user_plans .= ",";                
            }
        }

        $uId = $_SESSION['userid'];

        $customer = "select email from user where u_id='$uId'";
        $res = $db->query($customer);

        while ($rs = mysqli_fetch_array($res)) {
            $data[] = $rs;
        }

        $emailId = $data[0][0];

        \Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);

            $token = $_POST['stripeToken'];
     
            // print_r($customerId);
            // die();

            // Create a Customer
            $customer = \Stripe\Customer::create(array(
                "email" => $emailId,
                "source" => $token                
            ));

            $customerId = $customer->id;

            $query = "UPDATE user SET stripe_customer_id='$customerId' where  u_id='" . $uid[1] . "'";

            $subscription = \Stripe\Subscription::create(array(
                "customer" => $customerId,
                "items" => $plans
            ));            

        $query = "insert into user_plan(user_id, plan_id) values$user_plans";
        $res = $db->query($query);

        if($res){
            $_SESSION['active_state'] = 5;            
            $_SESSION['MESSAGE'] = "You have successfully subscribed.";
            $url = BASE_URL . 'showStandard.php';
            $inoutObj = new inOut();
            $inoutObj->reDirect($url);
            exit();
        }
    }

    function getTotalDeletedProduct($id){
        $db = new db();
        $db->makeConnection();
        $data = array();

        $query = "SELECT COUNT(*) FROM billing_products where s_activ=2";

        $total_records = $db->query($query);

        return $total_records;
    }

    function showDeletedPlan(){
        $db = new db();
        $db->makeConnection();

        $query = "select * from billing_products where s_activ=2";
        $res = $db->query($query);

        return $res;
   }

   function viewBillingProduct($id){
        $db = new db();
        $db->makeConnection();

        $query = "select * from billing_products where id=$id";
        $res = $db->query($query);

        while ($rs = mysqli_fetch_array($res)) {
            $data[] = $rs;
        }
        
        return $data;
   }

}
?>