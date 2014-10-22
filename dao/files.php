<?php

	function display_chapter($chapter) {
		$chapterRoute = "../files/chapters/" . $chapter;
		$fh = fopen($chapterRoute, 'r')  or die ("Die!");

		while (!feof($fh)) {
			$theData = fgets($fh);
			// TODO: better handling of the error
			if (strlen($theData) > 1) {
				$theData = htmlspecialchars($theData);
				//TODO: special tag detection as well...
				echo("<p>" . $theData . "</p>\n");
			}
		}

		fclose($fh);
	}

	function display_additional($additional) {
		$additionalRoute = "../files/additional/" . $additional;
		$fh = fopen($additionalRoute, 'r')  or die ("Die!");

		while (!feof($fh)) {
			$theData = fgets($fh);
			// TODO: better handling of the error
			if (strlen($theData) > 1) {
				$theData = htmlspecialchars($theData);
				//TODO: special tag detection as well...
				echo("<p>" . $theData . "</p>\n");
			}
		}

		fclose($fh);
	}
?>