function openChapter(id, paragraph) {
	$.get("../actions/chapter-loader.php?identifier=" + id,
		function(data) {
			$("#chapter").html(data);
			loadComments(id);
			updateMenu(id);
			if (paragraph != undefined) {
				window.location.hash = '#paragraph_' + paragraph;
			} else {
				window.location.hash = '#marker-start';
			}
		}
	);
}

function updateMenu(id) {
	if (id) {
		$.get("../actions/menu-loader.php?identifier=" + id,
			function(data) {
				$("#current_chapter_options").html(data);
			}
		);
	} else {
		$("#current_chapter_options").html('');
	}
}

function loadComments(id) {
	$.get("../actions/comment-loader.php?chapterId=" + id,
		function(data) {
			$("#comments").html(data);
		}
	);	
}

function submitComment(chapterId) {
 	var text = $('#new_comment').val();
 	var paragraph = $('#related_paragraph_field').val();
 	$.post("../actions/comment-loader.php",
 		{chapter: chapterId, comment: text, paragraph: paragraph},
 		function(data) {
 			loadComments(chapterId);
 		}
 	);
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
			$("#comments").html('');
			updateMenu();
		}
	);
} 

function show_profile() {
	$.get("../actions/profile.php",
		function(data) {
			$("#chapter").html(data);
			$("#comments").html('');
			updateMenu();
		}
	);
}

function submitProfile() {
	var avatar = $("#avatar").val();
	var uname = $("#username").val();
	var new_pass = $("#new_pass").val();
	var conf_new_pass = $("#confirm_new_pass").val();
	var old_pass = $("#old_pass").val();
	$.post("../actions/profile.php",
		{avatar:avatar, uname:uname, new_pass:new_pass, conf_new_pass:conf_new_pass, old_pass:old_pass},
		function(data) {
			$("#chapter").html(data);
			$("#comments").html('');
		}
	);
}

function selectAllChapters() {
	$(".chapter-check").each(function () { this.checked = true; });
}

function exportPDF() {
	var ids = "";
	$(".chapter-check").each(function () {
		if (this.checked) {
			if (ids != "") {
				ids = ids+ ",";
			}
			ids = ids + this.value;
		}
	});
	window.location = "../actions/pdf-loader.php?ids=" + ids;
}

function setMarker (chapterId, markerNumber) {
		$.post("../actions/profile.php",
 		{marker_chapter: chapterId, marker_paragraph: markerNumber},
 		function(data) {
 			$("#marker_link_holder").html(data);
 		}
 	);
	showMarkers(false);
}

function showMarkers (show) {
	if (show) {
		$("body").addClass("show_markers");
		$("body").removeClass("show_comment_markers");
		setTimeout(function(){showMarkers(false);},5000);
	} else {
		$("body").removeClass("show_markers");
	}
}

function commentParagraph (summary, markerNumber) {
	// TODO: go to comment passing commented paragraph
	var content = '<div class="related_label">En referencia al p&aacute;rrafo: </div><div class="related_paragraph">&ldquo;' + summary + '&rdquo;</div>';
	content = content + '<input id="related_paragraph_field" type="hidden" value="' + markerNumber + '"/><a href="#" class="related_link" onClick="removeRelated()">Eliminar referencia</a>';
	$("#paragraph_container").html(content);
	window.location.hash = "#marker-newcomment";
	showCommentMarkers(false);
}

function removeRelated () {
	$("#paragraph_container").html("");
}

function showCommentMarkers (show) {
	if (show) {
		$("body").addClass("show_comment_markers");
		$("body").removeClass("show_markers");
		setTimeout(function(){showCommentMarkers(false);},5000);
	} else {
		$("body").removeClass("show_comment_markers");
	}
}