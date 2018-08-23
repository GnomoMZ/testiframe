function onLoadTest() {
    window.addEventListener("deviceorientation", function(event) {
        console.log("deviceorientation");

        var iframeElement = document.getElementById("iframe-id-1");
        console.log(iframeElement);
        iframeElement.contentWindow.postMessage(
            {
                alpha: event.alpha,
                beta: event.beta,
                gamma: event.gamma
            },
            "*"
        );
    });

    window.addEventListener(
        "orientationchange",
        function() {
            console.log("orientationchange");
            var iframe = document.getElementById("iframe-id-1");
            console.log(iframe);

            iframe.contentWindow.postMessage(
                {
                    orientation: window.orientation
                },
                "*"
            );
        },
        false
    );
    var frame = document.getElementById("iframe-id-1");

    setInterval(function() {
        frame.contentWindow.postMessage({ pepe: 2 }, "*");
        console.log("send");
    }, 10000);

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
