var feedbackTimeout;

function feedbackFadeTimeoutStart() {
	feedbackFadeTimeoutCancel();
	feedbackTimeout = setTimeout(function(){feedbackFadeTrigger();}, 5000);
}

function feedbackFadeTimeoutCancel() {
	if (feedbackTimeout) {
		clearTimeout(feedbackTimeout);
	}
	feedbackTimeout = null;
}

function feedbackFadeTrigger() {
	feedbackFadeTimeoutCancel();
	var division = $("#error-frame")
	if (division) {
		division.removeClass("hover");
		division.removeClass("shown");
	}
}

function feedbackMouseIn() {
	feedbackFadeTimeoutCancel();
	var division = $("#error-frame")
	if (division) {
		division.addClass("hover");
	}
}

function feedbackMouseOut() {
	var division = $("#error-frame")
	if (division) {
		division.removeClass("hover");
	}
	feedbackFadeTimeoutStart();
}

function showFeedback(message) {
	var division = $("#error-frame")
	if (message && division) {
		division.html(message);
		division.removeClass("error");
		division.removeClass("hover");
		division.addClass("shown");
	}
	feedbackFadeTimeoutStart();
}

function showErrorFeedback(message) {
	var division = $("#error-frame")
	if (message && division) {
		division.html(message);
		division.addClass("error");
		division.removeClass("hover");
		division.addClass("shown");
	}
	feedbackFadeTimeoutStart();
}

function decodeResponseForFeedback(response) {
	var error = false;
	var message = "";
	responseDOM =  $.parseHTML(response);
	$(responseDOM).each(function(index) {
		if ($(this).is("feedbackError")) {
			error = true;
		} else if ($(this).is("feedbackMessage")) {
			message = $(this).html();
		}
	});
	if (error) {
		showErrorFeedback(message);
	} else {
		showFeedback(message);
	}
}