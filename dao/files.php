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
				echo("<li>" . $theData . "</li>\n");
			}
		}

		fclose($fh);
	}

	function export_chapter($chapter, $pdf, $config) {
		$chapterRoute = "../files/chapters/" . $chapter;
		$fh = fopen($chapterRoute, 'r')  or die ("Die!");

		while (!feof($fh)) {
			$theData = fgets($fh);
			// TODO: better handling of the error
			if (strlen($theData) > 1) {
				//TODO: special tag detection as well...
				$pdf->Write($config["chapter_line_height"],iconv('UTF-8', 'ISO-8859-1',$theData));
				$pdf->Ln($config["chapter_line_break_height"]);
			}
		}

		fclose($fh);
	}

	function export_additional($additional, $pdf, $config) {
		$additionalRoute = "../files/additional/" . $additional;
		$fh = fopen($additionalRoute, 'r')  or die ("Die!");

		while (!feof($fh)) {
			$theData = fgets($fh);
			// TODO: better handling of the error
			if (strlen($theData) > 1) {
				//TODO: special tag detection as well...
				$pdf->Write($config["additional_line_height"],iconv('UTF-8', 'ISO-8859-1','- ' . $theData));
				$pdf->Ln($config["additional_line_break_height"]);
			}
		}

		fclose($fh);
	}
?>