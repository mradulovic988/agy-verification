const copyToClibpoard = document.querySelector('.agy-copy-clipboard');
const downloadToTxt = document.querySelector('.agy-download');
const copyToClipboardMessage = document.querySelector('.agy-copied-message');

copyToClibpoard.addEventListener('click', () => {
	const statusContainer = document.querySelector('.agy-status-container');
	const range = document.createRange();
	range.selectNode(statusContainer);
	window.getSelection().removeAllRanges();
	window.getSelection().addRange(range);
	document.execCommand('copy');
	window.getSelection().removeAllRanges();
	copyToClipboardMessage.innerHTML = 'Copied';
	setTimeout(() => copyToClipboardMessage.innerHTML = '', 3000);
});

downloadToTxt.addEventListener('click', () => {
	const agyStatus = document.querySelector('.agy-status-container');
	const textContent = agyStatus.textContent;
	const blob = new Blob([textContent], {type: 'text/plain'});
	const link = document.createElement('a');

	link.href = URL.createObjectURL(blob);
	link.download = `agy-${window.location.href}-status-log.txt`;

	link.click();
});