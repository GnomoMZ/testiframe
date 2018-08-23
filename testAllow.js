function onLoadTest() {
            var currentElem = document.getElementById("iframe-id-1");
//    currentElem.setAttribute('allow', 'gyroscope; accelerometer');

}

//Making sure that the HTML is loaded
if (window.attachEvent) {
    window.attachEvent("onload", onLoadTest);
} else {
    if (window.onload) {
        var curronload = window.onload;
        var newonload = function(evt) {
            curronload(evt);
            onLoadTest(evt);
        };
        window.onload = newonload;
    } else {
        window.onload = onLoadTest;
    }
}
