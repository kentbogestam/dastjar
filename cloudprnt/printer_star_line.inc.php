<?php
	// include_once('printer_queue.inc.php');

	class Star_CloudPRNT_Star_Line_Mode_Job
	{
		const SLM_NEW_LINE_ASC = "\x0A";
		const SLM_SET_EMPHASIZED_ASC = "\x1B\x45";
		const SLM_CANCEL_EMPHASIZED_ASC = "\x1B\x46";
		const SLM_SET_LEFT_ALIGNMENT_ASC = "\x1B\x1D\x61\x00";
		const SLM_SET_CENTER_ALIGNMENT_ASC = "\x1B\x1D\x61\x01";
		const SLM_SET_RIGHT_ALIGNMENT_ASC = "\x1B\x1D\x61\x02";
		const SLM_FEED_FULL_CUT_ASC = "\x1B\x64\x02";
		const SLM_FEED_PARTIAL_CUT_ASC = "\x1B\x64\x03";
		const SLM_CODEPAGE_ASC = "\x1B\x1D\x74";
		
		private $printerMac;
		private $tempFilePath;
		private $printJobBuilder = "";
		
		public function __construct($printerMac, $tempFilePath)
		{
			$this->printerMac = $printerMac;
			$this->tempFilePath = $tempFilePath;
			$printJobBuilder = "";
		}
		
		private function str_to_hex($string)
		{
			$hex = '';
			for ($i = 0; $i < strlen($string); $i++)
			{
				$ord = ord($string[$i]);
				$hexCode = dechex($ord);
				$hex .= substr('0'.$hexCode, -2);
			}
			return strToUpper($hex);
		}
		
		public function set_text_emphasized()
		{
			$this->printJobBuilder .= self::SLM_SET_EMPHASIZED_ASC;
		}
		
		public function cancel_text_emphasized()
		{
			$this->printJobBuilder .= self::SLM_CANCEL_EMPHASIZED_ASC;
		}
		
		public function set_text_left_align()
		{
			$this->printJobBuilder .= self::SLM_SET_LEFT_ALIGNMENT_ASC;
		}
		
		public function set_text_center_align()
		{
			$this->printJobBuilder .= self::SLM_SET_CENTER_ALIGNMENT_ASC;
		}
		
		public function set_text_right_align()
		{
			$this->printJobBuilder .= self::SLM_SET_RIGHT_ALIGNMENT_ASC;
		}
		
		public function set_codepage($codepage)
		{
			$this->printJobBuilder .= self::SLM_CODEPAGE_ASC.$codepage;
		}
		
		public function add_nv_logo($keycode)
		{
			$this->printJobBuilder .= "1B1C70".$keycode."00".self::SLM_NEW_LINE_ASC;
			//$this->printJobBuilder .= "1B1D384C06000000304530320101".self::SLM_NEW_LINE_ASC;
		}
		
		public function add_hex($hex)
		{
			$this->printJobBuilder .= $hex;
		}
		
		public function add_text($text)
		{
			$this->printJobBuilder .= $text;
		}
		
		public function add_text_line($text)
		{
			$this->printJobBuilder .= $text.self::SLM_NEW_LINE_ASC;
		}
		
		public function add_new_line($quantity)
		{
			for ($i = 0; $i < $quantity; $i++)
			{
				$this->printJobBuilder .= self::SLM_NEW_LINE_ASC;
			}
		}
		
		public function add_code128_barcode($barcode)
		{
			$this->add_hex("1B6206020180");
			$this->add_text($barcode);
			$this->add_hex("1E");
		}

		public function saveJob()
		{
			$printJobBuilder = $this->printJobBuilder.self::SLM_FEED_PARTIAL_CUT_ASC;
			echo $printJobBuilder;
			// exit;
			$fh = fopen($this->tempFilePath, 'w');
			fwrite($fh, $printJobBuilder);
			fclose($fh);
		}
		
		public function printjob()
		{
			$fh = fopen($this->tempFilePath, 'w');
			fwrite($fh, hex2bin($this->printJobBuilder.self::SLM_FEED_PARTIAL_CUT_ASC."07"));
			fclose($fh);
			queue_addPrintJob($this->printerMac, $this->tempFilePath);
			unlink($this->tempFilePath);
		}
	}
?>