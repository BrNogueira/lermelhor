<?php
	class convertCharsetToUtf8
	{
		
		function convertCharsetToUtf8()
		{
		    
		}
		
		/**
		 * Convert string to requested character encoding
		 *
		 * @param string $in_charset : The input charset.
		 * @param string $out_charset :  The output charset. If you append the string //TRANSLIT to out_charset transliteration is activated.
		 *            This means that when a character can't be represented in the target charset
		 *           , it can be approximated through one or several similarly looking characters.
		 *            If you append the string //IGNORE, characters that cannot be represented in the target charset are silently discarded.
		 *            Otherwise, str is cut from the first illegal character and an E_NOTICE is generated.
		 *
		 * @param string $str : String for convert
		 * @return Returns String : the converted string 
		 * 			or FALSE Return String old string
		 */
		function iconv($in_charset, $out_charset, $str)
		{
			$convertValue = $str;
			
			if (function_exists('iconv') === true) {
				$convertValue = @iconv($in_charset, $out_charset, $str);
			}  elseif (function_exists('mb_convert_encoding') === true && function_exists('mb_internal_encoding') === true) {
				@mb_internal_encoding($in_charset);
				$convertValue = @mb_convert_encoding($str, $out_charset, $in_charset);
			} elseif (function_exists('utf8_decode') === true) {
				$convertValue = utf8_decode($str);
			}

			return $convertValue;
		}
		
		
		/**
		 * Iconv File - Convert file to requested charset encoding
		 *
		 * @param string $fileName : File for convert charset 
		 * @param string $inCharset : In charset
		 * @param string $outCharset : Out charset
		 * 
		 * @return TRUE;
		 */
		function iconvFile($fileName, $inCharset, $outCharset)
		{
			$iconv = '';
			if (is_file($fileName)) {
				$handle = @fopen($fileName, 'r');
				if ($handle) {
					while (!feof($handle)) {
						$buffer = fgets($handle, 4096);
						$iconv .= @convertCharsetToUtf8::iconv($inCharset, $outCharset, $buffer);
					}
				}
				$finaldata = $iconv;
				fclose($handle);
				
				$handle = @fopen($fileName, "w+");
				fwrite($handle, $finaldata);
				fclose($handle);

			} elseif(is_file($fileName) === false) {
				return true;
			}
			
			return true;
		}
		
		
		/**
		 * chkProjectSitebuiderVersion - Check create project sitebuilder 
		 *
		 * @param string $pathProject - Path project publish
		 * @return return boolean : - If create project at version 3 return TRUE
		 * 							- If create project at version 4 return FALSE , or not file exists version.txt  
		 * isProjectSitebuiderVersion
		 */
		function isSitebuiderVersion3($pathProject)
		{
			if (is_file($pathProject . "/version.txt")) {
				$version = file_get_contents($pathProject . "/version.txt");
				//$version = str_replace(' ', '', $version);
				//return (int)$version < 4 ? true : false;
				return (@preg_match("/3/i", $version)) ? true : false;
			} else {
			    return true;
			}			
			return false;
		}
		
		
		/**
		 * isFileComplete - Check path file complete from data file "complete.txt" 
		 *
		 * @param string $pathProject - Path project publish
		 * @param string $fileCompare - Full filename for compare data file complete.txt
		 * @return return boolean : - If $fileCompare macth data file complete.txt 
		 * 							  , or fileCompare match /RvSitebuilderPreview/ return TRUE
		 * 							- if $fileCompare not math data file complete.txt  
		 * 							  , or not file exists complete.txt return FALSE
		 */
		function isFileComplete($pathProject, $fileCompare)
		{
			$pathFileComplete = $pathProject . "/scripts/rvslib/convertCharset/rvsUtf8Config/complete.txt";
			$aListFileComplete = array();
			if (is_file($pathFileComplete) === true) {
				$aListFileComplete = file($pathFileComplete);
				foreach ($aListFileComplete as $k => $v) {
					$aListFileComplete[$k] = preg_replace("/\\r|\\n/","",$v);
				}
				$fileCompare = trim($fileCompare);
				if (count($aListFileComplete) && in_array($fileCompare, $aListFileComplete)) {
					return true;
				}
			}
			if (preg_match("/RvSitebuilderPreview/", $fileCompare)) {
				return true;
			}
			return false;
		}
		
		
		/**
		 * doIconvFileProject - Process iconv file project
		 *
		 * @param string $pathProject - Path project publish
		 * @param string $fileName    - Full filename for iconv
		 * @param string $outCharset  - Outcharset default "UTF-8//IGNORE"
		 * @return boolean
		 */
		function doIconvFileProject($publshPath, $fileName, $outCharset = "UTF-8//IGNORE")
		{
		    if (is_file($fileName .'.bak') === false) {
		        @copy($fileName, $fileName . '.bak');
		    }
		    
			if (convertCharsetToUtf8::isSitebuiderVersion3($publshPath) === true) {
				if (convertCharsetToUtf8::isFileComplete($publshPath, $fileName) === false) {
					if (is_file($publshPath . "/scripts/rvslib/convertCharset/nativeEncoding.txt") && is_file($fileName)) {

						//BackUp File Project
						@convertCharsetToUtf8::backUpFileProject($publshPath, $fileName);

						//Process iconvFile
						$inCharset = file($publshPath . "/scripts/rvslib/convertCharset/nativeEncoding.txt");
						@convertCharsetToUtf8::iconvFile($fileName, preg_replace("/\\r\\n/", "", $inCharset[0]), $outCharset);

						//Write File Complete
						@convertCharsetToUtf8::writePathConvertFileComplete($publshPath, $fileName);
					} elseif (!is_file($fileName)) {
						$str = "################## create file project at sitebuilder4 ##################" . "\r\n";
						$str .= $fileName . "\r\n";
						$str .= "########################################################################" . "\r\n";
						
						@convertCharsetToUtf8::writePathConvertFileComplete($publshPath, $str);
						
					}
				}
			}
		}
		
		/**
		 * backUpFileProject - Backup file Project before iconv file
		 *
		 * @param string $pathProject - Path project publish
		 * @param string $fileName - Full filename iconv for copy
		 */
		function backUpFileProject($pathProject, $fileName)
		{
			(!is_dir($pathProject . "/scripts/rvslib/convertCharset/rvsUtf8Backup")) 
				? @mkdir($pathProject . "/scripts/rvslib/convertCharset/rvsUtf8Backup", 0755, true) : '';

			$fileName = end(explode('/', $fileName));
			@copy($fileName, $pathProject . "/scripts/rvslib/convertCharset/rvsUtf8Backup/" . $fileName);
			
			//TODO fix file dataAsRaw
			//@copy($fileName, $pathProject . "/scripts/rvslib/convertCharset/rvsUtf8Backup/dataAsRaw.txt");
		}
		
		
		/**
		 * writePathConvertFileComplete - Write path file iconv complete
		 *
		 * @param string $pathProject - Path project publish
		 * @param string $fileName - Full filename iconv for write data full filename to complete.txt 
		 */
		function writePathConvertFileComplete($pathProject, $fileName)
		{
			if (file_exists($pathProject . "/scripts/rvslib/convertCharset/rvsUtf8Config") === false)  {
				@mkdir($pathProject . "/scripts/rvslib/convertCharset/rvsUtf8Config", 0755, true);
			}
			
			$handle = @fopen($pathProject . "/scripts/rvslib/convertCharset/rvsUtf8Config/complete.txt", "a");
			fwrite($handle, $fileName . "\r\n");
			fclose($handle);
		}

	}

?>