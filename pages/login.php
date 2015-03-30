<?php
	$MORTI_body_class = 'login';
	include '../common/header.php';
?>	
		<img class="bgdiv" src="../img/mortibg.jpg" width="150%"/>
		<img class="logodiv" src="../img/morti-trans.png" width="80%"/>
		<form id="login-form" method="POST" action="../index.php">
			<div class="form-container celldiv">
				<div class="form-row">
					<input class="field" type="text" name="login-uname" placeholder="E-mail">
				</div>
				<div class="form-row">
					<input class="field" type="password" name="login-pass" placeholder="Password">
				</div>
				<div class="form-row">
					<input class="button" type="submit" name="login-submit" value="Login">
				</div>
			</div>
		</form>
<?php	
	if (isset($_GET["logout"])) {
		echo ("<script>showFeedback('" . htmlentities($_kFeedbackMessages["logout"]) . "')</script>");
	} else if (isset($_GET["error"])) {
		echo ("<script>showErrorFeedback('" . htmlentities($_kFeedbackMessages["loginError"]) . "')</script>");
	} else if (isset($_GET["session_invalid"])) {
		echo ("<script>showErrorFeedback('" . htmlentities($_kFeedbackMessages["sessionExpired"]) . "')</script>");
	}
	include '../common/footer.php';
?>
