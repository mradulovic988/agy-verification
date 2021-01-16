'use strict';

const isDisabled = document.querySelectorAll('.is-disabled');
const showNotice = `<span title="WooCommerce is not activated." class="agy-wc-not-activate">!</span>`;

for (let i = 0; i < isDisabled.length; i++) {
    isDisabled[i].value = '';
    isDisabled[i].setAttribute('disabled', 'disabled');
    isDisabled[i].checked = false;
}

document.querySelector('div#agy-tab4 h2').innerHTML += showNotice;