<?php
	function perform_login($data) {
		if ($data && count($data) >= 5) {
			$_SESSION["MORTI-mail"] = $data[0];
			$_SESSION["MORTI-username"] = $data[2];
			$_SESSION["MORTI-permissions"] = $data[3];
			$_SESSION["MORTI-avatar"] = $data[4];
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
		if (isset($_SESSION["MORTI-avatar"])) {
			unset($_SESSION["MORTI-avatar"]);
		}
	}

	function is_valid_session() {
		if (isset($_SESSION["MORTI-username"])) {
			return true;
		}
		return false;
	}	

	function user_is_master() {
		return ($_SESSION["MORTI-permissions"] == 1);
	}

	function user_is_player() {
		return ($_SESSION["MORTI-permissions"] == 2);
	}
?>
