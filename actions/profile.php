<?php
	include_once '../common/session_protection.php';
	include_once '../dao/mysql.php';
	include_once '../dao/user.php';


	if (isset($_POST["old_pass"])) {
		$uname = $_POST["uname"];
		$avatar = $_POST["avatar"];
		$old_pass = $_POST["old_pass"];
		$new_pass = $_POST["new_pass"];
		$conf_new_pass = $_POST["conf_new_pass"];

		if (attempt_login($_SESSION["MORTI-mail"], $old_pass)) {
			$success = false;
			$successNoPass = false;
			if (user_is_master() || user_is_player()) {
				if (isset($new_pass) && $new_pass != '' && $conf_new_pass == $new_pass) {
					change_password($new_pass);
					$success = true;
				}
			} else {
				if (isset($new_pass) && $new_pass != '' && $conf_new_pass == $new_pass) {
					if (change_data($avatar, $uname, $new_pass)) {
						$_SESSION["MORTI-username"] = $uname;
						$_SESSION["MORTI-avatar"] = $avatar;
						$success = true;
					}
				} else {
					if (change_data($avatar, $uname, $old_pass)) {
						$_SESSION["MORTI-username"] = $uname;
						$_SESSION["MORTI-avatar"] = $avatar;
						$success = true;
						$successNoPass = true;
					}
				}
			}
			if ($successNoPass) {
				echo ('<feedbackMessage>' .$_kFeedbackMessages["profileOKmatch"]. '</feedbackMessage>'); 
			} else if ($success) {
				echo ('<feedbackMessage>' .$_kFeedbackMessages["profileOK"]. '</feedbackMessage>');
			} else {
				echo ('<feedbackError></feedbackError><feedbackMessage>' .$_kFeedbackMessages["profileNOK"]. '</feedbackMessage>'); 
			} 
		} else {
			echo ('<feedbackError></feedbackError><feedbackMessage>' .$_kFeedbackMessages["profileNOKpass"]. '</feedbackMessage>'); 
		}

	} else if (isset($_POST["marker_chapter"]) && isset($_POST["marker_paragraph"])) {
		$chapterId = $_POST["marker_chapter"];
		$paragraph = $_POST["marker_paragraph"];
		set_marker ($chapterId, $paragraph);
		echo ('<a href="#" onClick="openChapter('.$chapterId.','.$paragraph.')">');
		echo ('<li>Ir al punto de libro</li>');
		echo ('</a>');
		echo ('<feedbackMessage>'.htmlentities($_kFeedbackMessages["markerOK"]).'</feedbackMessage>');
		die();
	}
?>

	<div class="profile">
		<div class="page-title"><?=$_SESSION["MORTI-mail"]?></div>
		<div class="user-avatar-big">
			<img src="<?=$_SESSION["MORTI-avatar"]?>" height="200px" width="200px"/>
		</div>
		<div class="form-field">
			<div class="field-title">Nombre de usuario</div>
			<?php if(user_is_master() || user_is_player()) { ?>
			<div class="field-field"><input type="text" id="username" value="<?=$_SESSION["MORTI-username"]?>" disabled="disabled"/></div>
			<div class="field-description">Los usuarios con permisos especiales, como tú, no pueden cambiar el nombre</div>
			<?php } else { ?>
			<div class="field-field"><input type="text" id="username" value="<?=$_SESSION["MORTI-username"]?>"/></div>
			<?php } ?>
		</div>
		<div class="form-field">
			<div class="field-title">URL del avatar</div>
			<?php if(user_is_master() || user_is_player()) { ?>
			<div class="field-field"><input type="text" id="avatar" value="<?=$_SESSION["MORTI-avatar"]?>" disabled="disabled"/></div>
			<div class="field-description">Los usuarios con permisos especiales, como tú, no pueden cambiar el avatar</div>
			<?php } else { ?>
			<div class="field-field"><input type="text" id="avatar" value="<?=$_SESSION["MORTI-avatar"]?>"/></div>
			<?php } ?>
		</div>
		<div class="form-field">
			<div class="field-title">Nuevo password</div>
			<div class="field-field"><input type="password" id="new_pass"/></div>
		</div>
		<div class="form-field">
			<div class="field-title">Confirmar nuevo password</div>
			<div class="field-field"><input type="password" id="confirm_new_pass"/></div>
			<div class="field-description">Recuerda, hamijo, que los passwords tienen que coincidir</div>
		</div>
		<div class="form-field">
			<div class="field-title">Viejo password</div>
			<div class="field-field"><input type="password" id="old_pass"/></div>
			<div class="field-description">Necesario si quieres cambiar algun dato</div>
		</div>
		<input class="button" type="button" onClick="submitProfile()" value="Enviar"/>
	</div>