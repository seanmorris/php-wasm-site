function flicker(element, timeout)
{
	if(element.classList.contains('flickering')) return;
	element.classList.add('flickering');
	setTimeout(() => element.classList.remove('flickering'), timeout)
}

document.addEventListener('click', event => {
	let target = event.target;
	let href;

	do
	{
		href = target.getAttribute('href');

		if(href)
		{
			const url = new URL(href, location);

			if((href.substr(0, 4) === 'http' || href.substr(0, 4) === '//'))
			{
				window.open(href);
				event.preventDefault();
				return;
			}

			if(url.hash)
			{
				const element = document.getElementById(url.hash.substr(1));

				if(element)
				{
					flicker(element, 200);
				}
			}
		}

		target = target.parentNode;

	} while(target && target.getAttribute && !href);
});

document.addEventListener('DOMContentLoaded', event => {
	const currentLink = document.querySelector(`nav.main a[href="${location.pathname}"]`);
	currentLink && currentLink.classList.add('current');
});
