<?php
	include_once 'constants.php';

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
		<!--  Responsive stuff  -->
		<link rel="stylesheet" type="text/css" href="../styles/mobile.css" media="screen and (max-device-width:400px)" />
		<link rel="stylesheet" type="text/css" href="../styles/mdpi.css" media="screen and (-webkit-min-device-pixel-ratio: 1)" />
		<link rel="stylesheet" type="text/css" href="../styles/hdpi.css" media="screen and (-webkit-min-device-pixel-ratio: 2)" />
		<link rel="stylesheet" type="text/css" href="../styles/xhdpi.css" media="screen and (-webkit-min-device-pixel-ratio: 3)" />
		<!--  End of responsive stuff. Boy wasn't this heavy -->
		<link rel="stylesheet" type="text/css" href="../styles/web.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="../scripts/perfect_scrollbar/perfect-scrollbar.min.css" media="screen" />
	</head>
	<body<?php if(isset($MORTI_body_class)) {echo(' class="'.$MORTI_body_class.'"');}?>>
		<a id="error-frame" href="#" name="Ok" onClick="javascript:feedbackFadeTrigger()" onMouseOver="javascript:feedbackMouseIn()" onMouseOut="javascript:feedbackMouseOut()"></a>
