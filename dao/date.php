<?php
	function pretty_date($mysqlTS) {
		$dateObject = date_create($mysqlTS);
		return date_format($dateObject, 'd-m-Y H:i:s');
	}
?>
