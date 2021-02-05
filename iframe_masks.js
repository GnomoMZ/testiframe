function onLoadMasks() {
    var masks = [];
    var maskedElements = [];

    //ids for masks
    masks.push("mask-iframe-1");
    masks.push("mask-iframe-2");

    // Classes for animation
    var inClass = "fadeIn";
    var outClass = "fadeOut";

    for (var i = 0; i < masks.length; i++) {
        var currentElem = document.getElementById(masks[i]);
        maskedElements.push(currentElem);
        currentElem.addEventListener("click", function () {
            event.stopPropagation();
            OnElementClick(this);
        });
    }
    function OnElementClick(elem) {
        elem.classList.remove(inClass);
        elem.classList.add(outClass);
        var closeButton = document.getElementById(elem.id + "-close");
        if (closeButton !== null) {
            closeButton.classList.add(inClass);
            closeButton.classList.remove(outClass);
        }
    }

    window.addEventListener("click", function () {
        for (var i = 0; i < maskedElements.length; i++) {
            maskedElements[i].classList.add(inClass);
            maskedElements[i].classList.remove(outClass);
            var closeButton = document.getElementById(
                maskedElements[i].id + "-close"
            );
            if (closeButton !== null) {
                closeButton.classList.remove(inClass);
                closeButton.classList.add(outClass);
            }
        }
    });




    /*setInterval(()=>{
        console.log("Aca");
        window.scroll(0, 100);
    },2500);*/

}

//Making sure that the HTML is loaded
if (window.attachEvent) {
    window.attachEvent("onload", onLoadMasks);
} else {
    if (window.onload) {
        var curronload = window.onload;
        var newonload = function (evt) {
            curronload(evt);
            onLoadMasks(evt);
        };
        window.onload = newonload;
    } else {
        window.onload = onLoadMasks;
    }
}


window.scroll(0, 0);

var lastTouchY;
var scrollValue = 0;

document.addEventListener("touchstart", (event) => {
    lastTouchY = event.touches[0].clientY;
}, false);



document.addEventListener("touchmove", (event) => {
    currentY = event.touches[0].clientY;

    scrollValue += lastTouchY - currentY;
    if (scrollValue < 0)
        scrollValue = 0;

    var maxScrollValue = document.body.clientHeight - window.screen.height;

    if (scrollValue > maxScrollValue)
        scrollValue = maxScrollValue;

    lastTouchY = currentY;


}, false);

var elapsed;

var lastTime;

function step(timestamp) {

    if (lastTime === undefined)
        lastTime = timestamp ;
    elapsed = timestamp - lastTime;
    lastTime = timestamp;

    window.scrollTo(0, lerp(document.documentElement.scrollTop, scrollValue, elapsed / 100));

    window.requestAnimationFrame(step);

}

window.requestAnimationFrame(step);

function lerp(start, end, amt) {
    if (amt > 1)
        amt = 1;
    return (1 - amt) * start + amt * end;
}