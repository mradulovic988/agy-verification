"use strict";
document.querySelector("#agy-my-modal") && (document.querySelector("#agy-my-modal").style.display = "block"), document.querySelector(".agy-enter-btn button") && document.querySelector(".agy-enter-btn button").addEventListener("click", () => {
    document.cookie = "agy_verification=approved", setTimeout(() => document.querySelector("#agy-my-modal").style.display = "none", 500)
});