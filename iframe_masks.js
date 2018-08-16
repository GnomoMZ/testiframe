function onLoadMasks() {
    var masks = [];
    var maskedElements = [];

    masks.push("mask-iframe-id");

    var inClass = "fadeIn";
    var outClass = "fadeOut";

    for (var i = 0; i < masks.length; i++) {
        var currentElem = document.getElementById(masks[i]);
        maskedElements.push(currentElem);
        document.getElementById(masks[i]).addEventListener("click", function() {
            event.stopPropagation();
            OnElementClick(currentElem);
        });
    }

    function OnElementClick(elem) {
        elem.classList.remove(inClass);
        elem.classList.add(outClass);
    }

    window.addEventListener("click", function() {
        for (var i = 0; i < maskedElements.length; i++) {
            maskedElements[i].classList.add(inClass);
            maskedElements[i].classList.remove(outClass);
        }
    });
}

if (window.attachEvent) {
    window.attachEvent("onload", onLoadMasks);
} else {
    if (window.onload) {
        var curronload = window.onload;
        var newonload = function(evt) {
            curronload(evt);
            onLoadMasks(evt);
        };
        window.onload = newonload;
    } else {
        window.onload = onLoadMasks;
    }
}
