<?php

class payment_class {
    
	   var $last_error;                 // holds the last error encountered
   
  	   var $fields = array();           // array holds the fields to submit to DIBS

   
   function payment_class() {
       
      // initialization constructor.  Called when class is created.
      
//      $this->action_url = 'https://payment.architrade.com/paymentweb/start.action';
      
      $this->last_error = '';
      $this->ipn_log_file = 'ipn_log.txt';
      $this->ipn_log = true;
      $this->ipn_response = '';
      
            
   }
   
   function add_field($field, $value) {
      
     $this->fields["$field"] = $value;
   }

   function submit_payment_post() {
 
      echo "<html>\n";
      echo "<head><title>Processing Payment...</title></head>\n";
      echo "<body onLoad=\"document.form.submit();\">\n";
	  //echo "<body onLoad=\"\">\n";
      echo "<center><h3>Please wait, your order is being processed...</h3></center>\n";
      echo "<form method=\"post\" name=\"form\" action=\"".$this->action_url."\">\n";

      foreach ($this->fields as $name => $value) {
         echo "<input type=\"hidden\" name=\"$name\" value=\"$value\">";
      }
 
      echo "</form>\n";
      echo "</body></html>\n";
    
   }
 }
?>
