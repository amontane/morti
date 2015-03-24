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
		division.removeClass("hover");
		division.addClass("shown");
	}
	feedbackFadeTimeoutStart();
}