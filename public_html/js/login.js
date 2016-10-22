function fadeIn(element, callback) {

	// set initial opacity
    var op = 0.01;

    var timer = setInterval(function () {
        if (op >= 1){
            clearInterval(timer);
            element.style.background = 'rgba(255,0,0,1)';

            callback();
        }

        element.style.background = 'rgba(255,0,0,'+ op +')';
        
        op += op * 1.1;
    }, 20);
}

function fadeOut(element) {

	// set initial opacity
    var op = 1;

    var timer = setInterval(function () {
        if (op <= 0.01){
            clearInterval(timer);
            element.style.background = 'rgba(255,255,255,0)';
        }

        element.style.background = 'rgba(255,0,0,'+ op +')';

        op -= op * 0.1;
    }, 20);
}


window.onload = function() {

	if(document.getElementById('notification')) { 
		var notification = document.getElementById('notification');

		fadeIn(notification, function() {
			fadeOut(notification);
		});
	}
}