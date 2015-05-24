
// ---[ UI ]-----------------------------------------------

function showStatus(message) {
	statusLabel.textContent = message;
}

function showRequest(text) {
	requestCode.textContent = text;
}

function showResponse(text) {
	responseCode.textContent = text;
}

function showValue(value) {
	valueTextBox.value = value;
}

// ---[ Key/Value Store ]----------------------------------

function getValue(key) {

	var pair = {
		key: key,
		value: undefined
	};

	post('get', JSON.stringify(pair), function(data) {

		if(data.success === true) {
			showValue(data.value);
		} else {
			showStatus('Error! Message: ' + data.message);
		}

	});

}

function setValue(key, value) {

	var pair = {
		key: key,
		value: value
	};

	post('set', JSON.stringify(pair));

}


// ---[ Key/Value Store Internals ]------------------------


function onError() {
	showStatus('Error!');
}

function post(url, data, callbackSuccess) {

	showStatus('Sending request...');
	showRequest(data);

	var request = new XMLHttpRequest();

	request.open('POST', url, true);

	request.onerror = onError;
	request.onabort = onError;
	request.ontimeout = onError;

	request.onreadystatechange = function() {

		if(request.readyState === 4) {

			showStatus('Response recieved');
			showResponse(request.responseText);

			responseCode.textContent = request.responseText;

			if(request.status === 200) {
				if(typeof callbackSuccess === 'function') {
					callbackSuccess(JSON.parse(request.responseText));
				}
			}
		}
	}

	request.send(data);

}