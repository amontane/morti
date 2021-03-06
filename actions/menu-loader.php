<?php
	include_once '../common/session-protection.php';
	include_once '../dao/mysql.php';

	$ident = $_GET["identifier"];
	
	if (isset($ident) && $ident != $_kBugReportChapter) {
		$chapter = get_chapter($ident);

		$author = $chapter[1];
		$title = $chapter[2];
		$additional = $chapter[4];

		echo ('<div class="side-menu-title">');

		if (isset($title)) {
			echo (htmlspecialchars($title));
		}

		if (isset($author)) {
			echo ('&nbsp;<div class="author">('. htmlspecialchars($author) . ')</div>');
		}

		echo ('</div>');
		
		echo ('<ul>');
		echo ('<a href="#" onClick="showMarkers(true)"><li>Fijar el punto de libro</li></a>');
		echo ('<a href="#" onClick="showCommentMarkers(true)"><li>Comentar un párrafo específico</li></a>');
		echo ('</ul>');

		echo ('<ul>');
		echo ('<a href="#marker-start" onClick="toggleIfMobile()"><li>Inicio del capítulo</li></a>');

		if (isset($additional)) {
			echo ('<a href="#marker-meanwhile" onClick="toggleIfMobile()"><li>Mientras tanto...</li></a>');
		}

		echo ('<a href="#marker-comments" onClick="toggleIfMobile()"><li>Comentarios</li></a>');
		echo ('<a href="#marker-newcomment"  onClick="toggleIfMobile()"><li>Nuevo comentario</li></a>');
		echo ('</ul>');
	}
?>