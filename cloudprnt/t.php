<?php
function get_column_separated_data($columns)
{
	$total_columns = count($columns);
	
	if ($total_columns == 0) return "";
	if ($total_columns == 1) return $columns[0];
	if ($total_columns == 2)
	{
		$total_characters = strlen($columns[0])+strlen($columns[1]);
		$total_whitespace = MAX_CHARS - $total_characters;
		if ($total_whitespace < 0) return "";
		return $columns[0].str_repeat(" ", $total_whitespace).$columns[1];
	}
	
	$total_characters = 0;
	foreach ($columns as $column)
	{
		$total_characters += strlen($column);
	}
	$total_whitespace = MAX_CHARS - $total_characters;
	if ($total_whitespace < 0) return "";
	$total_spaces = $total_columns-1;
	$space_width = floor($total_whitespace / $total_spaces);
	$result = $columns[0].str_repeat(" ", $space_width);
	for ($i = 1; $i < ($total_columns-1); $i++)
	{
		$result .= $columns[$i].str_repeat(" ", $space_width);
	}
	$result .= $columns[$total_columns-1];
	
	return $result;
}

function get_seperator()
{
	return str_repeat('_', MAX_CHARS);
}

function get_padded_text($left_text, $right_text)
{
	$current_size = strlen($left_text) + strlen($right_text);
	$spaces = " ";
	for ($i = $current_size; $i < 19; $i++)
	{
		$spaces .= " ";
	}
	return $left_text . $spaces . $right_text;
}

function createPOSReceipt($printerMac)
{
	// echo 'createPOSReceipt: '.$printerMac; exit;
	define('MAX_CHARS', 32);

	include_once("printer_star_line.inc.php");

	$jobname = 'printerdata/'.str_replace(":", ".", $printerMac).'/print.txt';
	$printer = new Star_CloudPRNT_Star_Line_Mode_Job($printerMac, $jobname);

	// Header
	$printer->set_codepage("\x20\n");
	$printer->set_text_center_align();
	$printer->add_text_line("T2 Restaurant");
	$printer->add_text_line("TEL: 9999-99-9999\n");
	$printer->add_text_line("Order no.: #ABC123");
	$printer->add_text_line(get_seperator());

	// Cart Item
	$printer->set_text_right_align();
	$printer->set_text_emphasized();
	$printer->add_text_line(get_column_separated_data(array("1 Pizza Margarita", "80.00 kr")));
	$printer->add_text_line(get_column_separated_data(array("2 Stekt egg", "18.00 kr")));
	$printer->add_text_line(get_column_separated_data(array("1 Ryggbiff", "150.00 kr")));
	$printer->add_text_line(get_column_separated_data(array("2 Savenska kottbullar Kramig Savenska", "100.00 kr")));
	$printer->add_text_line(get_column_separated_data(array("1 Kramig Carbonara", "110.00 kr")));
	$printer->cancel_text_emphasized();
	$printer->add_text_line(get_seperator());

	// Total
	$printer->add_text_line("");
	$printer->set_text_right_align();
	$printer->add_text_line(get_padded_text("SUBTOTAL", "450.00 kr"));
	$printer->add_text_line(get_padded_text("VAT(20%)", "100.00 kr"));
	$printer->set_text_emphasized();
	$printer->add_text_line(get_padded_text("TOTAL", "550.00 kr"));
	$printer->cancel_text_emphasized();
	$printer->add_text_line(get_seperator());
	$printer->add_text_line("");

	// Footer
	$printer->set_text_center_align();
	$printer->add_text_line("Thank you for shopping at Star Groceries\n");
	$printer->add_text_line(get_seperator());
	$printer->add_text_line("");

	$printer->add_text_line("\n".date("d M Y")."\n".date("H:i")."\n");

	$printer->saveJob();
}

$mac = $_GET['mac'];
if ($mac == "") return;

if( isset($_GET['static']) )
{
	createPOSReceipt($mac);
}
else
{
	$printerDir = 'printerdata/'.str_replace(":", ".", $mac);
	if (!is_dir($printerDir)) mkdir($printerDir, 0755);
	$file = $printerDir.'/print.txt';
	$filename = fopen($file, "w") or die("Unable to open file!");

	$str = '';
	$str .= "\x1b\x1d\x74\x20  \n"; //enable utf-8 mode
	/*$str .= "                  Pizza City\n";
	$str .= "             22 North Bridge Road\n";
	$str .= "                   \n";
	$str .= "Order #11223                  \n";
	$str .= "                   \n";
	$str .= "   Item                                Price\n";
	$str .= "   __________________________________________\n";
	$str .= "\n";
	$str .= "        Thank you for using Pizza City";*/
	$str .= "\x1b\x64\x03"; //cuts paper

	// echo $str; exit;
	fwrite($filename, $str);
	fclose($filename);
}
?>