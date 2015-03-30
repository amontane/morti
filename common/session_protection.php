<?php
	session_start();
	include_once '../dao/user.php';
	include_once 'constants.php';
	if (!is_valid_session()) {
		echo('<script>window.location = "../index.php?session_invalid"</script>');
	}
?>
