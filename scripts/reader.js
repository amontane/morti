function isMobile() {
	return window.matchMedia('(max-device-width: 420px)').matches;
}

function toggleIfMobile() {
	if (isMobile()) {
		toggle_side_menu();
	}
}

function openChapter(id, paragraph) {
	loader = document.getElementById("big-loading-layer");
	removeClass(loader, "hidden");
	ajaxGet("../actions/chapter-loader.php?identifier=" + id,
		function(data) {
			chap = document.getElementById("chapter");
			chapter.innerHTML = data;
			loadComments(id);
			updateMenu(id);
			addClass(loader, "hidden");
			toggleIfMobile();
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
		ajaxGet("../actions/menu-loader.php?identifier=" + id,
			function(data) {
				document.getElementById("current_chapter_options").innerHTML = data;
			}
		);
	} else {
		document.getElementById("current_chapter_options").innerHTML = '';
	}
}

function loadComments(id) {
	ajaxGet("../actions/comment-loader.php?chapterId=" + id,
		function(data) {
			document.getElementById("comments").innerHTML = data;
		}
	);	
}

function submitComment(chapterId) {
 	var text = document.getElementById("new_comment").value;
 	var paragraph;
 	var paragField = document.getElementById("related_paragraph_field");
 	if (paragField) {
 		paragraph = paragField.value;
 	}
 	ajaxPost("../actions/comment-loader.php",
 		{chapter: chapterId, comment: text, paragraph: paragraph},
 		function(data) {
 			decodeResponseForFeedback(data);
 			loadComments(chapterId);
 		}
 	);
}

function toggle_side_menu() {
	if (hasClass(document.body, "folded")) {
		removeClass(document.body, "folded");
	} else {
		addClass(document.body, "folded");
	}
}

function show_export() {
	ajaxGet("../actions/export.php",
		function(data) {
			document.getElementById("chapter").innerHTML = data;
			document.getElementById("comments").innerHTML = '';
			updateMenu();
			toggleIfMobile();
		}
	);
} 

function show_profile() {
	ajaxGet("../actions/profile.php",
		function(data) {
			document.getElementById("chapter").innerHTML = data;
			document.getElementById("comments").innerHTML = '';
			updateMenu();
			toggleIfMobile();
		}
	);
}

function submitProfile() {
	var avatar = document.getElementById("avatar").value;
	var uname = document.getElementById("username").value;
	var new_pass = document.getElementById("new_pass").value;
	var conf_new_pass = document.getElementById("confirm_new_pass").value;
	var old_pass = document.getElementById("old_pass").value;
	ajaxPost("../actions/profile.php",
		{avatar:avatar, uname:uname, new_pass:new_pass, conf_new_pass:conf_new_pass, old_pass:old_pass},
		function(data) {
			decodeResponseForFeedback(data);
			document.getElementById("chapter").innerHTML = data;
			document.getElementById("comments").innerHTML = '';
		}
	);
}

function selectAllChapters() {
	var allChaps = document.getElementsByClassName("chapter-check");
	for (ind = 0; ind < allChaps.length; ind++) {
		allChaps[ind].checked = true;
	}
}

function exportPDF() {
	var ids = "";
	var allChaps = document.getElementsByClassName("chapter-check");
	for (ind = 0; ind < allChaps.length; ind++) {
		if (allChaps[ind].checked) {
			if (ids != "") {
				ids = ids+ ",";
			}
			ids = ids + allChaps[ind].value;
		}
	}
	window.location = "../actions/pdf-loader.php?ids=" + ids;
}

function setMarker (chapterId, markerNumber) {
	ajaxPost("../actions/profile.php",
 		{marker_chapter: chapterId, marker_paragraph: markerNumber},
 		function(data) {
 			decodeResponseForFeedback(data);
 			document.getElementById("marker_link_holder").innerHTML = data;
 		}
 	);
	showMarkers(false);
}

function showMarkers (show) {
	if (show) {
		toggleIfMobile();
		addClass(document.body, "show_markers");
		removeClass(document.body, "show_comment_markers");
		setTimeout(function(){showMarkers(false);},5000);
	} else {
		removeClass(document.body, "show_markers");
	}
}

function commentParagraph (summary, markerNumber) {
	// TODO: go to comment passing commented paragraph
	var content = '<div class="related_label">En referencia al p&aacute;rrafo: </div><div class="related_paragraph">&ldquo;' + summary + '&rdquo;</div>';
	content = content + '<input id="related_paragraph_field" type="hidden" value="' + markerNumber + '"/><a href="#" class="related_link" onClick="removeRelated()">Eliminar referencia</a>';
	document.getElementById("paragraph_container").innerHTML = content;
	window.location.hash = "#marker-newcomment";
	showCommentMarkers(false);
}

function removeRelated () {
	document.getElementById("paragraph_container").innerHTML = "";
}

function showCommentMarkers (show) {
	if (show) {
		toggleIfMobile();
		addClass(document.body, "show_comment_markers");
		removeClass(document.body, "show_markers");
		setTimeout(function(){showCommentMarkers(false);},5000);
	} else {
		removeClass(document.body, "show_comment_markers");
	}
}

function loadPerfectScrollbar() {
	document.addEventListener("DOMContentLoaded", function() {
		Ps.initialize(document.getElementById('side-menu'));
	});
}