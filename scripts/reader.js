function openChapter(id) {
	$.get("chapter-loader.php?identifier=" + id,
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