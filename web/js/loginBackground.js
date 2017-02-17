function backgroundSwitch() {
    var currentTime = new Date();
    var hours = currentTime.getHours();
    if (hours > 6 && hours < 18) {
	$('.login-page').addClass('day');
    } else {
	$('.login-page').addClass('night');
    }
}
