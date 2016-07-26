
function getMap() {
// Get location no more than 1 minutes old. 60000 ms = 1 minutes.
	navigator.geolocation.getCurrentPosition(showMap, showError, {enableHighAccuracy:true,maximumAge:60000,timeout:0});
}

function showError(error) {
        altert(error.code + ' ' + error.message);
}
