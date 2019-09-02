<?php
$mac = $_GET['mac'];
if ($mac == "") return;

$file = 'printerdata/'.str_replace(":", ".", $mac).'/print.txt';
$filename = fopen($file, "w") or die("Unable to open file!");

$monsym = "\x80"; //euro symbol

fwrite($filename, "\x1b\x1d\x74\x20  \n"); //enable utf-8 mode

fwrite($filename, "                  Pizza City\n");

fwrite($filename, "             22 North Bridge Road\n");

fwrite($filename, "                London, NW1 5EV\n");

fwrite($filename, "                   \n");

fwrite($filename, "                   \n");

fwrite($filename, "   Order #11223                  \n");

fwrite($filename, "                   \n");

fwrite($filename, "   Item                                Price\n");

fwrite($filename, "   __________________________________________\n");

fwrite($filename, "   " . str_pad(isset($_COOKIE["sitetype"]) ? $_COOKIE["sitetype"] : 'sitetype'." Meal Deal",35) . "$monsym" ."9.99" . "\n");

fwrite($filename, "   " . str_pad(isset($_POST["pizza"]) ? $_POST["pizza"] : 'pizza',20) . "(Main)" . "\n");

fwrite($filename, "   " . str_pad(isset($_POST["drink"]) ? $_POST["drink"] : 'drink',20) . "(Drink)" . "\n");

fwrite($filename, "   " . str_pad(isset($_POST["sides"]) ? $_POST["sides"] : 'sides',20) . "(Sides)" . "\n");

fwrite($filename, "\n");

fwrite($filename, str_pad("",30) . "NET      ".  "$monsym" ."7.99\n");

fwrite($filename, str_pad("",30) . "VAT(20%) ". "$monsym" . "1.99\n");

fwrite($filename, str_pad("",30) . "TOTAL    ". "$monsym" . "9.99\n");

fwrite($filename, "\n");

fwrite($filename, "   Customer Details: \n");

fwrite($filename, "   ". 'yourname' ."\n");

fwrite($filename, "   ". 'housenum' ."\n");

fwrite($filename, "   ". 'street' ."\n");

fwrite($filename, "   ". 'city' ."\n");

fwrite($filename, "   ". 'postcode' ."\n");

fwrite($filename, "\n");

fwrite($filename, "   Payment Details\n");

fwrite($filename, "   ". "XXXX-XXXX-XXXX-". substr(4242424242424242,-4). "\n");

fwrite($filename, "\n");

fwrite($filename, "   datecheck  at timecheck\n");

fwrite($filename, "\n");

fwrite($filename, "        Thank you for using Pizza City");

fwrite($filename, "\n");

fwrite($filename, "\n");

fwrite($filename, "\x1b\x64\x00"); //cuts paper

// fwrite($filename, "\x07"); //opens cash drawer
?>