function hasClass(item, name) {
	return (item.className.indexOf(name) >= 0);
}

function removeClass(item, name) {
	var rex = new RegExp(name,"g");
	item.className = item.className.replace(rex,"").trim();
}

function addClass(item, name) {
	item.className += " " + name;
}

function ajaxGet (endpoint, callbackOk, callbackError) {
	var xHR = new XMLHttpRequest();
	xHR.open("GET", endpoint, true);
	xHR.onreadystatechange = function() {
		if(xHR.readyState == 4) {
			if (xHR.status == 200) {
				callbackOk(xHR.responseText);
			} else {
				callbackError(xHR.responseText)
			}
		} 
	}
	xHR.send();
}

function ajaxPost (endpoint, parameters, callbackOk, callbackError) {
	var xHR = new XMLHttpRequest();
	var params = convertParamsToEncodedString(parameters);
	xHR.open("POST", endpoint, true);
	xHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xHR.onreadystatechange = function() {
		if(xHR.readyState == 4) {
			if (xHR.status == 200) {
				callbackOk(xHR.responseText);
			} else {
				callbackError(xHR.responseText)
			}
		} 
	}
	xHR.send(params);
}

function convertParamsToEncodedString(parameters) {
	var result = "";
	for (var key in parameters) {
		if (parameters[key]) {
			if (result.length > 0) {
				result += "&";
			}
			result += encodeURIComponent(key) + "=" + encodeURIComponent(parameters[key]);
		}
	}
	return result;
}

function htmlToElement(html) {
    var template = document.createElement('template');
    template.innerHTML = html;
    return template.content.firstChild;
}