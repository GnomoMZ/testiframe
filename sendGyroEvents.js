function onLoadGyro() {
    var iframesIds = [];

    //ids for iframes
    iframesIds.push("iframe-id-1");
    iframesIds.push("iframe-id-2");

    window.addEventListener("deviceorientation", function(event) {
        for (var i = 0; i < iframesIds.length; i++) {
            var iframeElement = document.getElementById(iframesIds[i]);
            iframeElement.contentWindow.postMessage(
                {
                    alpha: event.alpha,
                    beta: event.beta,
                    gamma: event.gamma
                },
                "*"
            );
        }
    });

    window.addEventListener(
        "orientationchange",
        function() {
            for (var i = 0; i < iframesIds.length; i++) {
                var iframe = document.getElementById(iframesIds[i]);
                iframe.contentWindow.postMessage(
                    {
                        orientation: window.orientation
                    },
                    "*"
                );
            }
        },
        false
    );
}

//Making sure that the HTML is loaded
if (window.attachEvent) {
    window.attachEvent("onload", onLoadGyro);
} else {
    if (window.onload) {
        var curronload = window.onload;
        var newonload = function(evt) {
            curronload(evt);
            onLoadGyro(evt);
        };
        window.onload = newonload;
    } else {
        window.onload = onLoadGyro;
    }
}
