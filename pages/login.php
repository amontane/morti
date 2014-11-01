<?php
	$MORTI_body_class = 'login';
	include '../common/header.php';
?>	

		<form id="login-form" method="POST" action="../index.php">
			<div class="form-container">
				<div class="form-row">
					<input type="text" name="login-uname" placeholder="E-mail">
				</div>
				<div class="form-row">
					<input type="password" name="login-pass" placeholder="Password">
				</div>
					<input type="submit" name="login-submit" value="Ok">
				<div class="form-row">
				</div>
			</div>
		</form>

<?php	
	include '../common/footer.php';
?>
