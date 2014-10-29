<?php
	session_start();
	include_once '../dao/user.php';

	perform_logout();
	header("Location: ../index.php");
?>