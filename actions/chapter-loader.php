<?php
	include_once '../common/session_protection.php';
	include_once '../dao/mysql.php';
	include_once '../dao/files.php';

	$ident = $_GET["identifier"];
	$_SESSION["MORTI-selected-chapter"] = $ident;
	
	if (isset($ident)) {
		$author = null;
		$title = "Bug report";
		$text = "bugreport.txt";
		$additional = null;
		if ($ident != $GLOBALS["bugReportChapter"]) {
			$chapter = get_chapter($ident);

			$author = $chapter[1];
			$title = $chapter[2];
			$text = $chapter[3];
			$additional = $chapter[4];
		}

		if (isset($title)) {
			echo ('<div class="chapter-title">' . htmlspecialchars($title) . '</div>');
		}

		if (isset($author)) {
			echo ('<div class="chapter-author">Narrado por ' . htmlspecialchars($author) . '</div>');
		}

		if (isset($text)) {
			echo ('<div class="chapter-content">');
			display_chapter($text, $ident);
			echo ('</div>');
		}

		if (isset($additional)) {
			echo ('<a name="marker-meanwhile"/>');
			echo ('<div class="meanwhile">Mientras tanto, en la partida de rol...</div>');
			echo ('<div class="additional-content">');
			echo ('<ul>');
			display_additional($additional);
			echo ('</ul>');
			echo ('</div>');
		}
	}
?>