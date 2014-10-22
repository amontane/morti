<?php
	include 'dao/mysql.php';
	include 'dao/user.php';

	if (isset($_POST["login-uname"]) && isset($_POST["login-pass"])) {
		$result = attempt_login($_POST["login-uname"] , $_POST["login-pass"]);
		if ($result) {
			perform_login($result);
		}
	}
	if (!isset ($MORTI_loginerror)) $MORTI_loginerror = "";
	if (!is_valid_session()) {
		header("Location: pages/login.php" . $MORTI_loginerror);
	} else {
		header("Location: pages/reader.php");
	}
?>
