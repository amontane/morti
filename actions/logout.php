<?php
	include '../dao/user.php';

	perform_logout();
	header("Location: ../index.php");
?>