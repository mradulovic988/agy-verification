const openTab = (e, t) => {
	let a, l, s;
	l = document.getElementsByClassName("agy-tabcontent");
	for (let e = 0; e < l.length; e++) l[e].style.display = "none";
	for (s = document.getElementsByClassName("agy-tablinks"), a = 0; a < s.length; a++) s[a].className = s[a].className.replace(" agy-active", "");
	document.getElementById(t).style.display = "block", e.currentTarget.className += " agy-active"
};
if (document.getElementById("agy-default-open")) {
	document.getElementById("agy-default-open").click()
}

const statusLogTab = document.querySelector('.agy-status-log-tab');
const saveChangesBtn = document.getElementById('agy-save-changes-btn');

statusLogTab.addEventListener('click', () => {
	saveChangesBtn.style.display = 'none';
});

const otherTabs = document.querySelectorAll('.agy-tablinks:not(.agy-status-log-tab)');
otherTabs.forEach(tab => {
	tab.addEventListener('click', () => {
		saveChangesBtn.style.display = 'block';
	});
});