<?php
/*  File Name : help.php
 *  Description : help file
 *  Author  : Deo  Date: 28th,nov,2010  Creation
 */

  // Page "registrationProcess.php"
define("EMAIL_TEXT","john@acne.com");
define("FIRST_TEXT","John");
define("PASS_TEXT","
Password should have atleast six characters, with atleast one number or one Upper case character");
define("PHONE_TEXT","Phone no.");

// Page  "addCompany.php"
define("CNAME_TEXT","Acne Inc..");
define("OCODE_TEXT","Enter organization code");
define("SADD_TEXT","Street Address");
define("CITYNAME_TEXT","City name");
define("ZCODE_TEXT","Enter zip code");
define("COUNTRY_TEXT","Country name");
define("LOWLEVEL_TEXT","The level when you like to be remembered that your account should be refilled");

// Page  "campaignOffer.php"
define("CLANGUAGE_TEXT","This lists the current languages available for the clients.  The selected language will be displayed depending on the client's settings.");
define("TITEL_TEXT","Your campaign title text is shown in the display list view.  Due to the size of the text only 19 characters may be displayed, so try to shorten down your message.  Preview your campaign title in the emulator below.");
define("DESCRIPTION_TEXT","Describes the offer itself on max two lines below the title in the list view.  Max 50 characters will fit into the 2 lines.  Preview your campaign description in the emulator below.");
define("PREP_TEXT","Add the time you want the consumer to see as the minimum time it takes to prepare this meal.");
define("CCATEGORY_TEXT","By selecting a category you choose under which tab the client will find your offer.  It is only possible to select one category.");
define("ICON_TEXT","Icon must be in png format only (e.g. icon.png).The size must be at least 45 x 60 pixels");
define("SPONSOR_TEXT","Sponsored campaigns will be listed in the top positions in the deal list when possible");
define("START_TEXT","The date should be the first date the campaign is visible for the customers.");
define("END_TEXT","The date should be the last date the campaign is visible for the customers.");
define("CAMPAIGNNAME_TEXT","The campaign name is used for support issues and help you find your campaign in the campaign list.  Select a unique name, for example: OrangeOffer_week_22-24.  This unique name is not displayed to your client.");
define("KEYWORD_TEXT","Add Search Keywords that you think describes your Campaign (max 90 characters)");
define("DEAL_VALID_FROM_TEXT","If your offer is only valid during a part of the day, this is the start time from when your offer is valid. For example: if you have a restaurant and only want the deal to be valid after rush hour and before evening, you can enter the start and stop time when you want the offer to be valid, ex: 14.00-17.00.");
define("DEAL_VALID_TO_TEXT","If your offer is only valid during a part of the day this is the stop time for your offer. For example: if you have a restaurant and only want the deal to be valid after rush hour and before evening, you can enter the start and stop time when you want the offer to be valid, ex: 14.00-17.00.");
define("DEAL_VALID_DAY_TEXT","If your offer is only valid during a part of the week this is were you select which days.");
define("CCODEHELP_TEXT","If you need the offer to have a key that should be read by the POS this is the place to enter it.  You can choose to use a manual code by selecting PIN code or an EAN code for image based barcode readers.");
define("CPICTURE_TEXT","Image must be in jpeg or png format only, e.g: image.png or image.jpg.  The size must be at least 247 x 130 pixels.");
define("LINK_TEXT","The content of this link will appear when the user selects the detailed campaign description and selects more info. Your page will appear under Product information.");


define("BRAND_TEXT","Add your brand name (max 15 characters)");
define("DISCOUNTVALUE_TEXT","Campaign Value for this campaign");



// Page  "advertiseOffer.php"
define("ATITEL_TEXT","Your advertise title text is shown in the display list view.  Due to the size of the text only 19 characters may be displayed, so try to shorten down your message.  Preview your advertise title in the emulator below.");
define("ADESCRIPTION_TEXT","Describes the offer itself on max two lines below the title in the list view.  Max 50 characters will fit into the 2 lines.  Preview your advertise description in the emulator below.");
define("ASPONSOR_TEXT","Sponsored advertise will be listed in the top positions in the deal list when possible");
define("ADVERTISENAME_TEXT","The advertise name is used for support issues and help you find your advertise in the advertise list.  Select a unique name, for example: OrangeOffer_week_22-24.  This unique name is not displayed to your client.");
define("AKEYWORD_TEXT","Add Search Keywords that you think describes your Advertise (max 90 characters)");
// new text for viewopt Kent
define("VIEWOPT_TEXT","Select Count Down for time left to offer terminates or Scrach Card for alternativ offer (max 90 characters)");
define("ASTART_TEXT","The date should be the first date the advertise is visible for the customers.");
define("AEND_TEXT","The date should be the last date the advertise is visible for the customers.");
define("ALINK_TEXT","The content of this link will appear when the user selects the detailed advertise description and selects more info. Your page will appear under Product information.");

// Page  "standardOffer.php"

define("SLANGUAGE_TEXT","This lists the current languages available for the clients.  The selected language will be displayed depending on the client's settings.");

define("SICON_TEXT","Icon must be in png format only, e.g: icon.png. The size must be at least 45 x 60 pixels.");
define("SPICTURE_TEXT","Image must be in jpeg or png format only(e.g. image.png or image.jpg).The size must be at least 247 x 130 pixels");
define("STITLE_TEXT","The name of your product. 
Due to the size of the text only 19 characters may be displayed, so try to shorten down your message.
Preview your product name in the emulator below.");
define("PRICE_TEXT","Add price");
define("SSPONSOR_TEXT","Sponsored Product will be listed in the top positions in the deal list when possible");
define("RELEASE_DATE_OF_PRODUCT","The date is be the first day the product is visible for the customers.");
define("SKEYWORD_TEXT","Keywords that describe your standard offer (max 90 characters)");
define("PRODUCTNAME_TEXT","The name of your product. Due to the size of the text only 19 characters may be displayed, so try to shorten down your message.Preview your product name in the emulator below.");
define("SCATEGORY_TEXT","By selecting a category you choose under which tab the client will find your offer. It is only possible to select one category.");
define("SDESCRIPTION_TEXT","Describes the offer itself on max two lines below the title in the list view.  Max 50 characters will fit into the 2 lines.  Preview your description in the emulator below.");
define("SLINK_TEXT","The content of this link will appear when the user select the detailed product description and selects more info. Your page will appear under Product information.");
define("BICON_TEXT","Image must be in jpeg or png format only, e.g: image.png or image.jpg. The size must be at least 247 x 130 pixels.");
define("PUBLIC_PRODUCT","This is if you are the product owner and want to make your product visible at locations selling your product, so that they may add your product to their offers.Add Location");
define("SEAN_TEXT","The EAN/GTIN code of your product.");
define("PRODUCTNUMBER_TEXT","If no EAN/GTIN code exists for your product, you may add a product number instead.");


// Page CreateStore.php

define("NAME_OF_LOCATION_TEXT","The name of your location, eg: 'My Store'.");
define("STORE_EMAIL_TEXT","The email address where your customer can reach you.");
define("LINK_TO_THE_LOCATION_HOME_TEXT","The content of this link will appear when the user select the detailed campaign/product description and selects more info. Your page will appear under Product information.");
define("PHONE_NUMBER_TEXT","The phone number where your customer can reach you.");
define("METHOD_FOR_RECEIVING_COUPON_DATA_TEXT","
Enter the methods your location support for receiving coupon data. When applicable the appropriate method will be used in your location.
1. DPS
Cumbari automatically transfers coupon data to the cash register
2. BARCODE
If your store has a barcode reader able to read from a mobile screen (a laser scanner normally can not do this but an image scanner might)
3. PINCODE
If you have a code to be be manually entered into the cash register
4. MANUAL SWIPE         
No code, the user just swipes the bar to agree to the use of the coupon        
5. TIME LIMIT
No code, the user just clicks on a button and has to use the coupon will within 5 minutes");        

define("STREET_ADDRESS_TEXT","The street address to your location.");
define("STORE_OPEN_CLOSE_TEXT","Select store open close Time.");
define("CITY_TEXT","The city or village of your location.");
define("COUNTRY_TEXT","The country of your location.");
define("CHAIN_TEXT","The chain to which your location belong.");
define("BLOCK_TEXT","If your chain belongs to a block, add the name of the block here.");
define("ZIP_TEXT","Your location's zip code.");
define("MAP_TEXT","Verify that your location is correctly placed on the map. If not, move the cursor on the map to the correct place.");
define("TYPE_OF_TEXT","Define if the restaurant is of type Take Away e.g Customer can order and take food with them or Catering e.g You take orders for customers to pick up later the same day or another day or both options fits.");
define("ONLINE_PAY_TEXT","Deselect if your location's should not accept web payment from stripe.");
define("STORE_CLOSE_TEXT","Select the days your loaction is closed.");
define("IMAGE_RESTAURANT","Upload an image to represent your location in users app.");





// Page  "standardStep.php"

define("CAMPAIGN_TEXT","Would you like to add a time limited Campaign Offer");
define("ADVERTISE_TEXT","Would you like to add an Advertise  Offer");
define("STANDARD_TEXT","Would you like to add a Standard Offer based on a product or a Service");

define("BRAND_REGISTER_SUCCESS","<li class='notice_success'>Your Brand has been registered successfully.</li>");
define("BRAND_REGISTER_FAIL","<li class='notice_error'>Your Brand has already been registered.</li>");
define("EDIT_ICON_SUCCESS","<li class='notice_success'>Your Brand has been successfully Updated.</li>");

//page "getFinancial.php"
define("ACCOUNT_VALUE"," Load your company account with your credit card");
define("BRANDICON_TEXT"," Icon must be in png format only (e.g. icon.png)");

//page "getFinancial.php"
define("BRAND_NAME","The brand name you want the customer to see when selecting the brand tab.");
//for add store through mail
define("CREATE_STORE_SUCCESS_MAIL","<li class='notice_success'>You have succesfully added your location now you can continue with this step.</li>");
define("NOW_LOGIN","<li class='notice_success'>Now You may Login with New Password.</li>");
define("CHECK_MAIL","<li class='notice_success'>Check your Mail.</li>");
define("WRONG_MAILID","Your e-mail id is incorrect");
//for support.php
define("CAT_NAME_ENG","Add category name in English");
define("CAT_NAME_SWE","Add category name in Swedish");
define("ICON","Icon must be in png format only (e.g. icon.png)");
define("COMP_NAME","Company name");
define("VERSION","Enter version");
define("CCODE_TEXT","Enter CCODE");
define("ACTIVE","Your CCODE are active");
define("DEACTIVE","Your CCODE are deactive");

define("ASSIGNCCODE","<li class='notice_success'>CCode are Assigned.</li>");
define("PRODUCT_NAME", "Product name");
define("PLAN_NICKNAME", "Plan nickname");
define("PRICE", "Price");
define("TRIAL_PERIOD", "Trial period in days (optional)");
define("CURRENCY", "Currency");

define("DESCRIPTION", "Description");
define("USAGE_TYPE", "Usage type");

?>
