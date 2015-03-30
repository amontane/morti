<?php
	session_start();
	include_once 'dao/mysql.php';
	include_once 'dao/user.php';

	if (isset($_POST["login-uname"]) && isset($_POST["login-pass"])) {
		$result = attempt_login($_POST["login-uname"] , $_POST["login-pass"]);
		if ($result) {
			perform_login($result);
		}
	}
	$MORTI_loginstatus = $_SESSION["MORTI_loginstatus"];
	unset($_SESSION["MORTI_loginstatus"]);
	if (!isset ($MORTI_loginstatus)) $MORTI_loginstatus = "";
	if (!is_valid_session()) {
		header("Location: pages/login.php?" . $MORTI_loginstatus);
	} else {
		header("Location: pages/reader.php");
	}
?>
