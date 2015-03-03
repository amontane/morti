<?php
	session_start();
	include_once '../dao/user.php';
	$GLOBALS["bugReportChapter"] = 1984;
	if (!is_valid_session()) {
		echo('<script>window.location = "../index.php?session_invalid"</script>');
	}
?>
