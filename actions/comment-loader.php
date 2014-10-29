<?php
	include_once '../common/session_protection.php';
	include_once '../dao/mysql.php';

	if (isset($_GET["chapterId"])) {
		// First case: getting comments from a chapter id
		$comments = get_comments_for_chapter($_GET["chapterId"]);
		for ($i = 0; $i < sizeof($comments); $i++) {
			paint_comment($comments[$i]);
		}
	} else {
		echo("error!");
	}

	function paint_comment($coment_structure) {
		$commentId = $comment_structure[0];
		$username = $comment_structure[1];
		$avatar = $comment_structure[2];
		$chapterId = $comment_structure[3];
		$text = $comment_structure[4];
		$date = $comment_structure[5];
		$paragraph = $comment_structure[6];
	}
?>