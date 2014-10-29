<?php
	include '../dao/mysql.php';
	include '../dao/files.php';

	$ident = $_GET["identifier"];
	if (isset($ident)) {
		$chapter = get_chapter($ident);

		$author = $chapter[1];
		$title = $chapter[2];
		$text = $chapter[3];
		$additional = $chapter[4];

		if (isset($title)) {
			echo ('<div class="chapter-title">' . htmlspecialchars($title) . '</div>');
		}

		if (isset($author)) {
			echo ('<div class="chapter-author">Narrado por ' . htmlspecialchars($author) . '</div>');
		}

		if (isset($text)) {
			echo ('<div class="chapter-content">');
			display_chapter($text);
			echo ('</div>');
		}

		if (isset($additional)) {
			echo ('<div class="meanwhile">Mientras tanto, en la partida de rol...</div>');
			echo ('<div class="additional-content">');
			echo ('<ul>');
			display_additional($additional);
			echo ('</ul>');
			echo ('</div>');
		}
	}
?>