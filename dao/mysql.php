<?php
	include 'credentials.php';
	
	function attempt_login ($email, $password) {
		$link = new mysqli('localhost', $GLOBALS["MORTI_mysql_user"], $GLOBALS["MORTI_mysql_pass"], $GLOBALS["MORTI_mysql_db"]) or die ('Die');
		mysqli_set_charset($link, "UTF8");
		// TODO: Error check?
		$query = "SELECT * FROM user WHERE email = '" . mysqli_real_escape_string($link, $email) . "' AND password = MD5('" . mysqli_real_escape_string($link, $password) . "')";
		$result = mysqli_query($link, $query);
		
		if ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			// TODO: convert row into a user
			return $row;
		}
		
		$_SESSION["MORTI_loginstatus"] = "error";
		return false;
	}
	
	function get_chapter_list() {
		$link = new mysqli('localhost', $GLOBALS["MORTI_mysql_user"], $GLOBALS["MORTI_mysql_pass"], $GLOBALS["MORTI_mysql_db"]) or die ('Die');
		mysqli_set_charset($link, "UTF8");
		// TODO: Error check?
		$query = "SELECT id,author,visible_title,reviewed FROM chapter ORDER BY id";
		$result = mysqli_query($link, $query);
		
		$table = array();
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$table[] = $row;
		}
		return $table;
	}

	function get_chapter($id) {
		$link = new mysqli('localhost', $GLOBALS["MORTI_mysql_user"], $GLOBALS["MORTI_mysql_pass"], $GLOBALS["MORTI_mysql_db"]) or die ('Die');
		mysqli_set_charset($link, "UTF8");
		// TODO: Error check?
		$query = "SELECT * FROM chapter where id = " . mysqli_real_escape_string($link, $id);
		$result = mysqli_query($link, $query);
		
		if ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			return $row;
		}

		return false;
	}

	function get_comments_for_chapter($id) {
		$link = new mysqli('localhost', $GLOBALS["MORTI_mysql_user"], $GLOBALS["MORTI_mysql_pass"], $GLOBALS["MORTI_mysql_db"]) or die ('Die');
		mysqli_set_charset($link, "UTF8");
		// TODO: Error check?
		$query = "SELECT c.id, u.email, u.username, u.avatar, c.chapter_id, c.text, c.date, c.paragraph, u.permissions, u.show_email FROM comment c, user u where u.email = c.author AND c.chapter_id = " . mysqli_real_escape_string($link, $id) . " order by c.date";
		$result = mysqli_query($link, $query);
		
		$table = array();
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$table[] = $row;
		}
		return $table;
	}

	function insert_comment($chapter, $comment, $author) {
		$link = new mysqli('localhost', $GLOBALS["MORTI_mysql_user"], $GLOBALS["MORTI_mysql_pass"], $GLOBALS["MORTI_mysql_db"]) or die ('Die');
		mysqli_set_charset($link, "UTF8");
		// TODO: Error check?
		$insert = "INSERT INTO comment (author, chapter_id, text, date) VALUES ('". mysqli_real_escape_string($link, $author).
			"', ".mysqli_real_escape_string($link, $chapter).", '".mysqli_real_escape_string($link, $comment)."', NOW())";

		if (mysqli_query($link, $insert) === TRUE) {
			$update = "UPDATE chapter SET last_comment=NOW() WHERE id=" . mysqli_real_escape_string($link, $chapter);
			mysqli_query($link, $update);
			return true;
		}
		return false;
	}

	function insert_paragraph_comment($chapter, $comment, $author, $paragraph) {
		$link = new mysqli('localhost', $GLOBALS["MORTI_mysql_user"], $GLOBALS["MORTI_mysql_pass"], $GLOBALS["MORTI_mysql_db"]) or die ('Die');
		mysqli_set_charset($link, "UTF8");
		// TODO: Error check?
		$insert = "INSERT INTO comment (author, chapter_id, text, date, paragraph) VALUES ('". mysqli_real_escape_string($link, $author).
			"', ".mysqli_real_escape_string($link, $chapter).", '".mysqli_real_escape_string($link,$comment)."', NOW(), " . mysqli_real_escape_string($link,$paragraph) .")";

		if (mysqli_query($link, $insert) === TRUE) {
			$update = "UPDATE chapter SET last_comment=NOW() WHERE id=" . mysqli_real_escape_string($link, $chapter);
			mysqli_query($link, $update);
			return true;
		}
		return false;
	}

	function change_password($new_pass) {
		$link = new mysqli('localhost', $GLOBALS["MORTI_mysql_user"], $GLOBALS["MORTI_mysql_pass"], $GLOBALS["MORTI_mysql_db"]) or die ('Die');
		mysqli_set_charset($link, "UTF8");
		// TODO: Error check?
		$update = "UPDATE user SET password=MD5('". mysqli_real_escape_string($link, $new_pass). "') WHERE email='" . mysqli_real_escape_string($link, $_SESSION["MORTI-mail"]) . "'";

		if (mysqli_query($link, $update) === TRUE) {
			return true;
		}
		return false;
	}

	function change_data($avatar, $uname, $new_pass) {
		$link = new mysqli('localhost', $GLOBALS["MORTI_mysql_user"], $GLOBALS["MORTI_mysql_pass"], $GLOBALS["MORTI_mysql_db"]) or die ('Die');
		mysqli_set_charset($link, "UTF8");
		// TODO: Error check?
		$update = "UPDATE user SET password=MD5('". mysqli_real_escape_string($link, $new_pass). "'),username='".mysqli_real_escape_string($link, $uname)."',avatar='".mysqli_real_escape_string($link, $avatar)."' WHERE email='" . mysqli_real_escape_string($link, $_SESSION["MORTI-mail"]) . "'";

		if (mysqli_query($link, $update) === TRUE) {
			return true;
		}
		return false;
	}

	function set_marker ($chapterId, $paragraph) {
		error_log("hola " . $chapterId . " " . $paragraph);
		$link = new mysqli('localhost', $GLOBALS["MORTI_mysql_user"], $GLOBALS["MORTI_mysql_pass"], $GLOBALS["MORTI_mysql_db"]) or die ('Die');
		mysqli_set_charset($link, "UTF8");
		// TODO: Error check?
		$update = "UPDATE user SET marker_chapter=". mysqli_real_escape_string($link, $chapterId). ", marker_paragraph=".mysqli_real_escape_string($link, $paragraph)." WHERE email='" . mysqli_real_escape_string($link, $_SESSION["MORTI-mail"]) . "'";
		error_log ("&& " . $update . " &&");
		if (mysqli_query($link, $update) === TRUE) {
			return true;
		}
		return false;
	}

	function get_marker() {
		$link = new mysqli('localhost', $GLOBALS["MORTI_mysql_user"], $GLOBALS["MORTI_mysql_pass"], $GLOBALS["MORTI_mysql_db"]) or die ('Die');
		mysqli_set_charset($link, "UTF8");
		// TODO: Error check?
		$query = "SELECT marker_chapter, marker_paragraph FROM user where email = '" . mysqli_real_escape_string($link, $_SESSION["MORTI-mail"]) . "' AND marker_chapter IS NOT NULL AND marker_paragraph IS NOT NULL";
		$result = mysqli_query($link, $query);
		
		if ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			return $row;
		}

		return false;
	}
?>
