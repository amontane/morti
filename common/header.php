<?php
	$GLOBALS["bugReportChapter"] = 1984;
	$GLOBALS["errorMessages"] = array();
	$GLOBALS["errorMessages"]["loginError"] = "El usuario o el password son incorrectos";

	if (!isset($MORTI_title)) $MORTI_title = 'Los hijos de mortimer';
?>

<html>
	<head>
		<title><?=$MORTI_title?></title>
		<script src="../scripts/jquery-2.1.0.min.js"></script>
		<script src="../scripts/feedback.js"></script>
<?php if (isset($MORTI_load_reader_scripts) && $MORTI_load_reader_scripts) {?>
		<script src="../scripts/reader.js"></script>
		<script src="../scripts/perfect_scrollbar/perfect-scrollbar.jquery.min.js"></script>
<?php } ?>
		<link rel="stylesheet" type="text/css" href="../styles/fonts.css"/>
<?php if (isset($_SESSION["MORTI-mobileweb"]) && $_SESSION["MORTI-mobileweb"]) {?>
		<link rel="stylesheet" type="text/css" href="../styles/mobile_web.css" media="screen" />
<?php } else {?>
		<link rel="stylesheet" type="text/css" href="../styles/web.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="../scripts/perfect_scrollbar/perfect-scrollbar.min.css" media="screen" />
<?php } ?>
	</head>
	<body<?php if(isset($MORTI_body_class)) {echo(' class="'.$MORTI_body_class.'"');}?>>
		<a id="error-frame" href="#" name="Ok" onClick="javascript:feedbackFadeTrigger()" onMouseOver="javascript:feedbackMouseIn()" onMouseOut="javascript:feedbackMouseOut()"></a>
