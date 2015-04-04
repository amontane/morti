<?php

	function isDialog($line) {
		return (substr($line, 0, 1) == "-");
	}

	function display_chapter($chapter, $chapterId) {
		$chapterRoute = "../files/chapters/" . $chapter;
		$fh = fopen($chapterRoute, 'r')  or die ("Die!");
		$lastLineWasDialog = false;
		$markerNum = 1;
		while (!feof($fh)) {
			$theData = fgets($fh);
			// TODO: better handling of the error
			if (strlen($theData) > 1) {
				$theData = htmlspecialchars($theData);
				//TODO: special tag detection as well...
				if (isDialog($theData) && $lastLineWasDialog) {
					echo('<p class="short">' . $theData . "</p>\n");
				} else {
					echo("<p>");
					echo ("<a name=\"paragraph_".$markerNum."\"/>");
					echo ("<a class=\"marker_setter\" href=\"#\" onClick=\"setMarker(".$chapterId. "," . $markerNum .")\"></a>");
					echo ("<a class=\"comment_paragraph\" href=\"#\" onClick=\"commentParagraph('".htmlspecialchars(trim_content($theData)). "'," . $markerNum .")\"></a>");
					echo ($theData . "</p>\n");
					$markerNum++;
				}
				$lastLineWasDialog = isDialog($theData);
			}
		}

		fclose($fh);
	}

	function trim_content ($content) {
		$numberOfWords = 7;
		$workingContent = str_replace("\n", " ", $content);
		$workingContent = str_replace("'", "\'", $workingContent);
		$contentArray = explode(" ", $workingContent);
		if (count($contentArray) <= $numberOfWords) {
			return $workingContent;
		}
		array_splice($contentArray, $numberOfWords);
		return implode(" ", $contentArray) . "...";
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
		$lastLineWasDialog = false;

		while (!feof($fh)) {
			$theData = fgets($fh);
			// TODO: better handling of the error
			if (strlen($theData) > 1) {
				//TODO: special tag detection as well...
				if(!isDialog($theData) && $lastLineWasDialog) {
					$jump = $config["chapter_line_break_height"] - $config["chapter_dialog_line_break_height"];
					if ($jump > 0) {
						$pdf->Ln($jump);
					}
				}
				$pdf->Write($config["chapter_line_height"],iconv('UTF-8', 'ISO-8859-1',$theData));
				if(isDialog($theData)) {
					$lastLineWasDialog = true;
					$pdf->Ln($config["chapter_dialog_line_break_height"]);
				} else {
					$lastLineWasDialog = false;
					$pdf->Ln($config["chapter_line_break_height"]);
				}
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