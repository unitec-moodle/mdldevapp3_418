// JavaScript Document

/*######################################################################
###########    Additional JS for a Hide Blocks Button - MH    ##########
########################################################################*/

//Hide Blocks Button functions
var pageLoad = document.getElementById("page"),
    pageName = pageLoad.getAttribute('name'),
    hideButton = document.getElementById("hideShowButton"),
    elem2 = document.getElementById("cookieValue"),
    blocksState = "blocksHidden";
// Write cookie
function writeCookie() {
    "use strict";
    var cookievalue = blocksState;
    document.cookie = "name=" + cookievalue;
}

// Delete cookie
function deleteCookie() {
    var now = new Date();
    now.setMonth(now.getMonth() - 1);
    var cookievalue = "";
    document.cookie = "name=" + cookievalue;
    document.cookie = "expires=" + now.toUTCString() + ";";
}

//Hide Blocks
function hideBlocks() {
    "use strict";
    var sidePre = document.getElementById("block-region-side-pre"),
        sidePost = document.getElementById("block-region-side-post"),
        regMainBox = document.getElementById("region-main-box"),
        regMain = document.getElementById("region-main");

    if (pageName === "3col") {

        if (sidePre.style.display === "none") {
            sidePre.style.display = "block";
            sidePost.style.display = "block";
            hideButton.value = "Hide Blocks";
            regMainBox.className = "region-main";
            regMain.className = "region-main-content";
            deleteCookie();
        } else {
            sidePre.style.display = "none";
            sidePost.style.display = "none";
            hideButton.value = "Show Blocks";
            regMainBox.className = "col-12";
            regMain.className = "col-12";
            writeCookie();
        }

    }
}

function checkCookieState() {
    var cookieValue = document.cookie;
    var cookieArray = cookieValue.split(';');
    var cookieStr = cookieArray.toString();
    var n = cookieStr.includes("name=blocksHidden");

    if (n == true) {
        hideBlocks();
    }
}
