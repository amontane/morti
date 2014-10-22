<?php
	if (!isset($MORTI_title)) $MORTI_title = 'Los hijos de mortimer';
?>

<html>
	<head>
		<title><?=$MORTI_title?></title>
<?php if (isset($MORTI_load_scripts) && $MORTI_load_scripts) {?>
		<script src="../scripts/jquery-2.1.0.min.js"></script>
		<script src="../scripts/reader.js"></script>
<?php } ?>
		<link rel="stylesheet" type="text/css" href="../styles/fonts.css"/>
<?php if (isset($_SESSION["MORTI-mobileweb"]) && $_SESSION["MORTI-mobileweb"]) {?>
		<link rel="stylesheet" type="text/css" href="../styles/mobile_web.css" media="screen" />
<?php } else {?>
		<link rel="stylesheet" type="text/css" href="../styles/web.css" media="screen" />
<?php } ?>
	</head>
	<body<?php if(isset($MORTI_body_class)) {echo(' class="'.$MORTI_body_class.'"');}?>>
