<?php
	include_once '../common/session-protection.php';
	include_once '../dao/mysql.php';
	include_once '../dao/files.php';

	$ident = $_GET["identifier"];
	$_SESSION["MORTI-selected-chapter"] = $ident;
	
	if (isset($ident)) {
		$author = null;
		$title = "Bug report";
		$text = "bugreport.txt";
		$additional = null;
		if ($ident != $_kBugReportChapter) {
			$chapter = get_chapter($ident);

			$author = $chapter[1];
			$title = $chapter[2];
			$text = $chapter[3];
			$additional = $chapter[4];
			$nextChapter = $chapter[8];
			$ingame = $chapter[9];
			$additional_format = $chapter[10];
		}

		if (isset($title)) {
			echo ('<div class="chapter-title">' . htmlspecialchars($title) . '</div>');
		}

		if (isset($author) && $author == '¿?') {
			echo ('<div class="chapter-author">Narrado por... ¿ ?</div>');
		}

		else if (isset($author)) {
			echo ('<div class="chapter-author">Narrado por ' . htmlspecialchars($author) . '</div>');
		}

		if (isset($text)) {
			echo ('<div class="chapter-content">');
			display_chapter($text, $ident, false);
			echo ('</div>');
		}

		if (isset($additional)) {
			echo ('<a name="marker-meanwhile"/>');
			echo ('<div class="meanwhile">' . additional_title($ingame) . '</div>');
			echo ('<div class="additional-content">');
			display_additional($additional);
			echo ('</div>');
		}

		if (isset($nextChapter)) {
			echo ('<input type="button" class="button" value="Ir al siguiente capitulo" onclick="openChapter('.$nextChapter.')"/>');
		}
	}
?>