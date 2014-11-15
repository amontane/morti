function openChapter(id) {
	$.get("../actions/chapter-loader.php?identifier=" + id,
		function(data) {
			$("#chapter").html(data);
			loadComments(id);
		}
	);
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
 	$.post("../actions/comment-loader.php",
 		{chapter: chapterId, comment: text},
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
		}
	);
} 

function show_profile() {
	$.get("../actions/profile.php",
		function(data) {
			$("#chapter").html(data);
			$("#comments").html('');
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
	$(".chapter-check").attr("checked", true);
}

function exportPDF() {
	// TODO: gather parameters
	window.location = "../actions/pdf-loader.php?"; //TODO: pass parameters
}