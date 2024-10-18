document.addEventListener('click', event => {
	let target = event.target;
	let href;

	do
	{
		href = target.getAttribute('href');

		if(href && (href.substr(0, 4) === 'http' || href.substr(0, 4) === '//'))
		{
			window.open(href);
			event.preventDefault();
		}

		target = target.parentNode;

	} while(target && target.getAttribute && !href);

});

document.addEventListener('DOMContentLoaded', event => {
	const currentLink = document.querySelector(`nav.main a[href="${location.pathname}"]`);
	currentLink && currentLink.classList.add('current');
});
