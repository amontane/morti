<?php
	include '../fpdf/fpdf.php';
	include '../dao/files.php';

	function makePDF ($config) {
		$pdf = new FPDF('P','mm',$config["page_size"]);
		$pdf->SetFont('Arial','',16);
		addCover($pdf, $config);
		addChapter($pdf, $config, 1);
		addChapter($pdf, $config, 1);
		$pdf->Output();//'morti.pdf','D');
	}

	function addCover ($pdf, $config) {
		$pdf->AddPage();
		$pdf->Cell(40,10,'Portada!');
		$pdf->AddPage();
		$pdf->Cell(40,10,'Subportada!');
	}

	function addChapter($pdf, $config, $chapterId) {
		$chapter = "chapter1.txt";
		$additional = "chapter1.txt";
		// TODO: get chapter info from $chapterId. RIght now it's hardcoded

		if (isset($chapter)) {
			$pdf->AddPage();
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
			// TODO: non-mobile mode
		} else {
			$config["page_size"] = "A5";
			$config["chapter_font_face"] = "Arial";
			$config["chapter_font_decoration"] = "";
			$config["chapter_font_size"] = 14;
			$config["chapter_line_height"] = 5;
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