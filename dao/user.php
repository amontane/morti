<?php
	function perform_login($data) {
		if ($data && count($data) == 7) {
			$_SESSION["MORTI-mail"] = $data[0];
			$_SESSION["MORTI-username"] = $data[2];
			$_SESSION["MORTI-permissions"] = $data[3];
		}
	}

	function perform_logout() {
		if (isset($_SESSION["MORTI-permissions"])) {
			unset($_SESSION["MORTI-permissions"]);
		}
		if (isset($_SESSION["MORTI-username"])) {
			unset($_SESSION["MORTI-username"]);
		}
		if (isset($_SESSION["MORTI-mail"])) {
			unset($_SESSION["MORTI-mail"]);
		}
	}

	function is_valid_session() {
		if (isset($_SESSION["MORTI-username"])) {
			return true;
		}
		return false;
	}	
?>
