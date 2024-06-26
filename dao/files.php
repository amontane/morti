<?php

	function isDialog($line) {
		return (substr($line, 0, 1) == "-");
	}

	function substitute_hyphens($line) {
		$result = preg_replace("/(\w)-(\w)/", "$1&#8208;$2", $line);
		$result = preg_replace("/(\w)-(\w)/", "$1&#8208;$2", $result);
		$result = preg_replace("/-/","&mdash;",$result);
		return $result;
	}

	function substitute_quotes($line) {
		$result = preg_replace("/\"([^\"]*)\"/", "«$1»", $line);
		return $result;
	}

	function substitute_tags($line) {
		$result = preg_replace("/\[i\]([^\]]*)\[\/i\]/", "<span class=\"italic\">$1</span>", $line);
		return $result;
	}

	function display_chapter($chapter, $chapterId, $epub) {
		$chapterRoute = "../files/chapters/" . $chapter;
		$fh = fopen($chapterRoute, 'r')  or die ("Die!");
		$lastLineWasDialog = false;
		$markerNum = 1;
		$stopSeparator = "* * *";
		while (!feof($fh)) {
			$theData = fgets($fh);
			// TODO: better handling of the error
			if (strlen($theData) > 1) {
				if (substr($theData, 0, 5) === '[img]') {
					preg_match_all('/\[img\]name="(?P<name>[^"]*)" aspectratio="(?P<arw>[0-9]+):(?P<arh>[0-9]+)"/', $theData, $matches);
					$imgFilename = $matches["name"][0];
					if ($epub) {
						$imgFilename = "assets/" . $imgFilename;
					} else {
						$imgFilename = "../img/embed/" . $imgFilename;
					}
					echo ('<p><img alt="" style="width:100%" src="' . $imgFilename . '"/></p>');
				} else if (substr($theData, 0, 7) === '[quote]') {
					echo ('<div class="quote">');
					$stopSeparator = "&nbsp;";
				} else if (substr($theData, 0, 8) === '[/quote]') {
					echo ('</div>');
					$stopSeparator = "* * *";
				} else if (substr($theData, 0, 6) === '[long]') {
					echo ('<p class="longstop">' . $stopSeparator . '</p>');
				} else {
					$displayData = substitute_quotes($theData);
					$displayData = substitute_hyphens(htmlentities($displayData));
					$displayData = substitute_tags($displayData);
					if ($epub || (isDialog($theData) && $lastLineWasDialog)) {
						echo('<p class="short">' . $displayData . "</p>\n");
					} else {
						echo("<p>");
						echo ("<a name=\"paragraph_".$markerNum."\"/>");
						echo ("<a class=\"marker_setter\" href=\"#\" onClick=\"setMarker(".$chapterId. "," . $markerNum .")\"></a>");
						echo ("<a class=\"comment_paragraph\" href=\"#\" onClick=\"commentParagraph('".htmlspecialchars(trim_content($theData)). "'," . $markerNum .")\"></a>");
						echo ($displayData . "</p>\n");
						$markerNum++;
					}
					$lastLineWasDialog = isDialog($theData);					
				}

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

	function additional_title($ingame) {
		if ($ingame == 0) {
			return "Mientras tanto...";
		}
		return "Mientras tanto, en la partida...";
	}

	function additional_class($format) {
		if ($format == 1) {
			return "meanwhile email";
		}
		if ($format == 2) {
			return "meanwhile chat";
		}
		return "meanwhile";
	}

	function display_additional($additional, $format) {
		$additionalRoute = "../files/additional/" . $additional;
		$fh = fopen($additionalRoute, 'r')  or die ("Die!");

		while (!feof($fh)) {
			// TODO: better handling of the error
			$theData = htmlspecialchars(fgets($fh));
			
			if ($format == 0 && strlen($theData) > 1) {
				display_additional_standard($theData);
			} else if ($format == 1) {
				display_additional_email($theData);
			} else if ($format == 2 && strlen($theData) > 1) {
				display_additional_chat($theData);
			}
		}

		fclose($fh);
	}

	function display_additional_standard($line) {
		$pattern = "/\*(.*?)\*/";
		$replace = '<span class="gray">*$1*</span>';
		$line = preg_replace($pattern, $replace, $line);

		// TODO: special tag detection as well...
		echo("<p>&mdash;" . $line . "</p>\n");
	}

	function display_additional_email($line) {
		if (strlen($line) <= 1) {
			echo("<p>&nbsp;</p>");
		} else {
			$pattern = "/^([A-Za-z]*:)(.*)$/";
			$replace = '<b>$1</b>$2';
			$newLine = preg_replace($pattern, $replace, $line);

			if ($line == $newLine) {
				echo('<p>' . $newLine . "</p>\n");
			} else {
				echo('<p class="header">' . $newLine . "</p>\n");
			}
		}
	}

	function display_additional_chat($line) {
		if ($line[0] == '*') {
			echo('<p><span class="light">' . $line . '</span></p>');
		} else {
			$pattern = "/&lt;(@?)(.*?)&gt;/";
			$replace = '<b><span class="light">&lt;$1</span>$2<span class="light">&gt;</span></b>';
			$line = preg_replace($pattern, $replace, $line);

			echo("<p>" . $line . "</p>\n");
		}
	}

	function export_chapter($chapter, $pdf, $config) {
		$chapterRoute = "../files/chapters/" . $chapter;
		$fh = fopen($chapterRoute, 'r')  or die ("Die!");
		$lastLineWasDialog = false;
		$quoteMode = false;

		while (!feof($fh)) {
			$theData = fgets($fh);
			// TODO: better handling of the error
			if (strlen($theData) > 1) {
				if(!isDialog($theData) && !$quoteMode && $lastLineWasDialog) {
					$jump = $config["chapter_line_break_height"] - $config["chapter_dialog_line_break_height"];
					if ($jump > 0) {
						$pdf->Ln($jump);
					}
				}

				if (strlen($theData) > 1) {
					if (substr($theData, 0, 5) === '[img]') {
						preg_match_all('/\[img\]name="(?P<name>[^"]*)" aspectratio="(?P<arw>[0-9]+):(?P<arh>[0-9]+)"/', $theData, $matches);
						$imgFilename = $matches["name"][0];
						$arw = intval($matches["arw"][0]);
						$arh = intval($matches["arh"][0]);
						$imgHeight = (intval($config["img_width"]) * $arh) / $arw;
						if (($pdf->h) < $pdf->GetY() + 10.0 + $imgHeight) {
							$pdf->AddPage();
						}
						$pdf->WriteHTML('<img src="../img/embed/' . $imgFilename . '" width="' . $config["img_width"] . '" height="' . $imgHeight . '"/><br/>');
						$pdf->Ln($config["chapter_line_height"] + $config["chapter_dialog_line_break_height"] + $imgHeight);
					} else if (substr($theData, 0, 7) === '[quote]') {
						$quoteMode = true;
						$pdf->SetFont($config["chapter_font_face"],$config["chapter_quote_font_decoration"],$config["chapter_font_size"]);
					} else if (substr($theData, 0, 8) === '[/quote]') {
						$quoteMode = false;
						$pdf->SetFont($config["chapter_font_face"],$config["chapter_font_decoration"],$config["chapter_font_size"]);
					} else if (substr($theData, 0, 6) === '[long]') {
						$pdf->Ln($config["chapter_line_height"]);
					} else {
						$daData = str_replace("[i]", "", $theData);
						$daData = str_replace("[/i]", "", $daData);
						$pdf->Write($config["chapter_line_height"],iconv('UTF-8', 'ISO-8859-1',$daData));
						if(isDialog($theData) || $quoteMode) {
							$lastLineWasDialog = true;
							$pdf->Ln($config["chapter_dialog_line_break_height"]);
						} else {
							$lastLineWasDialog = false;
							$pdf->Ln($config["chapter_line_break_height"]);
						}
					}
				}
			}
		}

		fclose($fh);
	}

	function export_additional($additional, $format, $pdf, $config) {
		$additionalRoute = "../files/additional/" . $additional;
		$fh = fopen($additionalRoute, 'r')  or die ("Die!");

		while (!feof($fh)) {
			$theData = fgets($fh);
			// TODO: better handling of the error
			if ($format == 0 && strlen($theData) > 1) {
				//TODO: special tag detection as well...
				$pdf->Write($config["additional_line_height"],iconv('UTF-8', 'ISO-8859-1','-' . $theData));
				$pdf->Ln($config["additional_line_break_height"]);
			} else if ($format == 1) {
				$pdf->Write($config["additional_line_height"],iconv('UTF-8', 'ISO-8859-1',$theData));
				$pdf->Ln($config["additional_line_break_height"]);
			} else if ($format == 2 && strlen($theData) > 1) {
				$pdf->Write($config["additional_line_height"],iconv('UTF-8', 'ISO-8859-1',$theData));
				$pdf->Ln($config["additional_line_break_height"]);
			}
		}

		fclose($fh);
	}
?>