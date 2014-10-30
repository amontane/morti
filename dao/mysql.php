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
		$query = "SELECT c.id, u.username, u.avatar, c.chapter_id, c.text, c.date, c.paragraph FROM comment c, user u where u.email = c.author AND c.chapter_id = " . mysql_real_escape_string($id);
		$result = mysqli_query($link, $query);
		
		$table = array();
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$table[] = $row;
		}
		return $table;
	}
?>
