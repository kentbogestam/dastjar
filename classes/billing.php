 <?php
 /*  File Name : addCompany.php
 *  Description : Add Company Form
 *  Author  :Mayank Pathak  Date: 15rd,Aug,2018  Creation
*/

/*require_once("cumbari.php");
require_once('vendor/autoload.php');
require_once("classes/inOut.php");*/
require_once(dirname(__DIR__).'/cumbari.php');
require_once(dirname(__DIR__).'/vendor/autoload.php');
require_once(dirname(__DIR__).'/classes/inOut.php');

class Billing{

 function createPlan(){
    $package_ids = $_POST['package_id'];
    $productName = $_POST['product_name'];
    $planNickname = $_POST['plan_nickname'];
    $price = trim($_POST['price']);
    $billing_interval = $_POST['billing_interval'];
    $trialPeriod = is_numeric($_POST['trial_period']) ? $_POST['trial_period'] : 0;
    $currency = $_POST['currency'];
    $description = $_POST['description'];
    $usageType = $_POST['usage_type'];
    $productType = $_POST['product_type'];

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
        "interval" => $billing_interval,
        "currency" => $currency,
        'product' => $productId,
        "usage_type" => $usageType
    ));

    $planId = $plan->id;

    $db = new db();
    $db->makeConnection();
    $time = time();
    $date = date("Y-m-d h:i:s",$time);

    // Insert into billing product
    $query = "insert into billing_products(product_id, product_name, plan_id, plan_nickname, currency, price, trial_period, billing_interval, usage_type, product_type, description, created_at, updated_at, s_activ) values('$productId', '$productName', '$planId', '$planNickname', '$currency', '$price', '$trialPeriod', '$billing_interval', '$usageType', '$productType', '$description', '$date', '$date', 1)";

    $res = $db->query($query);

    // Insert into billing product packages
    if($res && !empty($package_ids))
    {
        $insertId = $db->insertId();

        foreach($package_ids as $package_id)
        {
            $res = $db->query("INSERT INTO billing_product_packages(billing_product_id, package_id) VALUES('{$insertId}', '{$package_id}')");
        }
    }

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
        // $package_id = !empty($_POST['package_id']) ? $_POST['package_id'] : 'NULL';
        $package_ids = $_POST['package_id'];
        $productId = $_POST['product_id'];
        $planId = $_POST['plan_id'];

        $productName = $_POST['product_name'];
        $planNickname = $_POST['plan_nickname'];
        $price = trim($_POST['price']);
        $trialPeriod = is_numeric($_POST['trial_period']) ? $_POST['trial_period'] : 0;
        $currency = $_POST['currency'];
        $description = $_POST['description'];
        $usageType = $_POST['usage_type'];
        $productType = $_POST['product_type'];

        // echo '<pre>'; print_r($editId); exit;

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

        // Update billing product packages
        $query = "update billing_products set product_name='$productName', plan_nickname='$planNickname', trial_period='$trialPeriod', usage_type='$usageType', product_type='$productType', description='$description' where id='$editId'";
        // echo $query; exit;

        $res = $db->query($query);

        // Update billing product packages
        if($res && !empty($package_ids))
        {
            $res = $db->query("DELETE FROM billing_product_packages WHERE billing_product_id = '{$editId}'");

            foreach($package_ids as $package_id)
            {
                $res = $db->query("INSERT INTO billing_product_packages(billing_product_id, package_id) VALUES('{$editId}', '{$package_id}')");
            }
        }

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

        $query = "SELECT bp.id, GROUP_CONCAT(bpp.package_id) AS package_ids, bp.product_id, bp.product_name, bp.plan_id, bp.plan_nickname, bp.currency, bp.price, bp.trial_period, bp.description FROM billing_products bp INNER JOIN billing_product_packages bpp ON bp.id = bpp.billing_product_id INNER JOIN anar_packages AP ON AP.id = bpp.package_id WHERE bp.s_activ != 2 AND AP.status = '1' GROUP BY bp.id ORDER BY AP.id, bp.id";
        $res = $db->query($query);

        while ($rs = mysqli_fetch_assoc($res)) {
            // 
            $mappedPackages = array();
            // $billing_product_ids = $rs['billing_product_ids'];
            $package_ids = explode(',', $rs['package_ids']);
            $package_ids = implode("','",$package_ids);
            $q2 = "SELECT title FROM anar_packages WHERE id IN('".$package_ids."')";
            $res1 = $db->query($q2);
            if($res1->num_rows > 1)
            {
                while ($rs1 = mysqli_fetch_assoc($res1))
                {
                    $mappedPackages[] = $rs1['title'];
                }
            }
            
            // 
            $data[] = array(
                'id' => $rs['id'],
                'billing_product_ids' => $rs['billing_product_ids'],
                'package_ids' => $rs['package_ids'],
                'product_id' => $rs['product_id'],
                'product_name' => $rs['product_name'],
                'plan_id' => $rs['plan_id'],
                'plan_nickname' => $rs['plan_nickname'],
                'currency' => $rs['currency'],
                'price' => $rs['price'],
                'trial_period' => $rs['trial_period'],
                'description' => $rs['description'],
                'mappedPackages' => $mappedPackages,
            );
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
        
        $query = "SELECT bp.id, GROUP_CONCAT(bpp.package_id) AS package_ids, bp.product_id, bp.product_name, bp.plan_id, UP.id up_id, bp.plan_nickname, bp.currency, bp.price, bp.trial_period, bp.description FROM billing_products bp INNER JOIN billing_product_packages bpp ON bp.id = bpp.billing_product_id INNER JOIN anar_packages AP ON AP.id = bpp.package_id LEFT JOIN user_plan UP ON (bp.plan_id = UP.plan_id AND UP.store_id='{$storeId}' AND UP.subscription_start_at <= '{$date}' AND UP.subscription_end_at >= '{$date}' AND UP.status='1') WHERE bp.s_activ != 2 AND AP.status = '1' GROUP BY bp.id ORDER BY AP.id";
        $res = $db->query($query);

        while ($rs = mysqli_fetch_array($res)) {
            // 
            $mappedPackages = array();
            // $billing_product_ids = $rs['billing_product_ids'];
            $package_ids = explode(',', $rs['package_ids']);
            $package_ids = implode("','",$package_ids);
            $q2 = "SELECT title FROM anar_packages WHERE id IN('".$package_ids."')";
            $res1 = $db->query($q2);
            if($res1->num_rows > 1)
            {
                while ($rs1 = mysqli_fetch_assoc($res1))
                {
                    $mappedPackages[] = $rs1['title'];
                }
            }

            // 
            $data[] = array(
                'id' => $rs['id'],
                'billing_product_ids' => $rs['billing_product_ids'],
                'package_ids' => $rs['package_ids'],
                'product_id' => $rs['product_id'],
                'product_name' => $rs['product_name'],
                'plan_id' => $rs['plan_id'],
                'up_id' => $rs['up_id'],
                'plan_nickname' => $rs['plan_nickname'],
                'currency' => $rs['currency'],
                'price' => $rs['price'],
                'trial_period' => $rs['trial_period'],
                'description' => $rs['description'],
                'mappedPackages' => $mappedPackages,
            );
        }

        return $data;
    }

    // Return subscribed plan of stores
    function getSubscribedPlanByStoreId($storeId)
    {
        $db = new db();
        $db->makeConnection();
        $data = array();

        $date = date('Y-m-d H:i:s');

        $query = "SELECT UP.subscription_id, USI.plan_id, USI.subscription_item, GROUP_CONCAT(BPP.package_id) AS package_ids FROM user_plan UP INNER JOIN user_subscription_items USI ON USI.subscription_id = UP.subscription_id INNER JOIN billing_products BP ON BP.plan_id = USI.plan_id INNER JOIN billing_product_packages BPP ON BPP.billing_product_id = BP.id INNER JOIN anar_packages AP ON AP.id = BPP.package_id WHERE UP.store_id='{$storeId}' AND UP.subscription_start_at <= '{$date}' AND UP.subscription_end_at >= '{$date}' AND UP.status='1' AND USI.status = '1' GROUP BY USI.plan_id ORDER BY AP.id";
        $res = $db->query($query);

        while ($rs = mysqli_fetch_assoc($res)) {
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

        $query = "SELECT BP.*, GROUP_CONCAT(BPP.package_id) AS package_id FROM billing_products BP LEFT JOIN billing_product_packages BPP ON BP.id = BPP.billing_product_id where BP.id=$editId";

        $res = $db->query($query);

        while ($rs = mysqli_fetch_assoc($res)) {
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

    /*function getSetupIntent()
    {
        \Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);
        return \Stripe\SetupIntent::create();
    }*/

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
            $qry = "SELECT U.email, CONCAT(U.fname, ' ', U.lname) AS userName, C.company_id, C.company_name, C.orgnr, CONCAT_WS(', ', C.street, C.city, C.zip, C.country) AS companyAddress, C.city, CSD.company_id AS csd_company_id, CSD.stripe_customer_id, CSD.stripe_user_id FROM user AS U INNER JOIN company AS C ON U.u_id = C.u_id LEFT JOIN company_subscription_detail AS CSD ON C.company_id = CSD.company_id WHERE U.u_id = '{$uId}'";
            $res = $db->query($qry);

            $user = mysqli_fetch_array($res);
            $customer_id = $user['stripe_customer_id'];
            $stripe_user_id = $user['stripe_user_id'];

            // 
            \Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);
            $token = $_POST['stripeToken'];

            try {
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
                    // 
                    $subsProductPackages = array();
                    $emailContent = ''; $subTotal = $tax = $total = 0;

                    $planIds = join("','", $planIds);
                    // $query = "SELECT product_name, plan_id, price, trial_period FROM billing_products WHERE plan_id IN ('{$planIds}')";
                    $query = "SELECT BP.product_name, BP.plan_id, BP.price, BP.trial_period, GROUP_CONCAT(BPP.package_id) AS package_ids FROM billing_products BP LEFT JOIN billing_product_packages BPP ON BP.id = BPP.billing_product_id WHERE BP.plan_id IN ('{$planIds}') GROUP BY BP.id";
                    $res = $db->query($query);

                    while ($rs = mysqli_fetch_array($res))
                    {
                        $trial_period = $rs['trial_period'] ? $rs['trial_period'] : 0;
                        $subscription = \Stripe\Subscription::create(array(
                            "customer"          => $customer_id,
                            "items"             => [['plan' => $rs['plan_id']]],
                            "trial_period_days" => $trial_period,
                            "metadata"          => array('StoreID' => $storeId),
                            "tax_percent"       => 25, // Need to set dynamically value later
                        ));

                        if($subscription)
                        {
                            $subTotal += $rs['price'];
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

                            // Get access packages belongs to plan
                            if( $stripe_user_id == '' && $rs['package_ids'] != '' )
                            {
                                $package_ids = explode(',', $rs['package_ids']);

                                foreach($package_ids as $package_id)
                                {
                                    array_push($subsProductPackages, $package_id);
                                }
                            }

                            // 
                            if($subscription->status == 'active')
                            {
                                $emailContent .= "<tr>
                                    <td align='left' vertical-align='top' style='padding:5px 15px;'>
                                        <div style='font-family:Lato, Helvetica, Arial, sans-serif;font-size:14px;line-height:1;color:#222222;'>{$rs['product_name']}</div>
                                    </td>
                                    <td align='right' style='padding: 5px 15px;'>".number_format($rs['price'], 2, '.', '')." (SEK)</td>
                                </tr>";
                            }
                        }
                    }

                    if($emailContent != '')
                    {
                        $tax = ($subTotal*25)/100;
                        $total = $subTotal + $tax;
                        $tax = number_format($tax, 2, '.', '');
                        $subTotal = number_format($subTotal, 2, '.', '');
                        $total = number_format($total, 2, '.', '');

                        $emailContent .= "
                        <tr>
                            <td align='right' vertical-align='top' style='padding:5px 10px 1px; background-color:#CCCD99;'>
                                <div style='font-family:Lato, Helvetica, Arial, sans-serif;font-size:14px;line-height:1;color:#222222;'>Sub Total:</div>
                            </td>
                            <td align='right' style='padding:5px 10px 1px;background-color: #CCCD99;'>{$subTotal} (SEK)</td>
                        </tr>
                        <tr>
                            <td align='right' vertical-align='top' style='padding:1px 10px 1px; background-color:#CCCD99;'>
                                <div style='font-family:Lato, Helvetica, Arial, sans-serif;font-size:14px;line-height:1;color:#222222;'>Tax:</div>
                            </td>
                            <td align='right' style='padding:1px 10px 1px;background-color: #CCCD99;'>{$tax} (SEK)</td>
                        </tr>
                        <tr>
                            <td align='right' vertical-align='top' style='padding:1px 10px 5px; background-color:#CCCD99;'>
                                <div style='font-family:Lato, Helvetica, Arial, sans-serif;font-size:14px;line-height:1;color:#222222;'>Total:</div>
                            </td>
                            <td align='right' style='padding:1px 10px 5px;background-color: #CCCD99;'>{$total} (SEK)</td>
                        </tr>
                        <tr>
                            <td colspan='2'>Note*: The total value of (SUM)  will be deducted from you account after end of trial period.</td>
                        </tr>";

                        // Send thank-you email
                        $template = file_get_contents(BASEPATH.'email-templates/subscription-confirmation-email.html');

                        $find = array('{{orgNo}}', '{{userName}}', '{{companyAddress}}', '{{storeName}}', '{{theContent}}');
                        $replace = array($user['orgnr'], $user['userName'], $user['companyAddress'], $store['store_name'], $emailContent);
                        $template = str_replace($find, $replace, $template);

                        include_once("classes/emails.php");
                        $mailObj = new emails();
                        $mailObj->sendSubscriptionThankYouEmail($user['email'], $template);

                        // If subscribed to 'payment plan' and company is not connected to 'stripe connect'
                        if( $stripe_user_id == '' && in_array(5, $subsProductPackages))
                        {
                            $url = "https://connect.stripe.com/oauth/authorize?response_type=code&client_id=".STRIPE_CLIENT_ID."&scope=read_write&redirect_uri=".BASE_URL."stripe-connect-response.php";

                            $inoutObj = new inOut();
                            $inoutObj->reDirect($url);
                            exit();
                        }
                    }
                }
            } catch (\Stripe\Error\Base $e) {
                # Display error on client
                $response = array('error' => $e->getMessage());
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

    /**
     * Get company and associated stripe customer detail
     * @return [type] [description]
     */
    function getUserCompanySubsDetail($uId = null)
    {
        $db = new db();
        $db->makeConnection();

        $qry = "SELECT U.email, CONCAT(U.fname, ' ', U.lname) AS userName, U.phone, C.company_id, C.company_name, C.orgnr, CONCAT_WS(', ', C.street, C.city, C.zip, C.country) AS companyAddress, C.city, CSD.company_id AS csd_company_id, CSD.stripe_customer_id, CSD.stripe_user_id FROM user AS U INNER JOIN company AS C ON U.u_id = C.u_id LEFT JOIN company_subscription_detail AS CSD ON C.company_id = CSD.company_id WHERE U.u_id = '{$uId}'";
        $res = $db->query($qry);
        $user = mysqli_fetch_array($res);
        return $user;
    }

    /**
     * Get all saved payment method of customer
     * @param  [type] $customerId [description]
     * @return [type]             [description]
     */
    function getPaymentMethod($customerId = null)
    {
        \Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);
        $paymentMethod = \Stripe\PaymentMethod::all(['customer' => $customerId, 'type' => 'card']);

        return $paymentMethod;
    }

    function getAllSources($customerId = null)
    {
        \Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);
        $sources = \Stripe\Customer::allSources($customerId, ['object' => 'card']);

        return $sources;
    }

    /**
     * Create subscription for location
     * @return [type] [description]
     */
    function subscribeForLocationSCA($data)
    {
        $db = new db();
        $db->makeConnection();

        $response = array();
        $uId = $_SESSION['userid'];

        // Create store if not already created
        if( !isset($data->store_id) || empty($data->store_id) )
        {
            $storeUniqueId = uuid();

            $query = "INSERT INTO store(store_id, u_id, store_name) VALUES('{$storeUniqueId}', '{$uId}', '{$data->store_name}')";
            
            if($db->query($query))
            {
                $data->store_id = $storeUniqueId;
            }
        }

        // 
        if( isset($data->store_id) && !empty($data->store_id) )
        {
            // Get company and associated stripe customer detail
            $user = $this->getUserCompanySubsDetail($uId);
            $customer_id = $user['stripe_customer_id'];
            $stripe_user_id = $user['stripe_user_id'];

            // 
            \Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);

            try {
                // Create a Customer if not exist
                if(!$customer_id || is_null($customer_id) || $customer_id == '')
                {
                    $description = "Org No.: {$user['orgnr']}, City: {$user['city']}";
                    $customer = \Stripe\Customer::create(array(
                        'email'         => $user['email'],
                        'name'          => $user['company_name'],
                        'description'   => $description,
                        'source'        => $data->stripe_token
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

                    $this->logs("userid: " . $uId);
                    $this->logs("customerId: " . $customer_id);
                }
                else
                {
                    // Attach new card to customer
                    if(isset($data->stripe_token))
                    {
                        $card = \Stripe\Customer::createSource(
                            $customer_id,
                            array(
                                'source' => $data->stripe_token
                            )
                        );
                    }
                }

                // Create subscription
                $planIds = $data->plan_id;
                if($customer_id && !empty($planIds))
                {
                    $subsProductPackages = array();
                    $emailContent = ''; $subTotal = $tax = $total = 0;
                    $planIds = join("','", $planIds);

                    // Get plan detail to subscribe
                    $query = "SELECT BP.product_name, BP.plan_id, BP.price, BP.trial_period, GROUP_CONCAT(BPP.package_id) AS package_ids FROM billing_products BP LEFT JOIN billing_product_packages BPP ON BP.id = BPP.billing_product_id WHERE BP.plan_id IN ('{$planIds}') GROUP BY BP.id ORDER BY BP.trial_period";
                    $res = $db->query($query);

                    while ($rs = mysqli_fetch_array($res))
                    {
                        $arrSubsCreate = array(
                            'customer'          => $customer_id,
                            'items'             => [['plan' => $rs['plan_id']]],
                            'trial_period_days' => $rs['trial_period'],
                            'payment_behavior'  => 'allow_incomplete',
                            'metadata'          => array('StoreID' => $data->store_id),
                            'tax_percent'       => 25, // Need to set dynamically value later
                            'expand'            => ['latest_invoice.payment_intent'],
                            'off_session'       => true,
                        );

                        // Assign 'payment method' to subscription
                        if( isset($card) )
                        {
                            $arrSubsCreate['default_payment_method'] = $card->id;
                        }
                        else
                        {
                            $arrSubsCreate['default_payment_method'] = $data->payment_method_id;
                        }

                        $subscription = \Stripe\Subscription::create($arrSubsCreate);

                        // 
                        if($subscription)
                        {
                            // Check if user action required and set response
                            if( ($subscription->status == 'incomplete' && $subscription->latest_invoice->payment_intent->status == 'requires_source_action') )
                            {
                                $response = array(
                                    'requires_action' => true,
                                    'payment_intent_client_secret' => $subscription->latest_invoice->payment_intent->client_secret,
                                    'storeId' => $data->store_id
                                );
                            }
                            else
                            {
                                $response = array('success' => true, 'storeId' => $data->store_id);
                            }

                            // Add subscription in DB
                            $trial_start = !is_null($subscription->trial_start) ? date('Y-m-d H:i:s', $subscription->trial_start) : $subscription->trial_start;
                            $trial_end = !is_null($subscription->trial_end) ? date('Y-m-d H:i:s', $subscription->trial_end) : $subscription->trial_end;
                            $current_period_start = date('Y-m-d H:i:s', $subscription->current_period_start);
                            $current_period_end = date('Y-m-d H:i:s', $subscription->current_period_end);

                            if(is_null($trial_start) && is_null($trial_end))
                            {
                                $query = "INSERT INTO user_plan(user_id, store_id, subscription_id, plan_id, subscription_start_at, subscription_end_at) VALUES('{$uId}', '{$data->store_id}', '{$subscription->id}', '{$rs['plan_id']}', '{$current_period_start}', '{$current_period_end}')";
                            }
                            else
                            {
                                $query = "INSERT INTO user_plan(user_id, store_id, subscription_id, plan_id, trial_start_at, trial_end_at, subscription_start_at, subscription_end_at) VALUES('{$uId}', '{$data->store_id}', '{$subscription->id}', '{$rs['plan_id']}', '{$trial_start}', '{$trial_end}', '{$current_period_start}', '{$current_period_end}')";
                            }

                            $resInsert = $db->query($query);
                        }
                    }
                }
            } catch (\Stripe\Error\Base $e) {
                # Display error on client
                $response = array('error' => $e->getMessage(), 'storeId' => $data->store_id);
            }
        }

        return $response;
    }

    // 
    function subscribeForLocationSCA__($data)
    {
        $db = new db();
        $db->makeConnection();

        $response = array();
        $uId = $_SESSION['userid'];

        // Create store if not already created
        if( !isset($data->store_id) || empty($data->store_id) )
        {
            $storeUniqueId = uuid();

            $query = "INSERT INTO store(store_id, u_id, store_name) VALUES('{$storeUniqueId}', '{$uId}', '{$data->store_name}')";
            
            if($db->query($query))
            {
                $data->store_id = $storeUniqueId;
            }
        }

        // 
        if( isset($data->store_id) && !empty($data->store_id) )
        {
            // Get company and associated stripe customer detail
            $user = $this->getUserCompanySubsDetail($uId);
            $customer_id = $user['stripe_customer_id'];
            $stripe_user_id = $user['stripe_user_id'];

            // 
            \Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);

            try {
                // Create a Customer if not exist
                if(!$customer_id || is_null($customer_id) || $customer_id == '')
                {
                    $description = "Org No.: {$user['orgnr']}, City: {$user['city']}";
                    $customer = \Stripe\Customer::create(array(
                        'email'         => $user['email'],
                        'name'          => $user['company_name'],
                        'description'   => $description,
                        'source'        => $data->stripe_token
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

                    $this->logs("userid: " . $uId);
                    $this->logs("customerId: " . $customer_id);
                }
                else
                {
                    // Attach new card to customer
                    if(isset($data->stripe_token))
                    {
                        $card = \Stripe\Customer::createSource(
                            $customer_id,
                            array(
                                'source' => $data->stripe_token
                            )
                        );
                    }
                }

                // Create subscription
                $planIds = $data->plan_id;
                if($customer_id && !empty($planIds))
                {
                    $items = $subsProductPackages = array();
                    $billingInterval = 'month';
                    $emailContent = ''; $subTotal = $tax = $total = 0;
                    $planIds = join("','", $planIds);

                    // Get plan detail to subscribe
                    $query = "SELECT BP.product_name, BP.plan_id, BP.price, BP.trial_period, BP.billing_interval, GROUP_CONCAT(BPP.package_id) AS package_ids FROM billing_products BP LEFT JOIN billing_product_packages BPP ON BP.id = BPP.billing_product_id WHERE BP.plan_id IN ('{$planIds}') GROUP BY BP.id ORDER BY BP.trial_period";
                    $res = $db->query($query);

                    while ($rs = mysqli_fetch_array($res))
                    {
                        $items[] = array('plan' => $rs['plan_id']);

                        // 
                        if($rs['billing_interval'] == 'day')
                        {
                            $billingInterval = 'day';
                        }
                    }

                    // Set billing cycle according to 'billing_interval'
                    if($billingInterval == 'month')
                    {
                        $billing_cycle_anchor_date = date('Y-m-26 10:00:00');

                        // Set 'billing cycle' always in future
                        if( strtotime(date('Y-m-d H:i:s')) >= strtotime($billing_cycle_anchor_date) )
                        {
                            $billing_cycle_anchor_date = date('Y-m-26 10:00:00', strtotime("+1 months", strtotime($billing_cycle_anchor_date)));
                        }
                    }
                    else
                    {
                        $billing_cycle_anchor_date = date('Y-m-d 10:00:00');

                        // Set 'billing cycle' always in future
                        if( strtotime(date('Y-m-d H:i:s')) >= strtotime($billing_cycle_anchor_date) )
                        {
                            $billing_cycle_anchor_date = date('Y-m-d 10:00:00', strtotime("+1 days", strtotime($billing_cycle_anchor_date)));
                        }
                    }

                    // Update if store already has subscription or create new subscription
                    $query = "SELECT subscription_id FROM user_plan WHERE store_id = '{$data->store_id}' AND status = '1'";
                    $res = $db->query($query);
                    $userPlan = mysqli_fetch_array($res);

                    if( !empty($userPlan) && is_array($userPlan) )
                    {
                        $arrSubsCreate = array(
                            'items' => $items,
                            'prorate' => false
                        );

                        // Assign 'payment method' to subscription
                        if( isset($card) )
                        {
                            $arrSubsCreate['default_payment_method'] = $card->id;
                        }
                        else
                        {
                            $arrSubsCreate['default_payment_method'] = $data->payment_method_id;
                        }

                        // Update subscription
                        $subscription = \Stripe\Subscription::update(
                            $userPlan['subscription_id'],
                            $arrSubsCreate
                        );
                    }
                    else
                    {
                        // 
                        $arrSubsCreate = array(
                            'customer'          => $customer_id,
                            'items'             => $items,
                            'payment_behavior'  => 'allow_incomplete',
                            'metadata'          => array('StoreID' => $data->store_id),
                            'tax_percent'       => 25, // Need to set dynamically value later
                            'expand'            => ['latest_invoice.payment_intent'],
                            'off_session'       => true,
                            'billing_cycle_anchor' => strtotime($billing_cycle_anchor_date),
                            'prorate' => false,
                        );

                        // Assign 'payment method' to subscription
                        if( isset($card) )
                        {
                            $arrSubsCreate['default_payment_method'] = $card->id;
                        }
                        else
                        {
                            $arrSubsCreate['default_payment_method'] = $data->payment_method_id;
                        }

                        // Create subscription
                        $subscription = \Stripe\Subscription::create($arrSubsCreate);
                    }

                    // 
                    if($subscription)
                    {
                        // Check if user action required and set response
                        if( ($subscription->status == 'incomplete' && $subscription->latest_invoice->payment_intent->status == 'requires_source_action') )
                        {
                            $response = array(
                                'requires_action' => true,
                                'payment_intent_client_secret' => $subscription->latest_invoice->payment_intent->client_secret,
                                'storeId' => $data->store_id
                            );
                        }
                        else
                        {
                            $response = array('success' => true, 'storeId' => $data->store_id);
                        }

                        // Add subscription and its detail in DB
                        if( empty($userPlan) )
                        {
                            $current_period_start = date('Y-m-d H:i:s', $subscription->current_period_start);
                            $current_period_end = date('Y-m-d H:i:s', $subscription->current_period_end);

                            $query = "INSERT INTO user_plan(user_id, store_id, subscription_id, subscription_start_at, subscription_end_at) VALUES('{$uId}', '{$data->store_id}', '{$subscription->id}', '{$current_period_start}', '{$current_period_end}')";
                            $resInsert = $db->query($query);
                        }

                        // Get the subscribed plan
                        $subscriptionItems = $subscription->items->data;

                        if( !empty($subscriptionItems) )
                        {
                            foreach($subscriptionItems as $item)
                            {
                                // Check if plan is not already added into 'user_subscription_items' table
                                $query = "SELECT id FROM user_subscription_items WHERE subscription_id = '{$subscription->id}' AND plan_id = '{$item->plan->id}' AND status = '1'";
                                $res = $db->query($query);
                                $subscriptionItem = mysqli_fetch_array($res);

                                if( empty($subscriptionItem) )
                                {
                                    if( is_numeric($item->plan->trial_period_days) && $item->plan->trial_period_days > 0 )
                                    {
                                        // Set trial according to 'billing_interval'
                                        if($billingInterval == 'month')
                                        {
                                            $months = ($item->plan->trial_period_days/30);
                                            $coupon_trial_from = date('Y-m-d 00:00:00', strtotime($billing_cycle_anchor_date));

                                            if($months >= 1)
                                            {
                                                $coupon_trial_to = date('Y-m-d 00:00:00', strtotime("+{$months} months", strtotime($billing_cycle_anchor_date)));
                                            }
                                            else
                                            {
                                                $days = $item->plan->trial_period_days;
                                                $coupon_trial_to = date('Y-m-d 00:00:00', strtotime("+{$days} days", strtotime($billing_cycle_anchor_date)));
                                            }
                                        }
                                        else
                                        {
                                            $days = $item->plan->trial_period_days;
                                            $coupon_trial_from = date('Y-m-d 00:00:00', strtotime($billing_cycle_anchor_date));
                                            $coupon_trial_to = date('Y-m-d 00:00:00', strtotime("+{$days} days", strtotime($billing_cycle_anchor_date)));
                                        }

                                        $query = "INSERT INTO user_subscription_items(subscription_id, plan_id, subscription_item, coupon_trial_from, coupon_trial_to) VALUES('{$subscription->id}', '{$item->plan->id}', '{$item->id}', '{$coupon_trial_from}', '$coupon_trial_to')";
                                    }
                                    else
                                    {
                                        $query = "INSERT INTO user_subscription_items(subscription_id, plan_id, subscription_item) VALUES('{$subscription->id}', '{$item->plan->id}', '{$item->id}')";
                                    }

                                    // Insert plan into 'user_subscription_items' table
                                    $resInsert = $db->query($query);
                                }
                            }
                        }

                        // 
                        $response['error'] = $this->applyDiscountOnSubscription($subscription->id);
                    }
                }
            } catch (\Stripe\Error\Base $e) {
                # Display error on client
                $response = array('error' => $e->getMessage(), 'storeId' => $data->store_id);
            }
        }

        return $response;
    }

    // Apply discount/coupon on subscription
    function applyDiscountOnSubscription($subscriptionId = null)
    {
        $db = new db();
        $db->makeConnection();

        if($subscriptionId != null)
        {
            $date = date('Y-m-d 00:00:00');
            $discountTotal = 0;

            // Select plan having trial periods on
            // $query = "SELECT price FROM billing_products BP INNER JOIN user_subscription_items USI ON BP.plan_id = USI.plan_id WHERE BP.trial_period != 0 AND USI.subscription_id = '{$subscriptionId}' AND USI.coupon_trial_from <= '{$date}' AND USI.coupon_trial_to >= '{$date}'";
            $query = "SELECT price FROM billing_products BP INNER JOIN user_subscription_items USI ON BP.plan_id = USI.plan_id WHERE BP.trial_period != 0 AND USI.subscription_id = '{$subscriptionId}' AND USI.coupon_trial_from <= '{$date}' AND USI.coupon_trial_to > '{$date}' AND USI.status = '1'";
            $res = $db->query($query);

            if($db->numRows($res))
            {
                while ($rs = mysqli_fetch_array($res))
                {
                    $discountTotal += $rs['price'];
                }

                //
                if($discountTotal)
                {
                    \Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);

                    // Fetch if coupon exist, otherwise create
                    $couponId = 'OFF-'.$discountTotal;

                    try {
                        // Retrieve coupon
                        $coupon = \Stripe\Coupon::retrieve($couponId);
                    } catch (\Stripe\Error\Base $e) {
                        // Create coupon
                        $coupon = \Stripe\Coupon::create([
                            'id' => $couponId,
                            'amount_off' => ($discountTotal*100),
                            'currency' => 'SEK',
                            'duration' => 'once',
                            // 'duration' => 'repeating',
                            // 'duration_in_months' => 3,
                        ]);
                    }

                    // Apply coupon on subscription
                    if($coupon)
                    {
                        try {
                            // Update subscription
                            \Stripe\Subscription::update(
                                $subscriptionId,
                                ['coupon' => $coupon->id]
                            );
                        } catch (\Stripe\Error\Base $e) {}
                    }
                }
                else
                {
                    try {
                        $sub = \Stripe\Subscription::retrieve($subscriptionId);

                        if( isset($sub->discount) && ($sub->discount != null) )
                        {
                            $sub->deleteDiscount();
                        }
                    } catch (\Stripe\Error\Base $e) {}
                }
            }
            else
            {
                try {
                    $sub = \Stripe\Subscription::retrieve($subscriptionId);

                    if( isset($sub->discount) && ($sub->discount != null) )
                    {
                        $sub->deleteDiscount();
                    }
                } catch (\Stripe\Error\Base $e) {}
            }
        }
    }

    /**
     * Delete attached customer source
     */
    function deleteSource($sourceId = null)
    {
        $response = array();

        // Get stripe customer_id
        $user = $this->getUserCompanySubsDetail($_SESSION['userid']);

        if(!is_null($user['stripe_customer_id']) && !empty($user['stripe_customer_id']))
        {
            \Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);

            $response = \Stripe\Customer::deleteSource($user['stripe_customer_id'], $sourceId);
        }
        else
        {
            $response['error'] = 'Attached source didn\'t match the customer.';
        }

        return $response;
    }

    /**
     * Remove subscription item
     */
    function removeSubscriptionItem($subscriptionItem = null)
    {
        $response = array();

        if( !is_null($subscriptionItem) )
        {
            $db = new db();
            $inoutObj = new inOut();
            $db->makeConnection();
            
            \Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);

            // 
            try {
                // Get 'subscription_id' belongs to 'subscriptionItem'
                $subs = $db->query("SELECT subscription_id FROM user_subscription_items WHERE subscription_item = '{$subscriptionItem}'");

                if($db->numRows($subs))
                {
                    while ($row = mysqli_fetch_array($subs))
                    {
                        // Check if single SI item found then remove subscription, otherwise remove SI
                        $subItems = $db->query("SELECT id FROM user_subscription_items WHERE subscription_id = '{$row['subscription_id']}' AND status = '1'");

                        if($db->numRows($subItems) == 1)
                        {
                            $response = $this->cancelSubscription($row['subscription_id']);
                        }
                        else
                        {
                            // Retrieve and delete SI
                            $subscription_item = \Stripe\SubscriptionItem::retrieve($subscriptionItem);
                            $response = $subscription_item->delete(['proration_behavior' => 'none']);
                            
                            // Update SI status in DB
                            if( isset($response->deleted) && $response->deleted )
                            {
                                $res = $db->query("UPDATE user_subscription_items SET status = '2' WHERE subscription_item = '{$subscriptionItem}'");
                            }
                        }
                    }
                }
            } catch (\Stripe\Error\Base $e) {
                $response = array('error' => $e->getMessage());
            }
        }

        return $response;
    }

    // Cancel store subscription
    function cancelLocationSubscription($userId, $storeId)
    {
        $db = new db();
        $inoutObj = new inOut();
        $db->makeConnection();

        $q = "SELECT id, subscription_id, plan_id FROM user_plan WHERE user_id = '{$userId}' AND store_id = '{$storeId}' AND status = '1'";
        $res = $db->query($q);

        if($db->numRows($res))
        {
            \Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);

            while ($row = mysqli_fetch_array($res))
            {
                try {
                    // Cancel subscription on Stripe
                    $sub = \Stripe\Subscription::retrieve($row['subscription_id']);
                    
                    if($sub->status != 'canceled')
                    {
                        $sub = $sub->cancel();
                    }

                    // Update subscription status in DB
                    if($sub->status == 'canceled')
                    {
                        $db->query("UPDATE user_plan SET status = '2' WHERE id = '{$row['id']}'");
                    }
                } catch (\Stripe\Error\Base $e) {
                    // print_r($response); exit;
                    $response = array('error' => $e->getMessage());
                }
            }
        }
    }

    // Cancel subscription and update status in DB
    function cancelSubscription($subscription_id = null)
    {
        $db = new db();
        $inoutObj = new inOut();
        $db->makeConnection();

        $sub = array('error' => 'Error');

        if( !is_null($subscription_id) )
        {
            \Stripe\Stripe::setApiKey(STRPIE_CLIENT_SECRET);

            // Cancel subscription on Stripe
            $sub = \Stripe\Subscription::retrieve($subscription_id);
            
            if($sub->status != 'canceled')
            {
                $sub = $sub->cancel();
            }

            // Update subscription status in DB
            if($sub->status == 'canceled')
            {
                $res = $db->query("UPDATE user_plan SET status = '2' WHERE subscription_id = '{$subscription_id}'");
            }
        }

        return $sub;
    }

    // Update billing product_type
    function updateProductType($data)
    {
        $db = new db();
        $db->makeConnection();

        $status = 0;

        if( isset($data['billing_product_id']) && isset($data['product_type']) )
        {
            $query = "UPDATE billing_products SET product_type={$data['product_type']} WHERE id='{$data['billing_product_id']}' ";
            $res = $db->query($query);
            $status = 1;
        }

        return $status;
    }
}

// Create subscription on create/edit store
if( isset($_POST['confirmStoreSubscription']) )
{
    // Get post data
    $data = json_decode($_POST['confirmStoreSubscription']);

    // 
    $billingObj = new billing();
    $response = $billingObj->subscribeForLocationSCA($data);

    echo json_encode($response); exit;
}

// Create subscription on create/edit store
if( isset($_POST['confirmStoreSubscription__']) )
{
    // Get post data
    $data = json_decode($_POST['confirmStoreSubscription__']);

    // 
    $billingObj = new billing();
    $response = $billingObj->subscribeForLocationSCA__($data);

    echo json_encode($response); exit;
}

// Delete source
if( isset($_POST['deleteSource']) )
{
    $billingObj = new billing();
    $response = $billingObj->deleteSource($_POST['sourceId']);
    
    echo json_encode($response); exit;
}

// Delete SI post
if( isset($_POST['removeSubscriptionItem']) )
{
    $billingObj = new billing();
    $response = $billingObj->removeSubscriptionItem($_POST['subscriptionItem']);
    
    echo json_encode($response); exit;
}
?>