<?php
	include '../fpdf/fpdf.php';
	include '../dao/files.php';
	include '../dao/mysql.php';

	function generateTimeStamp() {
		return date('dM_Hi');
	}

	function makePDF ($config) {
		$pdf = new FPDF('P','mm',$config["page_size"]);
		$pdf->AddFont('Almendra','','Almendra-Regular.php');
		addCover($pdf, $config);
		addChapter($pdf, $config, 1);
		addChapter($pdf, $config, 2);
		//$pdf->Output('morti_' . generateTimeStamp() .'.pdf','D');
		$pdf->Output();
	}

	function addCover ($pdf, $config) {
		$text1 = "Un tostón infinito e infumable";
		$text2 = "Escrito por un informático con sobrepeso";
		$text3 = "Una historia basada en hechos reales";
		$text4 = "En una partida de rol real, se entiende";
		$pdf->AddPage();
		$pdf->Image('../img/mortiporti.png',0,0,$config["cover_width"],$config["cover_height"]);
		$pdf->AddPage();
		$pdf->Image('../img/morti.png',$config["subcover_x"],$config["subcover_y"], $config["subcover_w"]);
		$pdf->SetFont('Almendra','',$config["subcover_font1"]);
		$pdf->Text($config["subcover_text1_x"], $config["subcover_text1_y"], iconv('UTF-8', 'ISO-8859-1',$text1));
		$pdf->SetFont('Almendra','',$config["subcover_font2"]);
		$pdf->Text($config["subcover_text2_x"], $config["subcover_text2_y"], iconv('UTF-8', 'ISO-8859-1',$text2));
		$pdf->SetFont('Almendra','',$config["subcover_font3"]);
		$pdf->Text($config["subcover_text3_x"], $config["subcover_text3_y"], iconv('UTF-8', 'ISO-8859-1',$text3));
		$pdf->SetFont('Almendra','',$config["subcover_font4"]);
		$pdf->Text($config["subcover_text4_x"], $config["subcover_text4_y"], iconv('UTF-8', 'ISO-8859-1',$text4));
	}

	function addChapter($pdf, $config, $chapterId) {

		$chapterInfo = get_chapter($chapterId);
		if ($chapterInfo) {
			$chapter = $chapterInfo[3];
			$additional = $chapterInfo[4];
			$title = $chapterInfo[2];
			$author = $chapterInfo[1];
		} else {
			return;
		}

		$pdf->AddPage();
		if (isset($title)) {
			$pdf->SetFont($config["chapter_title_font_face"],$config["chapter_title_font_decoration"],$config["chapter_title_font_size"]);
			$pdf->Write($config["chapter_title_line_break_height"],iconv('UTF-8', 'ISO-8859-1',$title));
		}

		if (isset($author)) {
			$pdf->Ln($config["chapter_title_spacing"]);
			$pdf->SetFont($config["chapter_author_font_face"],$config["chapter_author_font_decoration"],$config["chapter_author_font_size"]);
			$pdf->Write($config["chapter_author_line_break_height"],iconv('UTF-8', 'ISO-8859-1','Narrado por '.$author));
		}

		$pdf->Ln($config["before_chapter_spacing"]);

		if (isset($chapter)) {
			$pdf->SetFont($config["chapter_font_face"],$config["chapter_font_decoration"],$config["chapter_font_size"]);
			export_chapter($chapter,$pdf, $config);
		}

		if (isset($additional)) {
			$pdf->AddPage();
			$pdf->SetFont($config["meanwhile_font_face"],$config["meanwhile_font_decoration"],$config["meanwhile_font_size"]);
			$pdf->Write($config["meanwhile_line_height"],iconv('UTF-8', 'ISO-8859-1','Mientras tanto, en la partida...'));
			$pdf->Ln($config["meanwhile_line_break_height"]);

			$pdf->SetFont($config["additional_font_face"],$config["additional_font_decoration"],$config["additional_font_size"]);
			export_additional($additional,$pdf, $config);
		}
	}

	function generate_config() {
		$config = array();
		if (isset($_GET["ebook_mode"]) && $_GET["ebook_mode"] == "no") {
			$config["page_size"] = "A4";
			// TODO: non-ebook mode
		} else {
			$config["page_size"] = "A5";
			$config["cover_width"] = 150;
			$config["cover_height"] = 210;
			$config["subcover_x"] = 10;
			$config["subcover_y"] = 60;
			$config["subcover_w"] = 130;
			$config["subcover_font1"] = 22;
			$config["subcover_text1_x"] = 27;
			$config["subcover_text1_y"] = 94;
			$config["subcover_font2"] = 14;
			$config["subcover_text2_x"] = 34;
			$config["subcover_text2_y"] = 100;
			$config["subcover_font3"] = 11;
			$config["subcover_text3_x"] = 44;
			$config["subcover_text3_y"] = 105;
			$config["subcover_font4"] = 8;
			$config["subcover_text4_x"] = 52;
			$config["subcover_text4_y"] = 109;
			$config["chapter_title_font_face"] = "Arial";
			$config["chapter_title_font_decoration"] = "B";
			$config["chapter_title_font_size"] = 35;
			$config["chapter_title_line_height"] = 10;
			$config["chapter_title_line_break_height"] = 5;
			$config["chapter_title_spacing"] = 15;
			$config["chapter_author_font_face"] = "Arial";
			$config["chapter_author_font_decoration"] = "I";
			$config["chapter_author_font_size"] = 12;
			$config["chapter_author_line_height"] = 5;
			$config["chapter_author_line_break_height"] = 5;
			$config["before_chapter_spacing"] = 20;
			$config["chapter_font_face"] = "Arial";
			$config["chapter_font_decoration"] = "";
			$config["chapter_font_size"] = 14;
			$config["chapter_line_height"] = 5;
			$config["chapter_dialog_line_break_height"] = 1;
			$config["chapter_line_break_height"] = 5;
			$config["meanwhile_font_face"] = "Arial";
			$config["meanwhile_font_decoration"] = "I";
			$config["meanwhile_font_size"] = 20;
			$config["meanwhile_line_height"] = 5;
			$config["meanwhile_line_break_height"] = 15;
			$config["additional_font_face"] = "Arial";
			$config["additional_font_decoration"] = "";
			$config["additional_font_size"] = 13;
			$config["additional_line_height"] = 5;
			$config["additional_line_break_height"] = 1;
		}

		return $config;
	}
	
	makePDF(generate_config());
?>