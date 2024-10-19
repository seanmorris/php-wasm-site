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

document.addEventListener('mouseover', event => {
	const href = event.target.getAttribute('href');

	if(!href)
	{
		return;
	}

	const url = new URL(href, location);

	if(url.origin !== location.origin)
	{
		return;
	}

	fetch(href);
});

document.addEventListener('DOMContentLoaded', event => {
	const currentLink = document.querySelector(`nav.main a[href="${location.pathname}"]`);
	currentLink && currentLink.classList.add('current');

	const codeBlocks = document.querySelectorAll(`div.sourceCode`);

	for(const codeBlock of codeBlocks)
	{
		const lines = [...codeBlock.querySelectorAll('pre > code > span')];

		const start = codeBlock.getAttribute('start');
		if(start)
		{
			codeBlock.style.setProperty('--startFrom', start);
		}

		const highlight = codeBlock.getAttribute('data-highlight');
		if(highlight)
		{
			const numbers = highlight.split(',').map(n => n.trim());

			for(const number of numbers)
			{
				if(!lines[number])
				{
					continue;
				}

				lines[number].classList.add('highlight');
			}
		}

		const attributes = codeBlock.getAttributeNames();
		const prefix = 'data-highlight-';

		for(const attribute of attributes)
		{
			if(attribute.substring(0, prefix.length) === prefix)
			{
				const suffix = attribute.substring(prefix.length);

				const numbers = codeBlock.getAttribute(attribute).split(',').map(n => n.trim());

				for(const number of numbers)
				{
					if(!lines[number])
					{
						continue;
					}

					lines[number].classList.add(suffix);
				}
			}
		}
	}
});
