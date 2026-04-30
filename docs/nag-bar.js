document.addEventListener('DOMContentLoaded', () => {
	const nagBar = document.getElementById('nag-bar');
	const openNag = document.getElementById('open-nag');
	const closeNag = document.getElementById('close-nag');

	const wasClosed = !!Number(sessionStorage.getItem('nagClosed') || 0);

	if(nagBar && wasClosed)
	{
		nagBar.classList.add('closed');
	}

	closeNag && closeNag.addEventListener('click', () => {
		sessionStorage.setItem('nagClosed', 1);
		nagBar.classList.add('closed');
	});

	openNag && openNag.addEventListener('click', () => {
		sessionStorage.setItem('nagClosed', 0);
		nagBar.classList.remove('closed');
	});
});
