function onLoadTest() {
//    
//    window.addEventListener("deviceorientation", function(event) {
//        var iframeElement = document.getElementById("iframe-id-1");
//        iframeElement.contentWindow.postMessage(
//            {
//                alpha: event.alpha,
//                beta: event.beta,
//                gamma: event.gamma
//            },
//            "*"
//        );
//    });
//
//    window.addEventListener(
//        "orientationchange",
//        function() {
//            console.log("orientationchange");
//            var iframe = document.getElementById("iframe-id-1");
//
//            iframe.contentWindow.postMessage(
//                {
//                    orientation: window.orientation
//                },
//                "*"
//            );
//        },
//        false
//    );
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
