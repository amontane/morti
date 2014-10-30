<?php
	include_once '../common/session_protection.php';
	include_once '../dao/mysql.php';
	include_once '../dao/date.php';

	$bugReportChapter = 1984;

	if (isset($_GET["chapterId"])) {
		// First case: getting comments from a chapter id
		$comments = get_comments_for_chapter($_GET["chapterId"]);
		if (sizeof($comments) != 0) {
			echo('<div class="comments_title">Comentarios</div>');
			echo('<div class="comment_list_container">');
			for ($i = 0; $i < sizeof($comments); $i++) {
				paint_comment($comments[$i]);
			}
			echo ('</div>');
		}
		echo('<div class="comments_title">Dejar un comentario</div>');
		echo ('<textarea id="new_comment"></textarea>');
		echo ('<input type="button" value="enviar" onClick="submitComment(' . $_GET["chapterId"] . ')">');
	} else if (isset($_POST["comment"])) {
		$commentText = $_POST["comment"];
		$chapterId = $_POST["chapter"];
		if (isset($_POST["paragraph"])) {
			$paragraph = $_POST["paragraph"];
		}
		$author = $_SESSION["MORTI-mail"];
		if ($chapterId == $_SESSION["MORTI-selected-chapter"] || $chapterId == 1984) {
			if (!isset($paragraph) || $chapterId == 1984) {
				insert_comment($chapterId, $commentText, $author);
			} else {
				insert_paragraph_comment($chapterId, $comment, $author, $paragraph);
			}
		}
	} else {
		echo("error!");
	}

	function paint_comment($comment_structure) {
		$commentId = $comment_structure[0];
		$username = $comment_structure[1];
		$avatar = $comment_structure[2];
		$chapterId = $comment_structure[3];
		$text = $comment_structure[4];
		$date = $comment_structure[5];
		$paragraph = $comment_structure[6];

		echo ('<div class="comment_wrapper"><img class="avatar" src="' . $avatar . '" height="80px" width="80px" align="top"/>');
		echo ('<div class="username">'. htmlspecialchars($username) .'</div>');
		echo ('<div class="date">' . htmlspecialchars(pretty_date($date)) . '</div><br/>');
		if (isset($paragraph)) {
			// TODO: Set the link to the paragraph. (En referencia a este pàrrafo:)
		}
		echo ('<div class="comment">' . htmlspecialchars($text) . '</div></div>');
	}
?>