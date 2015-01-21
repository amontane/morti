<?php
	$GLOBALS["MORTI_mysql_user"] = 'mortimer';
	$GLOBALS["MORTI_mysql_pass"] = 'tonsasch1dt';
	$GLOBALS["MORTI_mysql_db"] = 'morti';
	
	function attempt_login ($email, $password) {
		$link = new mysqli('localhost', $GLOBALS["MORTI_mysql_user"], $GLOBALS["MORTI_mysql_pass"], $GLOBALS["MORTI_mysql_db"]) or die ('Die');
		// TODO: Error check?
		$query = "SELECT * FROM user WHERE email = '" . mysql_real_escape_string($email) . "' AND password = MD5('" . mysql_real_escape_string($password) . "')";
		$result = mysqli_query($link, $query);
		
		if ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			// TODO: convert row into a user
			return $row;
		}
		
		return false;
	}
	
	function get_chapter_list() {
		$link = new mysqli('localhost', $GLOBALS["MORTI_mysql_user"], $GLOBALS["MORTI_mysql_pass"], $GLOBALS["MORTI_mysql_db"]) or die ('Die');
		// TODO: Error check?
		$query = "SELECT id,author,visible_title FROM chapter ORDER BY id";
		$result = mysqli_query($link, $query);
		
		$table = array();
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$table[] = $row;
		}
		return $table;
	}

	function get_chapter($id) {
		$link = new mysqli('localhost', $GLOBALS["MORTI_mysql_user"], $GLOBALS["MORTI_mysql_pass"], $GLOBALS["MORTI_mysql_db"]) or die ('Die');
		// TODO: Error check?
		$query = "SELECT * FROM chapter where id = " . mysql_real_escape_string($id);
		$result = mysqli_query($link, $query);
		
		if ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			return $row;
		}

		return false;
	}

	function get_comments_for_chapter($id) {
		$link = new mysqli('localhost', $GLOBALS["MORTI_mysql_user"], $GLOBALS["MORTI_mysql_pass"], $GLOBALS["MORTI_mysql_db"]) or die ('Die');
		// TODO: Error check?
		$query = "SELECT c.id, u.email, u.username, u.avatar, c.chapter_id, c.text, c.date, c.paragraph FROM comment c, user u where u.email = c.author AND c.chapter_id = " . mysql_real_escape_string($id);
		$result = mysqli_query($link, $query);
		
		$table = array();
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$table[] = $row;
		}
		return $table;
	}

	function insert_comment($chapter, $comment, $author) {
		$link = new mysqli('localhost', $GLOBALS["MORTI_mysql_user"], $GLOBALS["MORTI_mysql_pass"], $GLOBALS["MORTI_mysql_db"]) or die ('Die');
		// TODO: Error check?
		$insert = "INSERT INTO comment (author, chapter_id, text, date) VALUES ('". mysql_real_escape_string($author).
			"', ".mysql_real_escape_string($chapter).", '".$comment."', NOW())";

		if (mysqli_query($link, $insert) === TRUE) {
			$update = "UPDATE chapter SET last_comment=NOW() WHERE id=" . mysql_real_escape_string($chapter);
			mysqli_query($link, $update);
			return true;
		}
		return false;
	}

	function insert_paragraph_comment($chapter, $comment, $author, $paragraph) {
		$link = new mysqli('localhost', $GLOBALS["MORTI_mysql_user"], $GLOBALS["MORTI_mysql_pass"], $GLOBALS["MORTI_mysql_db"]) or die ('Die');
		// TODO: Error check?
		$insert = "INSERT INTO comment (author, chapter_id, text, date, paragraph) VALUES ('". mysql_real_escape_string($author).
			"', ".mysql_real_escape_string($chapter).", '".$comment."', NOW(), " . $paragraph .")";

		if (mysqli_query($link, $insert) === TRUE) {
			$update = "UPDATE chapter SET last_comment=NOW() WHERE id=" . mysql_real_escape_string($chapter);
			mysqli_query($link, $update);
			return true;
		}
		return false;
	}

	function change_password($new_pass) {
		$link = new mysqli('localhost', $GLOBALS["MORTI_mysql_user"], $GLOBALS["MORTI_mysql_pass"], $GLOBALS["MORTI_mysql_db"]) or die ('Die');
		// TODO: Error check?
		$update = "UPDATE user SET password=MD5('". mysql_real_escape_string($new_pass). "') WHERE email='" . mysql_real_escape_string($_SESSION["MORTI-mail"]) . "'";

		if (mysqli_query($link, $update) === TRUE) {
			return true;
		}
		return false;
	}

	function change_data($avatar, $uname, $new_pass) {
		$link = new mysqli('localhost', $GLOBALS["MORTI_mysql_user"], $GLOBALS["MORTI_mysql_pass"], $GLOBALS["MORTI_mysql_db"]) or die ('Die');
		// TODO: Error check?
		$update = "UPDATE user SET password=MD5('". mysql_real_escape_string($new_pass). "'),username='".mysql_real_escape_string($uname)."',avatar='".mysql_real_escape_string($avatar)."' WHERE email='" . mysql_real_escape_string($_SESSION["MORTI-mail"]) . "'";

		if (mysqli_query($link, $update) === TRUE) {
			return true;
		}
		return false;
	}

	function set_marker ($chapterId, $paragraph) {
		error_log("hola " . $chapterId . " " . $paragraph);
		$link = new mysqli('localhost', $GLOBALS["MORTI_mysql_user"], $GLOBALS["MORTI_mysql_pass"], $GLOBALS["MORTI_mysql_db"]) or die ('Die');
		// TODO: Error check?
		$update = "UPDATE user SET marker_chapter=". mysql_real_escape_string($chapterId). ", marker_paragraph=".mysql_real_escape_string($paragraph)." WHERE email='" . mysql_real_escape_string($_SESSION["MORTI-mail"]) . "'";
		error_log ("&& " . $update . " &&");
		if (mysqli_query($link, $update) === TRUE) {
			return true;
		}
		return false;
	}

	function get_marker() {
		$link = new mysqli('localhost', $GLOBALS["MORTI_mysql_user"], $GLOBALS["MORTI_mysql_pass"], $GLOBALS["MORTI_mysql_db"]) or die ('Die');
		// TODO: Error check?
		$query = "SELECT marker_chapter, marker_paragraph FROM user where email = '" . mysql_real_escape_string($_SESSION["MORTI-mail"]) . "' AND marker_chapter IS NOT NULL AND marker_paragraph IS NOT NULL";
		$result = mysqli_query($link, $query);
		
		if ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			return $row;
		}

		return false;
	}
?>
