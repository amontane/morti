<?php
	include_once '../dao/mysql.php';
	include_once '../common/session-protection.php';
?>
	<div class="page-title">Exportar</div>
	<div class="export-section">
		<div class="section-title">
			Seleccionar cap&iacute;tulos
		</div>
		<div class="select-all">
			<a href="#" onClick="selectAllChapters()">Seleccionar<br/>todos</a>
		</div>
<?php
	$list = get_chapter_list();
	for ($i=0; $i<sizeof($list); $i++) {
?>
		<div>
			<input type="checkbox" class="chapter-check" value="<?=$list[$i][0]?>"/> <?=$list[$i][2]?> <br/>
		</div>
<?php
	}
?>
	</div>

	<!-- TODO: enable this option
	<div class="export-section">
		<input type="checkbox" class="ebook-check"/> Versi&oacute;n para ebook <br/>
	</div>-->

	<div class="export-submit">
		<input class="button" type="button" value="PDF" onClick="exportPDF()"/>
		<input class="button" type="button" value="EPUB" onClick="exportEPUB()"/>
	</div>