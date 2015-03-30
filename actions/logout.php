<?php
	session_start();
	include_once '../dao/user.php';

	perform_logout();
	$_SESSION["MORTI_loginstatus"] = "logout";

	header("Location: ../index.php");
?>