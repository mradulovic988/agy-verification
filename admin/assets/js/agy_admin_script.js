"use strict";
const openTab = (e, t) => {
    let a, l, s;
    l = document.getElementsByClassName("agy-tabcontent");
    for (let e = 0; e < l.length; e++) l[e].style.display = "none";
    for (s = document.getElementsByClassName("agy-tablinks"), a = 0; a < s.length; a++) s[a].className = s[a].className.replace(" agy-active", "");
    document.getElementById(t).style.display = "block", e.currentTarget.className += " agy-active"
};
document.getElementById("default-open").click();

// Shortcode
if (document.querySelector('input#agy-shortcode').checked) {
    const shortcodeToAdd = document.createElement('small');
    const shortcodeArea = document.querySelector('tr.agy-shortcode > th');

    shortcodeToAdd.className = 'agy-shortcode-inputted';
    shortcodeToAdd.innerHTML = '[agy-verification]';
    shortcodeToAdd.setAttribute('style', 'border:1px solid #999;padding:3px 5px;display:block;width:110px;position:relative;top:5px;color:#999;text-align:center');
    shortcodeArea.appendChild(shortcodeToAdd);
}