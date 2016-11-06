<?php
	function createTemporalDirectory($dir=false,$prefix='php') {
		$tempfile=tempnam(sys_get_temp_dir(),'');
		if (file_exists($tempfile)) {
			unlink($tempfile);
		}
		mkdir($tempfile);
		if (is_dir($tempfile)) { 
			return $tempfile; 
		}
	}

	function unlinkRecursive($dir, $deleteRootToo) {
		if ('/tmp/' != substr($dir, 0, 5)) {
			return;
		}

	    if(!$dh = @opendir($dir)) {
			return;
		}
		while (false !== ($obj = readdir($dh))) {
			if($obj == '.' || $obj == '..') {
				continue;
			}
			if (!@unlink($dir . '/' . $obj)) {
				unlinkRecursive($dir.'/'.$obj, true);
			}
		}
		closedir($dh);
		if ($deleteRootToo) {
			@rmdir($dir);
		}
	}

	function zipFileFromDirectory($dir, $fileName) {
		$zip = new ZipArchive();
		if ($zip->open($dir. "/" . $fileName, ZipArchive::CREATE)!==TRUE) {
			exit("cannot open <$filename>\n");
		}
		
		zipRecursiveAdd($dir, $zip, '');
		$zip->close();
	}

	function zipRecursiveAdd($dir, $zip, $relativeDir) {
		if(!$dh = @opendir($dir)) {
			return;
		}
		while (false !== ($obj = readdir($dh))) {
			if($obj == '.' || $obj == '..') {
				continue;
			}
			$route = $dir . '/' . $obj;
			$relDir = $relativeDir;
			if ($relDir != '') {
				$relDir = $relDir . "/";
			}
			if (is_file($route)) {
				$zip->addFile($route, $relDir . $obj);
			} else {
				zipRecursiveAdd($dir . '/' . $obj, $zip, $relDir . $obj);
			}
		}
		closedir($dh);
	}

	function downloadZipFile($folder, $fileName) {
		$fullPath = $folder . "/" . $fileName;
		header("Content-type: application/epub+zip"); 
		header("Content-Disposition: attachment; filename=" . $fileName);
		//header("Content-length: " . filesize($fullPath));
		//header("Pragma: no-cache"); 
		//header("Expires: 0");
		header('Content-Transfer-Encoding: binary');
		readfile($fullPath);
	}

?>