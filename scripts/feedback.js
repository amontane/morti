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
	var division = document.getElementById("error-frame");
	if (division) {
		removeClass(division, "hover");
		removeClass(division, "shown");
	}
}

function feedbackMouseIn() {
	feedbackFadeTimeoutCancel();
	var division = document.getElementById("error-frame");
	if (division) {
		addClass(division, "hover");
	}
}

function feedbackMouseOut() {
	var division = document.getElementById("error-frame");
	if (division) {
		removeClass(division, "hover");
	}
	feedbackFadeTimeoutStart();
}

function showFeedback(message) {
	var division = document.getElementById("error-frame");
	if (message && division) {
		division.innerHTML = message;
		removeClass(division, "error");
		removeClass(division, "hover");
		addClass(division, "shown");
	}
	feedbackFadeTimeoutStart();
}

function showErrorFeedback(message) {
	var division = document.getElementById("error-frame");
	if (message && division) {
		division.innerHTML = message;
		addClass(division, "error");
		removeClass(division, "hover");
		addClass(division, "shown");
	}
	feedbackFadeTimeoutStart();
}

function decodeResponseForFeedback(response) {
	var error = false;
	var message = "";
	turboDOM = htmlToElement(response);
	while (turboDOM) {
		if (turboDOM.nodeName.toLowerCase() == "feedbackerror") {
			error = true;
		} else if (turboDOM.nodeName.toLowerCase() == "feedbackmessage") {
			message = turboDOM.innerHTML;
		}
		turboDOM = turboDOM.nextSibling;
	}
	if (error) {
		showErrorFeedback(message);
	} else {
		showFeedback(message);
	}
}