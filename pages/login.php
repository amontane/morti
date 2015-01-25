<?php
	$MORTI_body_class = 'login';
	include '../common/header.php';
?>	
		<img class="bgdiv" src="../img/mortibg.jpg" width="150%"/>
		<img class="logodiv" src="../img/morti.png" width="80%"/>
		<form id="login-form" method="POST" action="../index.php">
			<div class="form-container celldiv">
				<div class="form-row">
					<input class="field" type="text" name="login-uname" placeholder="E-mail">
				</div>
				<div class="form-row">
					<input class="field" type="password" name="login-pass" placeholder="Password">
				</div>
				<div class="form-row">
					<input class="button" type="submit" name="login-submit" value="Ok">
				</div>
			</div>
		</form>
<?php	
	include '../common/footer.php';
?>
