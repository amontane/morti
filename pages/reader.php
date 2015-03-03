<?php
	include_once '../common/session_protection.php';
	$MORTI_body_class = 'reader';
	$MORTI_load_scripts = true;
	include_once '../dao/mysql.php';
	include_once '../dao/user.php';
	include_once '../dao/files.php';
	include_once '../common/header.php';
?>

		<div id="side-menu">
			<div id="current_chapter_options" class="side-menu-section">
			</div>

			<div id="chapter_list" class="side-menu-section">
				<div class="side-menu-title">
					Cap&iacute;tulos
				</div>
				<ul>
<?php
	$list = get_chapter_list();
	for ($i=0; $i<sizeof($list); $i++) {
?>
					<a href='#' onClick='openChapter(<?=$list[$i][0]?>)'>
						<li><?=htmlspecialchars($list[$i][2])?></li>
					</a>
<?php
	}
?>
				</ul>
			</div>

			<div id="static_options" class="side-menu-section">
				<div class="side-menu-title">
					Opciones
				</div>
				<ul>
					<div id="marker_link_holder">
						<?php
						$markerRow = get_marker(); 
						if($markerRow) {
							echo ('<a href="#" onClick="openChapter('.$markerRow[0].','.$markerRow[1].')">');
							echo ('<li>Ir al punto de libro</li>');
							echo ('</a>');
						}?>
					</div>
					<a href="#" onClick="openChapter(<?= $GLOBALS["bugReportChapter"];?>)"/>
						<li class="important">Bug report</li>
					</a>
					<a href="#" onClick="show_profile()">
						<li>Perfil</li>
					</a>
					<a href="#" onClick="show_export()">
						<li>Exportar</li>
					</a>
					<a href="../actions/logout.php">
						<li>Logout</li>
					</a>
				</ul>
			</div>

		</div>
		<a id="toggle_button" href="#" onClick="toggle_side_menu()">
		</a>
		<div id="content-container">
			<a name="marker-start"/>
			<div id="chapter">
			</div>

			<a name="marker-comments"/>
			<div id="comments">
			</div>

			<a name="marker-newcomment"/>
		</div>

<?php	
	include '../common/footer.php';
?>