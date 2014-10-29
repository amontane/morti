function openChapter(id) {
	$.get("../actions/chapter-loader.php?identifier=" + id,
		function(data) {
			$("#chapter").html(data);
		}
	);

	// TODO: load comments as well
}

function toggle_side_menu() {
	if ($("body").hasClass("folded")) {
		$("body").removeClass("folded");
	} else {
		$("body").addClass("folded");
	}
}

function show_export() {
	$.get("../actions/export.php",
		function(data) {
			$("#chapter").html(data);
		}
	);
} 

function selectAllChapters() {
	$(".chapter-check").attr("checked", true);
}

function exportPDF() {
	window.location = "../actions/pdf-loader.php?"; //TODO: pass parameters
}