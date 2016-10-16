function fadeIn(element, callback) {

	// set initial opacity
    var op = 0.01;

    var timer = setInterval(function () {
        if (op >= 1){
            clearInterval(timer);
            element.style.opacity = 1;
            element.style.filter = 'alpha(opacity=1)';

            callback();
        }

        element.style.opacity = op;
        element.style.filter = 'alpha(opacity=' + op * 100 + ")";
        
        op += op * 1.1;
    }, 20);
}

function fadeOut(element) {

	// set initial opacity
    var op = 1;

    var timer = setInterval(function () {
        if (op <= 0.01){
            clearInterval(timer);
            element.style.opacity = '1';
            element.style.display = 'none';
        }

        element.style.opacity = op;
        element.style.filter = 'alpha(opacity=' + op * 100 + ")";
        op -= op * 0.1;
    }, 20);
}

window.onload = function() {

	if(document.getElementById('notification')) { 
		var notification = document.getElementById('notification');

		fadeIn(notification, function() {
			setTimeout(function() { fadeOut(notification) }, 2500);
		});
	}
}