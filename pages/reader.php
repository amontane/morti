<?php
	include_once '../common/session-protection.php';
	$MORTI_body_class = 'reader folded';
	$MORTI_load_reader_scripts = true;
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
						<li><?=htmlspecialchars($list[$i][2])?> <?php if($list[$i][3]!=0){print('&nbsp;<span class="uni-tick">&#10004</span>');}?></li>
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
					<a href="#" onClick="openChapter(<?= $_kBugReportChapter;?>)"/>
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
			<a name="marker-start"/></a>
			<div id="chapter">
				<?php
					include '../actions/initial.php';
				?>
			</div>

			<a name="marker-comments"></a>
			<div id="comments">
			</div>
		</div>
		<div id="big-loading-layer" class="hidden">
			<div class="loader">
			</div>
		</div>
		<script>
			loadPerfectScrollbar();
		</script>

<?php	
	include '../common/footer.php';
?>