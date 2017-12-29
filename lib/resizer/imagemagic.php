<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Gallery
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

class PhocaGalleryImageMagic
{
	/**
	* need GD library (first PHP line WIN: dl("php_gd.dll"); UNIX: dl("gd.so");
	* www.boutell.com/gd/
	* interval.cz/clanky/php-skript-pro-generovani-galerie-obrazku-2/
	* cz.php.net/imagecopyresampled
	* www.linuxsoft.cz/sw_detail.php?id_item=871
	* www.webtip.cz/art/wt_tech_php/liquid_ir.html
	* php.vrana.cz/zmensovani-obrazku.php
	* diskuse.jakpsatweb.cz/
	*
	* @param string $fileIn Vstupni soubor (mel by existovat)
	* @param string $fileOut Vystupni soubor, null ho jenom zobrazi (taky kdyz nema pravo se zapsat :)
	* @param int $width Vysledna sirka (maximalni)
	* @param int $height Vysledna vyska (maximalni)
	* @param bool $crop Orez (true, obrazek bude presne tak velky), jinak jenom Resample (udane maximalni rozmery)
	* @param int $typeOut IMAGETYPE_type vystupniho obrazku
	* @return bool Chyba kdyz vrati false
	*/
	public static function imageMagic($fileIn, $fileOut = null, $width = null, $height = null, $crop = null, $typeOut = null, $watermarkParams = array(), $frontUpload = 0, &$errorMsg) {

		//$params 		= JComponentHelper::getParams('com_phocagallery') ;
		// JPG Quality - - - - -
		$jpeg_quality	=85 ;
		if ((int)$jpeg_quality < 0) {
			$jpeg_quality = 0;
		}
		if ((int)$jpeg_quality > 100) {
			$jpeg_quality = 100;
		}
		// - - - - - - - - - - - -

		$fileWatermark = '';
		
		// While front upload we don't display the process page
		if ($frontUpload == 0) {
			$stopText = PhocaGalleryRenderProcess::displayStopThumbnailsCreating();
			echo $stopText;
		}
		// Memory - - - - - - - -
		$memory = 8;
		$memoryLimitChanged = 0;
		$memory = (int)ini_get( 'memory_limit' );
		if ($memory == 0) {
			$memory = 8;
		}
		// - - - - - - - - - - -

		if ($fileIn !== '' && file_exists($fileIn)) {
			
			// array of width, height, IMAGETYPE, "height=x width=x" (string)
	        list($w, $h, $type) = GetImageSize($fileIn);
			
			if ($w > 0 && $h > 0) {// we got the info from GetImageSize

		        // size of the image
		        if ($width == null || $width == 0) { // no width added
		            $width = $w;
		        }
				else if ($height == null || $height == 0) { // no height, adding the same as width
		            $height = $width;
		        }
				if ($height == null || $height == 0) { // no height, no width
		            $height = $h;
		        }
				
		        // miniaturizing
		        if (!$crop) { // new size - nw, nh (new width/height)
		            $scale = (($width / $w) < ($height / $h)) ? ($width / $w) : ($height / $h); // smaller rate
		            $src = array(0,0, $w, $h);
		            $dst = array(0,0, floor($w*$scale), floor($h*$scale));
		        }
		        else { // will be cropped
		            $scale = (($width / $w) > ($height / $h)) ? ($width / $w) : ($height / $h); // greater rate
		            $newW = $width/$scale;    // check the size of in file
		            $newH = $height/$scale;

		            // which side is larger (rounding error)
		            if (($w - $newW) > ($h - $newH)) {
		                $src = array(floor(($w - $newW)/2), 0, floor($newW), $h);
		            }
		            else {
		                $src = array(0, floor(($h - $newH)/2), $w, floor($newH));
		            }

		            $dst = array(0,0, floor($width), floor($height));
		        }
			
				
				// Watermark - - - - - - - - - - -
				if (!empty($watermarkParams) && ($watermarkParams['create'] == 1 || $watermarkParams['create'] == 2)) {
				
					$thumbnailSmall		= false;
					$thumbnailMedium	= false;
					$thumbnailLarge		= false;
					
					$thumbnailMedium	= preg_match("/medium-/i", $fileOut);
					$thumbnailLarge 	= preg_match("/large-/i", $fileOut);
					$thumbnailSmall 	= preg_match("/small-/i", $fileOut);
					$thumbnailThumb 	= preg_match("/thumb-/i", $fileOut);
					
					$path				= BASEPATH;
					$fileName 			= '';
					
					// Which Watermark will be used
					// If watermark is in current directory use it else use default
					$fileWatermarkSmall  	= str_replace($fileName, 'watermark-medium.png', $fileIn);
					$fileWatermarkThumb  	= str_replace($fileName, 'watermark-medium.png', $fileIn);
					$fileWatermarkMedium  	= str_replace($fileName, 'watermark-medium.png', $fileIn);
					$fileWatermarkLarge  	= 'watermark-large.gif';
					clearstatcache();
 
					// Which Watermark will be used
					if ($thumbnailMedium) {
						if (file_exists($fileWatermarkMedium)) {
								$fileWatermark  = $fileWatermarkMedium;
						} else {
							if ($watermarkParams['create'] == 2) {
								$fileWatermark  = $path.'images/watermark-medium.png';
							} else {
								$fileWatermark	= '';
							}
						}
						
					} else if ($thumbnailLarge) {
						if (file_exists($fileWatermarkLarge)) {
								$fileWatermark  = $fileWatermarkLarge;
						} else {
							if ($watermarkParams['create'] == 2) {
								$fileWatermark  = $path.'/images/watermark-large.gif';
							} else {
								$fileWatermark	= '';
							}
						}
					} else {
							$fileWatermark  = '';
					}
				 
					
					if (!file_exists($fileWatermark)) {
						$fileWatermark = '';
					}
					
					if ($fileWatermark != '') {
						list($wW, $hW, $typeW)	= GetImageSize($fileWatermark);
					 
						switch ($watermarkParams['x']) {
							case 'left':
								$locationX	= 0;
							break;
							
							case 'right':
								$locationX	= $dst[2] - $wW;
							break;
							
							case 'center':
							default:
								$locationX	= ($dst[2] / 2) - ($wW / 2);
							break;
						}
						
						switch ($watermarkParams['y']) {
							case 'top':
								$locationY	= 0;
							break;
							
							case 'bottom':
								$locationY	= $dst[3] - $hW;
							break;
							
							case 'middle':
							default:
								$locationY	= ($dst[3] / 2) - ($hW / 2);
							break;
						}
					}
				} else {
					$fileWatermark = '';
				}
			}
			

			
			if ($memory < 50) {
				ini_set('memory_limit', '50M');
				$memoryLimitChanged = 1;
			}
			// Resampling
			// in file
			
			// Watemark
			if ($fileWatermark != '') {
				if (!function_exists('ImageCreateFromPNG')) {
					$errorMsg = 'ErrorNoPNGFunction';
					return false;
				}
			 
				$waterImage1=ImageCreateFromGIF($fileWatermark);
			}
			// End Watermark - - - - - - - - - - - - - - - - - - 
			
	        switch($type) {
	            case IMAGETYPE_JPEG:
					if (!function_exists('ImageCreateFromJPEG')) {
						$errorMsg = 'ErrorNoJPGFunction';
						return false;
					}
					$image1 = ImageCreateFromJPEG($fileIn);
					break;
	            case IMAGETYPE_PNG :
					if (!function_exists('ImageCreateFromPNG')) {
						$errorMsg = 'ErrorNoPNGFunction';
						return false;
					}
					$image1 = ImageCreateFromPNG($fileIn);
					break;
	            case IMAGETYPE_GIF :
					if (!function_exists('ImageCreateFromGIF')) {
						$errorMsg = 'ErrorNoGIFFunction';
						return false;
					}
					$image1 = ImageCreateFromGIF($fileIn);
					break;
	            case IMAGETYPE_WBMP:
					if (!function_exists('ImageCreateFromWBMP')) {
						$errorMsg = 'ErrorNoWBMPFunction';
						return false;
					}
					$image1 = ImageCreateFromWBMP($fileIn);
					break;
	            default:
					$errorMsg = 'ErrorNotSupportedImage';
					return false;
					break;
	        }
			
			if ($image1) {

				$image2 = @ImageCreateTruecolor($dst[2], $dst[3]);
				if (!$image2) {
					$errorMsg = 'ErrorNoImageCreateTruecolor';
					return false;
				}
				
				switch($type) {
					case IMAGETYPE_PNG:
						//imagealphablending($image1, false);
						@imagealphablending($image2, false);
						//imagesavealpha($image1, true);
						@imagesavealpha($image2, true);
					break;
				}
				
				ImageCopyResampled($image2, $image1, $dst[0],$dst[1], $src[0],$src[1], $dst[2],$dst[3], $src[2],$src[3]);
				
				// Watermark - - - - - -
				if ($fileWatermark != '') {
					ImageCopy($image2, $waterImage1, $locationX, $locationY, 0, 0, $wW, $hW);
				}
				// End Watermark - - - -
				
				
	            // Display the Image - not used
	            if ($fileOut == null) {
	                header("Content-type: ". image_type_to_mime_type($typeOut));
	            }
				
				// Create the file
		        if ($typeOut == null) {    // no bitmap
		            $typeOut = ($type == IMAGETYPE_WBMP) ? IMAGETYPE_PNG : $type;
		        }
				
				switch($typeOut) {
		            case IMAGETYPE_JPEG:
						if (!function_exists('ImageJPEG')) {
							$errorMsg = 'ErrorNoJPGFunction';
							return false;
						}	
						if (!@ImageJPEG($image2, $fileOut, $jpeg_quality)) {
							$errorMsg = 'ErrorWriteFile';
							return false;
						}
						break;
		            case IMAGETYPE_PNG :
						if (!function_exists('ImagePNG')) {
							$errorMsg = 'ErrorNoPNGFunction';
							return false;
						}
						if (!@ImagePNG($image2, $fileOut)) {
							$errorMsg = 'ErrorWriteFile';
							return false;
						}
						break;
		            case IMAGETYPE_GIF :
						if (!function_exists('ImageGIF')) {
							$errorMsg = 'ErrorNoGIFFunction';
							return false;
						}
						if (!@ImageGIF($image2, $fileOut)) {
							$errorMsg = 'ErrorWriteFile';
							return false;
						}
						break;
		            default:
						$errorMsg = 'ErrorNotSupportedImage';
						return false;
						break;
				}
				
				// free memory
				ImageDestroy($image1);
	            ImageDestroy($image2);
				if (isset($waterImage1)) {
					ImageDestroy($waterImage1);
				}
	            
				if ($memoryLimitChanged == 1) {
					$memoryString = $memory . 'M';
					ini_set('memory_limit', $memoryString);
				}
	             $errorMsg = ''; // Success
				 return true;
	        } else {
				$errorMsg = 'Error1';
				return false;
			}
			if ($memoryLimitChanged == 1) {
				$memoryString = $memory . 'M';
				ini_set('memory_limit', $memoryString);
			}
	    }
		$errorMsg = 'Error2';
		return false;
	}
}
?>