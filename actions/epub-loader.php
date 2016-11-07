<?php
	include_once '../common/session_protection.php';
	include_once '../dao/system.php';
	include_once '../dao/files.php';
	include_once '../dao/mysql.php';

	function generateTimeStamp() {
		return date('dM_Hi');
	}

	function createChapters ($chapters, $tempdir, $tocFile, $tocHTMLFile, $opfFile) {
		$chapArray = explode(',',$chapters);
		$chapIds = [];
		$count = 6;
		foreach ($chapArray as &$chapterId) {
			$chapterTitle = createChapter($chapterId, $tempdir);
			$chapterInternalId = getChapterInternalId($chapterTitle);
			$chapIds[] = $chapterInternalId;
			fwrite($tocFile, '<navPoint id="'.$chapterInternalId.'" playOrder="'.$count.'"><navLabel><text>'. $chapterTitle .'</text></navLabel><content src="OEBPS/'. $chapterInternalId .'.html"/></navPoint>');
			fwrite($tocHTMLFile, '<li class="chapter-entry"><a href="'. $chapterInternalId .'.html"><span class="toc-chapter-title">'. $chapterTitle .'</span></a></li>');
			fwrite($opfFile, '<item id="'.$chapterInternalId.'" href="OEBPS/'. $chapterInternalId .'.html" media-type="application/xhtml+xml" />');
			$count++;
		}
		return $chapIds;
	}

	function createChapter ($chapterId, $tempdir) {
		$chapter = get_chapter($chapterId);
		$chFile = $chapter[3];
		$mwFile = $chapter[4];
		$chTitle = $chapter[2];
		$chAuthor = $chapter[1];

		$chapInternalId =  getChapterInternalId($chTitle);
		$filename = $tempdir . '/OEBPS/' . $chapInternalId . ".html";
		copy("../files/epub/chapter-template.html", $filename);
		$GLOBALS["OB_file"] = fopen($filename,'a');
		ob_start('writeCallback');
		echo ('<title>' . $chTitle . '</title>');
		echo ('</head><body>');
		echo ('<div class="title">' . $chTitle . '</div>');
		if ($chAuthor) {
			echo ('<div class="author">Narrado por ' . $chAuthor . '</div>');
		} else {
			echo ('<div class="author"></div>');
		}
		echo ('<div class="chapter">');
		display_chapter($chFile, $chapterId, true);
		echo ('</div>');
		if ($mwFile) {
			echo ('<div class="mw-header">Mientras tanto, en la partida...</div>');
			echo ('<div class="meanwhile"><ul>');
			display_additional($mwFile);
			echo ('</ul></div>');
		}
		echo ('</body></html>');
		ob_end_flush();
		fclose($GLOBALS["OB_file"]);
		return $chTitle;
	}

	function getChapterInternalId ($chapterTitle) {
		$fn = strtolower($chapterTitle);
		$fn = preg_replace(array('/í/','/ó/','/\s/'), array('i','o','-'), $fn);
		return $fn;
	}

	function writeCallback ($buffer) {
		fwrite($GLOBALS["OB_file"], $buffer);
	}

	function createSkeleton($tempdir) {
		mkdir($tempdir . "/META-INF");
		mkdir($tempdir . "/OEBPS");
		mkdir($tempdir . "/OEBPS/assets");
		copy("../files/epub/mimetype", $tempdir . "/mimetype");
		copy("../files/epub/book.opf", $tempdir . "/book.opf");
		copy("../files/epub/toc.ncx", $tempdir . "/toc.ncx");
		copy("../files/epub/container.xml", $tempdir . "/META-INF/container.xml");
		copy("../files/epub/com.apple.ibooks.display-options.xml", $tempdir . "/META-INF/com.apple.ibooks.display-options.xml");
		copy("../files/epub/table-of-contents.html", $tempdir . "/OEBPS/table-of-contents.html");
		copy("../files/epub/front-cover.html", $tempdir . "/OEBPS/front-cover.html");
		copy("../files/epub/inner-cover.html", $tempdir . "/OEBPS/inner-cover.html");
		copy("../files/epub/special-thanks.html", $tempdir . "/OEBPS/special-thanks.html");
		copy("../files/epub/dedicatoria.html", $tempdir . "/OEBPS/dedicatoria.html");
		copy("../styles/fonts/Iglesia.ttf", $tempdir . "/OEBPS/assets/Iglesia.ttf");
		copy("../styles/fonts/Tangerine_Regular.ttf", $tempdir . "/OEBPS/assets/Tangerine_Regular.ttf");
		copy("../styles/fonts/Merriweather-Regular.ttf", $tempdir . "/OEBPS/assets/Merriweather-Regular.ttf");
		copy("../styles/fonts/NightStillComes_mine_final_sample.otf", $tempdir . "/OEBPS/assets/NightStillComes.otf");
		copy("../styles/fonts/Vegur-Regular.otf", $tempdir . "/OEBPS/assets/Vegur-Regular.otf");
		copy("../styles/epub.css", $tempdir . "/OEBPS/epub.css");
	}

	function closeToc($tocFile) {
		fwrite($tocFile, "\t</navMap>\n");
		fwrite($tocFile, "</ncx>\n");
		fclose($tocFile);
	}

	function closeTocHTML($tocHTMLFile) {
		fwrite($tocHTMLFile, "\t\t\t</ul>\n");
		fwrite($tocHTMLFile, "\t\t</div>\n");
		fwrite($tocHTMLFile, "\t</body>\n");
		fwrite($tocHTMLFile, "</html>\n");
		fclose($tocHTMLFile);
	}

	function closeOpf($opfFile, $chapterIds) {
		fwrite ($opfFile, "\t</manifest>\n");
		fwrite ($opfFile, "\t<spine toc=\"ncx\">\n");
		fwrite ($opfFile, "\t\t<itemref idref=\"front-cover\" linear=\"no\" />\n");
		fwrite ($opfFile, "\t\t<itemref idref=\"inner-cover\" linear=\"yes\" />\n");
		fwrite ($opfFile, "\t\t<itemref idref=\"special-thanks\" linear=\"yes\" />\n");
		fwrite ($opfFile, "\t\t<itemref idref=\"table-of-contents\" linear=\"yes\" />\n");
		fwrite ($opfFile, "\t\t<itemref idref=\"dedicatory\" linear=\"yes\" />\n");
		foreach ($chapterIds as $chapterId) {
			fwrite ($opfFile, "\t\t<itemref idref=\"" . $chapterId ."\" linear=\"yes\" />\n");
		}
		fwrite ($opfFile, "\t</spine>\n");
		fwrite ($opfFile, "\t<guide>\n");
		fwrite ($opfFile, "\t\t<reference type=\"toc\" title=\"Table of Contents\" href=\"OEBPS/table-of-contents.html\" />\n");
		fwrite ($opfFile, "\t\t<reference type=\"cover\" title=\"cover\" href=\"OEBPS/front-cover.html\" />\n");
		fwrite ($opfFile, "\t\t<reference type=\"text\" title=\"start\" href=\"OEBPS/inner-cover.html\" />\n");
		fwrite ($opfFile, "\t</guide>\n");
		fwrite ($opfFile, "</package>");
		fclose($opfFile);
	}

	function attachImages($tempdir, $opfFile) {
		$refFile = fopen('../files/epub/extra-files', 'r')  or die ("Die!");
		while (!feof($refFile)) {
			$theData = fgets($refFile);
			$arr = explode(" ", $theData);
			$oldRoute = $arr[1] . $arr[2];
			$newRoute = "OEBPS/assets/" . $arr[2];
			copy($oldRoute, $tempdir . "/" . $newRoute);
			fwrite ($opfFile, "\t\t<item id=\"" . $arr[0] . "\" href=\"". $newRoute ."\" media-type=\"" . $arr[3] ."\" />");
		}
		fclose($refFile);
	}

	$chapters = $_GET["ids"];
	if (!isset($chapters)) $chapters = "";

	$tempdir = createTemporalDirectory();
	createSkeleton($tempdir);
	$tocFile = fopen($tempdir . '/toc.ncx', 'a')  or die ("Die!");
	$opfFile = fopen($tempdir . '/book.opf', 'a')  or die ("Die!");
	$tocHTMLFile = fopen ($tempdir . '/OEBPS/table-of-contents.html', 'a') or die ("Die!");
	attachImages($tempdir, $opfFile);

	$idArray = createChapters($chapters, $tempdir, $tocFile, $tocHTMLFile, $opfFile);
	// TODO: copy assets

	closeToc($tocFile);
	closeTocHTML($tocHTMLFile);
	closeOpf($opfFile, $idArray);

	$filename = 'morti_' . generateTimeStamp() .'.epub';
	zipFileFromDirectory($tempdir, $filename);
	downloadZipFile($tempdir, $filename);

	unlinkRecursive($tempdir, true);
?>