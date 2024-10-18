document.addEventListener('click', event => {
	const href = event.target.getAttribute('href');
	if(href && href.substr(0, 4) === 'http' || href.substr(0, 4) === '//')
	{
		event.preventDefault();
		window.open(href);
	}
});

document.addEventListener('DOMContentLoaded', event => {
	const currentLink = document.querySelector(`nav.main a[href="${location.pathname}"]`);
	currentLink.classList.add('current');
});
