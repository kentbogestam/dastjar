 <?php
 /*  File Name : addCompany.php
 *  Description : Add Company Form
 *  Author  :Mayank Pathak  Date: 15rd,Aug,2018  Creation
*/

require_once("cumbari.php");
require_once('vendor/autoload.php');
require_once("classes/inOut.php");

class Billing{

 function createPlan(){
    $package_id = $_POST['package_id'];
    $productName = $_POST['product_name'];
    $planNickname = $_POST['plan_nickname'];
    $price = trim($_POST['price']);
    $trialPeriod = is_numeric($_POST['trial_period']) ? $_POST['trial_period'] : 0;
    $currency = $_POST['currency'];
    $description = $_POST['description'];
    $usageType = $_POST['usage_type'];

    \Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);
    // Creates a subscription plan. This can also be done through the Stripe dashboard.
    // You only need to create the plan once.

    $product = \Stripe\Product::create([
        'name' => $productName,
        'type' => 'service',
        'statement_descriptor' => $planNickname
    ]);

    $productId = $product->id;

    $plan = \Stripe\Plan::create(array(
        "nickname" => $planNickname,
        "amount" => ($price*100),
        "trial_period_days" => $trialPeriod,
        "interval" => "month",
        "currency" => $currency,
        'product' => $productId,
        "usage_type" => $usageType         
    ));

    $planId = $plan->id;

    $db = new db();
    $db->makeConnection();
    $time = time();
    $date = date("Y-m-d h:i:s",$time);

    $query = "insert into billing_products(package_id, product_id, product_name, plan_id, plan_nickname, currency, price, trial_period, usage_type, description, created_at, updated_at, s_activ) values('$package_id', '$productId', '$productName', '$planId', '$planNickname', '$currency', '$price', '$trialPeriod', '$usageType', '$description', '$date', '$date', 1)";

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
        $package_id = !empty($_POST['package_id']) ? $_POST['package_id'] : 'NULL';
        $productId = $_POST['product_id'];
        $planId = $_POST['plan_id'];

        $productName = $_POST['product_name'];
        $planNickname = $_POST['plan_nickname'];
        $price = trim($_POST['price']);
        $trialPeriod = is_numeric($_POST['trial_period']) ? $_POST['trial_period'] : 0;
        $currency = $_POST['currency'];
        $description = $_POST['description'];
        $usageType = $_POST['usage_type'];

        \Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);
        // Creates a subscription plan. This can also be done through the Stripe dashboard.
        // You only need to create the plan once.

        $product = \Stripe\Product::retrieve($productId);
        $product->name = $productName;
        $product->statement_descriptor = $planNickname;
        $product->save();  

        $plan = \Stripe\Plan::retrieve($planId);
        $plan->nickname = $planNickname;
        $plan->trial_period_days = $trialPeriod;
        $plan->save();

        $db = new db();
        $db->makeConnection();

        $query = "update billing_products set package_id=$package_id, product_name='$productName', plan_nickname='$planNickname', trial_period='$trialPeriod', usage_type='$usageType', description='$description' where id='$editId'";

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

    // Get static plan
    function getStaticPackages()
    {
        $db = new db();
        $db->makeConnection();
        $data = array();

        $query = "SELECT id, title FROM anar_packages AP WHERE status = '1'";
        $res = $db->query($query);

        while ($rs = mysqli_fetch_array($res)) {
            $data[] = $rs;
        }

        return $data;
    }

    function showPlanToSubscribe()
    {
        $db = new db();
        $db->makeConnection();
        $data = array();

        // $query = "SELECT BP.id, BP.package_id, BP.product_id, BP.product_name, BP.plan_id, BP.plan_nickname, BP.currency, BP.price, BP.description FROM billing_products AS BP INNER JOIN anar_packages AS AP ON AP.id = BP.package_id WHERE BP.s_activ != 2 AND AP.status = '1' ORDER BY AP.id";
        $query = "SELECT bp1.id, bp1.package_id, bp1.product_id, bp1.product_name, bp1.plan_id, bp1.plan_nickname, bp1.currency, bp1.price, bp1.description FROM billing_products bp1 LEFT JOIN billing_products bp2 ON (bp1.package_id = bp2.package_id AND bp1.id < bp2.id) INNER JOIN anar_packages AP ON AP.id = bp1.package_id WHERE bp2.id IS NULL AND bp1.s_activ != 2 AND AP.status = '1' ORDER BY AP.id";
        $res = $db->query($query);

        while ($rs = mysqli_fetch_array($res)) {
            $data[] = $rs;
        }

        return $data;
    }

    // 
    function getSubscriptionPlanOnEdit($storeId)
    {
        $db = new db();
        $db->makeConnection();
        $data = array();

        $date = date('Y-m-d H:i:s');
        
        $query = "SELECT bp.id, bp.package_id, bp.product_id, bp.product_name, bp.plan_id, UP.id up_id, bp.plan_nickname, bp.currency, bp.price, bp.description FROM billing_products bp INNER JOIN anar_packages AP ON AP.id = bp.package_id LEFT JOIN user_plan UP ON (bp.plan_id = UP.plan_id AND UP.store_id='{$storeId}' AND UP.subscription_start_at <= '{$date}' AND UP.subscription_end_at >= '{$date}') WHERE bp.s_activ != 2 AND AP.status = '1' GROUP BY bp.id ORDER BY AP.id";
        $res = $db->query($query);

        while ($rs = mysqli_fetch_array($res)) {
            $data[] = $rs;
        }

        return $data;
    }

   function showPlan(){
        $db = new db();
        $db->makeConnection();
        $data = array();

        $query = "select * from billing_products where s_activ<>2";
        $res = $db->query($query);
        // $res = $res->toArray();
        // $res=mysqli_fetch_array($res,MYSQLI_ASSOC);

        while ($rs = mysqli_fetch_array($res)) {
            $data[] = $rs;
        }

        /*$new_value = $data[1];
        unset($data[1]);
        array_unshift($data, $new_value);*/

        return $data;
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

        /*$q = "select plan_id,product_name from billing_products where product_name='Anar Base Package'";
        $res = $db->query($q);

        while ($rs = mysqli_fetch_array($res)) {
            $data[] = $rs;
        }

        $firstPlanId = $data[0][0];
        $firstPlanName = $data[0][0];

        $this->logs("firstPlanId: " . $firstPlanId);

        $planIds[$firstPlanId] = $firstPlanName;*/
        $i = 1;

        foreach ($planIds as $key => $value) {
            $plans[] = ["plan" => $value];
            $user_plans .= "('".$_SESSION['userid']."','". $value."')";
            if(count($planIds) != $i){
                $user_plans .= ",";                
            }
            $i++;
        }

        $uId = $_SESSION['userid'];
        $this->logs("userid: " . $uId);

        $customer = "select email from user where u_id='$uId'";
        $res = $db->query($customer);

        while ($rs = mysqli_fetch_array($res)) {
            $data2[] = $rs;
        }

        $emailId = $data2[0][0];
        $this->logs("emailId: " . $emailId);

        \Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);

        $token = $_POST['stripeToken'];
        $this->logs("stripeToken: " . $token);

        // Create a Customer
        $customer = \Stripe\Customer::create(array(
            "email" => $emailId,
            "source" => $token                
        ));

        $customerId = $customer->id;
        $this->logs("customerId: " . $customerId);

        $query = "UPDATE user SET stripe_customer_id='$customerId',activ=5 where  u_id='$uId'";
        $this->logs("query: " . $query);
        $res = $db->query($query);

        $subscription = \Stripe\Subscription::create(array(
            "customer" => $customerId,
            "items" => $plans
        ));

        $query = "insert into user_plan(user_id, plan_id) values$user_plans";
        $res = $db->query($query);

        if($res){
            $_SESSION['active_state'] = 5;  
            $this->logs("active_state: " . $_SESSION['active_state']);
          
            $_SESSION['MESSAGE'] = "You have successfully subscribed.";
            $url = BASE_URL . 'showStandard.php';
            $inoutObj = new inOut();
            $inoutObj->reDirect($url);
            exit();
        }
    }

    /**
     * [subscribeForLocation description]
     * @return [type] [description]
     */
    function subscribeForLocation($storeId = null)
    {
        if(!is_null($storeId))
        {
            $db = new db();
            $db->makeConnection();

            $data = array();
            $planIds = $_POST['plan_id'];

            // Get store detail
            $res = $db->query("SELECT store_name FROM store WHERE store_id = '{$storeId}'");
            $store = mysqli_fetch_array($res);

            $uId = $_SESSION['userid'];

            // Get company and associated stripe customer detail
            $qry = "SELECT U.email, CONCAT(U.fname, ' ', U.lname) AS userName, C.company_id, C.company_name, C.orgnr, CONCAT_WS(', ', C.street, C.city, C.zip, C.country) AS companyAddress, C.city, CSD.company_id AS csd_company_id, CSD.stripe_customer_id FROM user AS U INNER JOIN company AS C ON U.u_id = C.u_id LEFT JOIN company_subscription_detail AS CSD ON C.company_id = CSD.company_id WHERE U.u_id = '{$uId}'";
            $res = $db->query($qry);

            $user = mysqli_fetch_array($res);
            $customer_id = $user['stripe_customer_id'];

            // 
            \Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);
            $token = $_POST['stripeToken'];

            // Create a Customer if not exist
            if(!$customer_id || is_null($customer_id) || $customer_id == '')
            {
                $description = "Org No.: {$user['orgnr']}, City: {$user['city']}";

                $customer = \Stripe\Customer::create(array(
                    'email'         => $user['email'],
                    'name'          => $user['company_name'],
                    'description'   => $description,
                    'source'        => $token
                ));

                $customer_id = $customer->id;

                // Insert/update stripe's detail in 'company_subscription_detail' table
                if(!$user['csd_company_id'])
                {
                    $query = "INSERT INTO company_subscription_detail(company_id, stripe_customer_id) VALUES('{$user['company_id']}', '{$customer_id}')";
                }
                else
                {
                    $query = "UPDATE company_subscription_detail SET stripe_customer_id = '$customer_id' WHERE company_id = '{$user['company_id']}'";
                }
                
                $res = $db->query($query);
            }

            $this->logs("userid: " . $uId);
            $this->logs("customerId: " . $customer_id);

            // Create subscription
            if($customer_id && !empty($planIds))
            {
                $emailContent = ''; $total = 0;

                $planIds = join("','", $planIds);
                $query = "SELECT product_name, plan_id, price, trial_period FROM billing_products WHERE plan_id IN ('{$planIds}')";
                $res = $db->query($query);

                while ($rs = mysqli_fetch_array($res))
                {
                    $subscription = \Stripe\Subscription::create(array(
                        "customer"          => $customer_id,
                        "items"             => [['plan' => $rs['plan_id']]],
                        "trial_period_days" => $rs['trial_period'],
                        "metadata"          => array('StoreID' => $storeId),
                        "tax_percent"       => 25, // Need to set dynamically value later
                    ));

                    if($subscription)
                    {
                        $total += $rs['price'];
                        $trial_start = !is_null($subscription->trial_start) ? date('Y-m-d H:i:s', $subscription->trial_start) : $subscription->trial_start;
                        $trial_end = !is_null($subscription->trial_end) ? date('Y-m-d H:i:s', $subscription->trial_end) : $subscription->trial_end;
                        $current_period_start = date('Y-m-d H:i:s', $subscription->current_period_start);
                        $current_period_end = date('Y-m-d H:i:s', $subscription->current_period_end);

                        if(is_null($trial_start) && is_null($trial_end))
                        {
                            $query = "INSERT INTO user_plan(user_id, store_id, subscription_id, plan_id, subscription_start_at, subscription_end_at) VALUES('{$_SESSION['userid']}', '{$storeId}', '{$subscription->id}', '{$rs['plan_id']}', '{$current_period_start}', '{$current_period_end}')";
                        }
                        else
                        {
                            $query = "INSERT INTO user_plan(user_id, store_id, subscription_id, plan_id, trial_start_at, trial_end_at, subscription_start_at, subscription_end_at) VALUES('{$_SESSION['userid']}', '{$storeId}', '{$subscription->id}', '{$rs['plan_id']}', '{$trial_start}', '{$trial_end}', '{$current_period_start}', '{$current_period_end}')";
                        }

                        $resInsert = $db->query($query);

                        // 
                        $emailContent .= "<tr>
                            <td align='left' vertical-align='top' style='padding:5px 15px;'>
                                <div style='font-family:Lato, Helvetica, Arial, sans-serif;font-size:14px;line-height:1;color:#222222;'>{$rs['product_name']}</div>
                            </td>
                            <td align='right' style='padding: 5px 15px;'>&#36;{$rs['product_name']}</td>
                        </tr>";
                    }

                    $emailContent .= "<tr>
                        <td align='left' vertical-align='top' style='padding:5px 10px; background-color:#CCCD99;'>
                            <div style='font-family:Lato, Helvetica, Arial, sans-serif;font-size:14px;line-height:1;color:#222222;'>{$rs['product_name']}</div>
                        </td>
                        <td align='right' style='padding:5px 10px;background-color: #CCCD99;'>&#36;{$total}</td>
                    </tr>";
                }

                // Send thank-you email
                $template = file_get_contents(BASEPATH.'email-templates/subscription-confirmation-email.html');

                $find = array('{{orgNo}}', '{{userName}}', '{{companyAddress}}', '{{storeName}}', '{{theContent}}');
                $replace = array($user['orgnr'], $user['userName'], $user['companyAddress'], $store['store_name'], $emailContent);
                $template = str_replace($find, $replace, $template);

                include_once("classes/emails.php");
                $mailObj = new emails();
                $mailObj->sendSubscriptionThankYouEmail($user['email'], $template);
            }
        }
    }

    /**
     * Return the plans get subscribed by location
     * @param  [type] $storeId [description]
     * @return [type]          [description]
     */
    function getSubscribedPlanByLocation($storeId = null)
    {
        if(!is_null($storeId))
        {
            $db = new db();
            $db->makeConnection();

            // Query to get plans by store ID
            $query = "SELECT BP.product_name, BP.plan_id FROM billing_products BP INNER JOIN user_plan UP ON BP.plan_id = UP.plan_id WHERE BP.s_activ = 1 AND UP.store_id = '{$storeId}'";
            return $db->query($query);
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

   function showBillingCustomer(){
        $db = new db();
        $db->makeConnection();

        $query = "select user_plan.id as user_plan_id, user_plan.user_id,user_plan.plan_id,user.fname,user.lname,billing_products.* from user_plan left join billing_products 
on user_plan.plan_id=billing_products.plan_id left join user 
on user_plan.user_id=user.u_id group by user.u_id";
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

    function viewBillingCustomer($id){
        $db = new db();
        $db->makeConnection();

        $query = "select user.*,billing_products.* from user_plan left join billing_products on billing_products.plan_id=user_plan.plan_id left join user on user.u_id=user_plan.user_id where user_plan.id=$id";
        $res = $db->query($query);

        while ($rs = mysqli_fetch_array($res)) {
            $data[] = $rs;
        }

        // print_r($data);
        // die();
        
        return $data;
   }

    function logs($str = ""){
        $t=time();

        // $myfile = fopen("upload/log" . date("Ymd",$t) . ".txt", "a") or die("Unable to open file!");

        try{
            $myfile = fopen("upload/log" . date("Ymd",$t) . ".txt", "a");
        }catch(Exception $ex){
            echo $ex;
            die();
        }

        $txt = date("Y-m-d",$t) . " - " . $str . "  \n";
        fwrite($myfile, $txt);
        fclose($myfile);
    }

}
?>