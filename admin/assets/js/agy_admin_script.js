'use script';

/**
 * Handler for the Tab menu on Admin pages
 *
 * @param evt
 * @param tabName
 */
const openTab = (evt, tabName) => {
    let i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName('agy-tabcontent');
    for (let i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = 'none';
    }

    tablinks = document.getElementsByClassName('agy-tablinks');
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(' agy-active', '');
    }

    document.getElementById(tabName).style.display = 'block';
    evt.currentTarget.className += ' agy-active';
};

document.getElementById('default-open').click();