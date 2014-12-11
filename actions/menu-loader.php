<?php
	include_once '../common/session_protection.php';
	include_once '../dao/mysql.php';

	$ident = $_GET["identifier"];
	
	if (isset($ident)) {
		$chapter = get_chapter($ident);

		$author = $chapter[1];
		$title = $chapter[2];
		$additional = $chapter[4];

		echo ('<div class="side-menu-title">');

		if (isset($title)) {
			echo (htmlspecialchars($title));
		}

		if (isset($author)) {
			echo ('<div class="author">('. htmlspecialchars($author) . ')</div>');
		}

		echo ('</div>');
		
		echo ('<ul>');
		echo ('<li><a href="#" onClick="showMarkers(true)">Fijar punto de libro</a></li>');
		echo ('<li><a href="#" onClick="showCommentMarkers(true)">Comentar párrafo específico</a></li>');
		echo ('</ul>');

		echo ('<ul>');
		echo ('<li><a href="#marker-start">Inicio</a></li>');

		if (isset($additional)) {
			echo ('<li><a href="#marker-meanwhile">Mientras tanto...</a></li>');
		}

		echo ('<li><a href="#marker-comments">Comentarios</a></li>');
		echo ('<li><a href="#marker-newcomment">Nuevo comentario</a></li>');
		echo ('</ul>');
	}
?>