<?php
   /*  File Name  : registrationProcess.php
    *  Description : Registration form
    *  Author      : Himanshu Singh  Date: 12th,Nov,2010  Creation
   */
   ob_start();
   header('Content-Type: text/html; charset=utf-8');
   include_once("cumbari.php");
   require_once('lib/captcha/recaptchalib.php');
   $regObj = new registration();
   $regObj->isValidRegistrationStep();

   include_once("header.php");   
   
   $inoutObj = new inOut();

   if (!isset($_SESSION['userid']) && !isset($_SESSION['REG_STEP'])) {
   
   } else {
       $url = BASE_URL . 'registrationStep.php';
       $inoutObj->reDirectUrl($url);
   }

   if($_SERVER["REQUEST_METHOD"] === "POST")
    {
        //form submitted

        //check if other form details are correct

        //verify captcha
        $recaptcha_secret = $captcha_secret_key;
        echo $recaptcha_secret;
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$_POST['g-recaptcha-response']);
        $response = json_decode($response, true);

        echo '<pre>'; print_r($response); exit;
 
      if($response["success"] === true)
        {
            if (isset($_POST['Continue'])) {
            
                $regObj->svrRegDflt();
            }
        }
        else
        {
            echo "You are a robot";
        }
    }


   ?>
<script>
   /*function WindowC()
   {
       document.getElementById("terms").checked=true;
       window.open("terms.php", "WinC","width=550,height=400,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no")
   }*/
</script>
<style type="text/css">
   body {  }
   a { }
   img { border: 0 } .center{width:900px; margin-left:auto; margin-right:auto;}
</style>
<script language="JavaScript" src="client/js/jsRegistration.js" type="text/javascript"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<div class="center">
<div align="center">
   <form name="register" action="" id="registerform" method="POst">
      <input type="hidden" name="checkResult" id="checkResult" value="yes"/>
      <div id="msg" align="center">
         <?php
            if ($_SESSION['MESSAGE']) {
                echo $_SESSION['MESSAGE'];
                $_SESSION['MESSAGE'] = "";
            }
            ?>
      </div>
      <input type="hidden" name="m" value="savereg">
      <table width="100%">
         <tr>
            <td width="70%">
               <table width="100%" BORDER=0 cellspacing="5"  >
                  <!--<tr>
                     <td>Role</td>
                     <td><select name="role" id="role" style="width: 200px;">
                         <option value="">--Select--</option>
                         <option value="Store Admin">Store Admin</option>
                         <option value="Product Admin">Product Admin</option>
                         <option value="Saller">Saller</option>
                     </select><div id='error_role'></div>            </td>
                     </tr>-->
                  <tr>
                     <td height="14" colspan="3" ></td>
                  </tr>
                  <tr>
                     <td colspan="3" class="blackbutton" align="left">1 Register</td>
                  </tr>
                  <tr >
                     <td align="left"></td>
                     <td align="left"></td>
                  </tr>
                  <tr>
                     <td width="50%" align="left" nowrap="nowrap">Enter e-mail address to be used as user name <span class='mandatory'>*</span></td>
                     <td width="50%" align="left">
                        <INPUT class="text_field_new" type=text name="emailid" id ="emailid" value="<?= isset($_SESSION['post']['emailid']) ? $_SESSION['post']['emailid']: ''
                           ?>" onBlur="checkEmailExist();">
                        <a title="<?=EMAIL_TEXT
                           ?>" class="vtip" ><b><small>?</small></b></a>
                        <div id="error_emailid" class="error"></div>
                     </td>
                  </tr>
                  <tr>
                     <td align="left">Password (min. 6 characters)<span class='mandatory'>*</span></td>
                     <td align="left">
                        <INPUT class="text_field_new" type=password name="pwd" id="pwd"  value="<? echo isset($_SESSION['post']['pwd']) ? $_SESSION['post']['pwd'] :'' ?>">
                        <a  title="<?=PASS_TEXT ?>" class="vtip"><b><small>?</small></b></a><br/>
                        <div id="error_pwd" class="error"></div>
                     </td>
                  </tr>
                  <tr>
                     <td align="left">Verify Password<span class='mandatory'>*</span></td>
                     <td align="left">
                        <INPUT class="text_field_new" type=Password name="c_pwd" id="c_pwd" value="<?= isset($_SESSION['post']['pwd']) ? $_SESSION['post']['pwd'] : '' ?>">
                        <div id="error_c_pwd" class="error"></div>
                     </td>
                  </tr>
                  <tr style="display: none;">
                     <th height="50" colspan ="3" align="left" class="newstyletext">Verify that you are the owner of this email address:by clicking on
                        the link you just just received on your mailbox 
                     </th>
                  </tr>
                  <tr style="display: none;">
                     <td align="left">Enter your verification number:</td>
                     <td align="left">
                        <INPUT class="text_field_new" type=text name="verification_code" id="verification_code"  value="<?=$_SESSION['post']['verification_code'] ?>">
                        <div id="error_verification_code" class="error"></div>
                     </td>
                  </tr>
                  <tr>
                     <td align="left">First Name<span class='mandatory'>*</span></td>
                     <td align="left">
                        <INPUT class="text_field_new" type=text name="fname" id="fname"  value="<?= isset($_SESSION['post']['fname']) ? $_SESSION['post']['fname'] : '' ?>">
                        <a  title="<?=FIRST_TEXT ?>" class="vtip" ><b><small>?</small></b></a><br />
                        <div id="error_fname" class="error"></div>
                     </td>
                  </tr>
                  <tr>
                     <td align="left">Last Name<span class='mandatory'>*</span></td>
                     <td align="left">
                        <INPUT class="text_field_new" type=text name="lname" id="lname"  value="<?= isset($_SESSION['post']['lname']) ? $_SESSION['post']['lname'] : '' ?>">
                        <div id="error_lname" class="error"></div>
                     </td>
                  </tr>
                  <tr>
                     <td align="left">Country Phone Number Prefix<span class='mandatory'>*</span></td>
                     <td align="left">
                        <select class="text_field_new" style="width:406px; background-color:#e4e3dd; height:36px; margin-top:2px; margin-bottom:1px; border: 1px solid #abadb3;"  tabindex="27" id="cprefix" name="cprefix">
                           <option class="text_field_new" selected="" value="US">United States - 1</option>
                           <option value="93">Afghanistan - 93</option>
                           <option value="355">Albania - 355</option>
                           <option value="213">Algeria - 213</option>
                           <option value="1684">American Samoa - 1684</option>
                           <option value="376">Andorra - 376</option>
                           <option value="244">Angola - 244</option>
                           <option value="1264">Anguilla - 1264</option>
                           <option value="672">Antarctica - 672</option>
                           <option value="1268">Antigua And Barbuda - 1268</option>
                           <option value="54">Argentina - 54</option>
                           <option value="374">Armenia - 374</option>
                           <option value="297">Aruba - 297</option>
                           <option value="61">Australia - 61</option>
                           <option value="43">Austria - 43</option>
                           <option value="994">Azerbaijan - 994</option>
                           <option value="1242">Bahamas - 1242</option>
                           <option value="973">Bahrain - 973</option>
                           <option value="880">Bangladesh - 880</option>
                           <option value="1246">Barbados - 1246</option>
                           <option value="32">Belgium - 32</option>
                           <option value="501">Belize - 501</option>
                           <option value="229">Benin - 229</option>
                           <option value="1441">Bermuda - 1441</option>
                           <option value="975">Bhutan - 975</option>
                           <option value="591">Bolivia - 591</option>
                           <option value="387">Bosnia and Herzegovina - 387</option>
                           <option value="267">Botswana - 267</option>
                           <option value="55">Brazil - 55</option>
                           <option value="1284">British Indian Ocean Territory - 1284</option>
                           <option value="673">Brunei Darussalam - 673</option>
                           <option value="359">Bulgaria - 359</option>
                           <option value="226">Burkina Faso - 226</option>
                           <option value="257">Burundi - 257</option>
                           <option value="855">Cambodia - 855</option>
                           <option value="237">Cameroon - 237</option>
                           <option value="1">Canada - 1</option>
                           <option value="238">Cape Verde - 238</option>
                           <option value="1345">Cayman Islands - 1345</option>
                           <option value="236">Central African Republic - 236</option>
                           <option value="235">Chad - 235</option>
                           <option value="56">Chile - 56</option>
                           <option value="86">China - 86</option>
                           <option value="618">Christmas Island - 618</option>
                           <option value="61">Cocos (Keeling) Islands - 61</option>
                           <option value="57">Colombia - 57</option>
                           <option value="506">Costa Rica - 506</option>
                           <option value="385">Croatia (Hrvatska) - 385</option>
                           <option value="357">Cyprus - 357</option>
                           <option value="420">Czech Republic - 420</option>
                           <option value="45">Denmark - 45</option>
                           <option value="253">Djibouti - 253</option>
                           <option value="1767">Dominica - 1767</option>
                           <option value="1809">Dominican Republic - 1809</option>
                           <option value="670">East Timor - 670</option>
                           <option value="593">Ecuador - 593</option>
                           <option value="20">Egypt - 20</option>
                           <option value="503">El Salvador - 503</option>
                           <option value="240">Equatorial Guinea - 240</option>
                           <option value="291">Eritrea - 291</option>
                           <option value="372">Estonia - 372</option>
                           <option value="251">Ethiopia - 251</option>
                           <option value="298">Faroe Islands - 298</option>
                           <option value="679">Fiji - 679</option>
                           <option value="358">Finland - 358</option>
                           <option value="33">France - 33</option>
                           <option value="594">French Guiana - 594</option>
                           <option value="689">French Polynesia - 689</option>
                           <option value="241">Gabon - 241</option>
                           <option value="220">Gambia - 220</option>
                           <option value="995">Georgia - 995</option>
                           <option value="49">Germany - 49</option>
                           <option value="233">Ghana - 233</option>
                           <option value="350">Gibraltar - 350</option>
                           <option value="30">Greece - 30</option>
                           <option value="299">Greenland - 299</option>
                           <option value="1473">Grenada - 1473</option>
                           <option value="590">Guadeloupe - 590</option>
                           <option value="1671">Guam - 1671</option>
                           <option value="502">Guatemala - 502</option>
                           <option value="224">Guinea - 224</option>
                           <option value="592">Guyana - 592</option>
                           <option value="509">Haiti - 509</option>
                           <option value="39">Holy See (Vatican City State) - 39</option>
                           <option value="504">Honduras - 504</option>
                           <option value="582">Hong Kong SAR, PRC - 852</option>
                           <option value="36">Hungary - 36</option>
                           <option value="354">Iceland - 354</option>
                           <option value="91">India - 91</option>
                           <option value="62">Indonesia - 62</option>
                           <option value="353">Ireland - 353</option>
                           <option value="972">Israel - 972</option>
                           <option value="39">Italy - 39</option>
                           <option value="1876">Jamaica - 1876</option>
                           <option value="81">Japan - 81</option>
                           <option value="962">Jordan - 962</option>
                           <option value="7">Kazakhstan - 7</option>
                           <option value="254">Kenya - 254</option>
                           <option value="82">Korea, Republic of - 82</option>
                           <option value="965">Kuwait - 965</option>
                           <option value="996">Kyrgyzstan - 996</option>
                           <option value="856">Lao, People's Dem. Rep. - 856</option>
                           <option value="371">Latvia - 371</option>
                           <option value="961">Lebanon - 961</option>
                           <option value="266">Lesotho - 266</option>
                           <option value="218">Libya - 218</option>
                           <option value="423">Liechtenstein - 423</option>
                           <option value="370">Lithuania - 370</option>
                           <option value="352">Luxembourg - 352</option>
                           <option value="853">Macau - 853</option>
                           <option value="389">Macedonia - 389</option>
                           <option value="261">Madagascar - 261</option>
                           <option value="265">Malawi - 265</option>
                           <option value="60">Malaysia - 60</option>
                           <option value="960">Maldives - 960</option>
                           <option value="223">Mali - 223</option>
                           <option value="356">Malta - 356</option>
                           <option value="692">Marshall Islands - 692</option>
                           <option value="596">Martinique - 596</option>
                           <option value="222">Mauritania - 222</option>
                           <option value="230">Mauritius - 230</option>
                           <option value="52">Mexico - 52</option>
                           <option value="373">Moldova, Republic Of - 373</option>
                           <option value="377">Monaco - 377</option>
                           <option value="976">Mongolia - 976</option>
                           <option value="382">Montenegro - 382</option>
                           <option value="1664">Montserrat - 1664</option>
                           <option value="212">Morocco - 212</option>
                           <option value="258">Mozambique - 258</option>
                           <option value="264">Namibia - 264</option>
                           <option value="977">Nepal - 977</option>
                           <option value="31">Netherlands - 31</option>
                           <option value="599">Netherlands Antilles - 599</option>
                           <option value="687">New Caledonia - 687</option>
                           <option value="64">New Zealand - 64</option>
                           <option value="505">Nicaragua - 505</option>
                           <option value="227">Niger - 227</option>
                           <option value="234">Nigeria - 234</option>
                           <option value="672">Norfolk Island - 672</option>
                           <option value="47">Norway - 47</option>
                           <option value="968">Oman - 968</option>
                           <option value="92">Pakistan - 92</option>
                           <option value="970">Palestine - 970</option>
                           <option value="507">Panama - 507</option>
                           <option value="595">Paraguay - 595</option>
                           <option value="51">Peru - 51</option>
                           <option value="63">Philippines - 63</option>
                           <option value="48">Poland - 48</option>
                           <option value="351">Portugal - 351</option>
                           <option value="1787">Puerto Rico - 1787</option>
                           <option value="974">Qatar - 974</option>
                           <option value="262">Reunion - 262</option>
                           <option value="40">Romania - 40</option>
                           <option value="7">Russia - 7</option>
                           <option value="250">Rwanda - 250</option>
                           <option value="1869">Saint Kitts And Nevis - 1869</option>
                           <option value="1758">Saint Lucia - 1758</option>
                           <option value="1784">Saint Vincent And the Grenadines - 1784</option>
                           <option value="658">Samoa - 685</option>
                           <option value="378">San Marino - 378</option>
                           <option value="966">Saudi Arabia - 966</option>
                           <option value="221">Senegal - 221</option>
                           <option value="381">Serbia - 381</option>
                           <option value="248">Seychelles - 248</option>
                           <option value="232">Sierra Leone - 232</option>
                           <option value="65">Singapore - 65</option>
                           <option value="421">Slovak Republic - 421</option>
                           <option value="386">Slovenia - 386</option>
                           <option value="27">South Africa - 27</option>
                           <option value="34">Spain - 34</option>
                           <option value="94">Sri Lanka - 94</option>
                           <option value="508">St. Pierre And Miquelon - 508</option>
                           <option value="597">Suriname - 597</option>
                           <option value="268">Swaziland - 268</option>
                           <option value="46" selected="selected">Sweden - 46</option>
                           <option value="41">Switzerland - 41</option>
                           <option value="886">Taiwan, Province of China - 886</option>
                           <option value="992">Tajikistan - 992</option>
                           <option value="255">Tanzania, United Republic Of - 255</option>
                           <option value="66">Thailand - 66</option>
                           <option value="228">Togo - 228</option>
                           <option value="676">Tonga - 676</option>
                           <option value="1868">Trinidad And Tobago - 1868</option>
                           <option value="216">Tunisia - 216</option>
                           <option value="90">Turkey - 90</option>
                           <option value="993">Turkmenistan - 993</option>
                           <option value="1649">Turks And Caicos Islands - 1649</option>
                           <option value="256">Uganda - 256</option>
                           <option value="380">Ukraine - 380</option>
                           <option value="971">United Arab Emirates - 971</option>
                           <option value="44">United Kingdom - 44</option>
                           <option value="598">Uruguay - 598</option>
                           <option value="998">Uzbekistan - 998</option>
                           <option value="58">Venezuela - 58</option>
                           <option value="84">Vietnam - 84</option>
                           <option value="1284">Virgin Islands (British) - 1284</option>
                           <option value="1340">Virgin Islands (US) - 1340</option>
                           <option value="967">Yemen - 967</option>
                           <option value="260">Zambia - 260</option>
                        </select>
                        <div id='error_cprefix' class="error"></div>
                     </td>
                  </tr>
                  <tr>
                     <td align="left">Phone Number<span class='mandatory'>*</span></td>
                     <td align="left">
                        <INPUT class="text_field_new" type=text name="phone" id="phone"  value="<?= isset($_SESSION['post']['phone']) ? $_SESSION['post']['phone'] : '' ?>">
                        <a  title="<?=PHONE_TEXT ?>" class="vtip" ><b><small>?</small></b></a><br/>
                        <div id="error_phone" class="error"></div>
                     </td>
                  </tr>
                  <tr>
                     <td align="left">Mobile phone</td>
                     <td align="left">
                        <INPUT class="text_field_new" type=text name="mob" id="mob" value="<?= isset($_SESSION['post']['mob']) ? $_SESSION['post']['mob'] : '' ?>">
                        <div id="error_mobile" class="error"></div>
                     </td>
                  </tr>
                  <tr>
                     <td align="left" valign="top">Check the captcha<span class='mandatory'>*</span></td>
                     <td align="left">
                       <div class="g-recaptcha" data-sitekey="<?=$captcha_site_key?>"></div>
                        <div id="error_recaptcha" class="error"></div>
                     </td>
                  </tr>
                  <tr>
                     <td colspan="3">            </td>
                  </tr>
                  <tr align="center">
                     <td colspan="3" style="padding-left: 120px;">                            </td>
                  </tr>
                  <!-- <tr>
                      <th height="50" colspan ="3" align="center" class="newstyletext">
                         <input type="checkbox" name="terms" id="terms"> I agree to the <a href="#" onClick="WindowC()">Terms of Services and
                         Privacy Policy</a> for Dastjar service.
                         <div id="error_terms" class="error"></div>
                      </th>
                  </tr> -->
                  <tr>
                     <td height="37" align="center">                    </td>
                     <td height="37" align="left"><INPUT style="margin-left:160px;"  type="submit" name="Continue" value="Submit" class="button" id="Continue"></td>
                  </tr>
                  <tr>
                     <td height="15" colspan='3' align="left" ><span class='mandatory'>* These Fields Are Mandatory</span></td>
                  </tr>
                  <tr>
                     <td height="34" colspan='3' align="left" class="redgraybutton">2 Add Company</td>
                  </tr>
                  <!-- <tr align="center">
                     <td height="15" colspan='3' >&nbsp;</td>
                  </tr>
                  
                  <tr>
                     <td height="15" colspan='3' >&nbsp;</td>
                  </tr>
                  <tr>
                     <td height="33" colspan='3' align="left" class="redgraybutton">3 Add Subscription</td>
                  </tr> -->
                  <tr>
                     <td height="33" colspan='3' >&nbsp;</td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
   </form>
</div>
</td>
<? include("footer.php"); ?>
