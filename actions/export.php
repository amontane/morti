<?php
	include '../dao/mysql.php';
?>
	<div class="export-section">
		Seleccionar cap&iacute;tulos (<a href="#" onClick="selectAllChapters()">seleccionar todos</a>)<br/>
<?php
	$list = get_chapter_list();
	for ($i=0; $i<sizeof($list); $i++) {
?>
		<input type="checkbox" class="chapter-check" value="<?=$list[$i][0]?>"/> <?=$list[$i][2]?> <br/>
<?php
	}
?>
	</div>

	<div class="export-section">
		<input type="checkbox" class="ebook-check"/> Versi&oacute;n para ebook <br/>
	</div>

	<div class="export-section">
		<input type="button" value="Exportar" onClick="exportPdf()"/>
	</div>