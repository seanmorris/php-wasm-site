<?php

$domain = $argv[1];
$rootPath = './docs';

$directory = new \RecursiveIteratorIterator(
	new \RecursiveDirectoryIterator($rootPath)
);

echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

foreach($directory as $entry)
{
	$pathname = $entry->getPathname();

	if(substr($pathname, -4) !== 'html' || substr($pathname, -8) === '404.html')
	{
		continue;
	}

	$urlPath = substr($pathname, 1 + strlen($rootPath));

	if($urlPath[0] === '.')
	{
		continue;
	}

	?>
	<url>
		<loc><?=$domain?>/<?=$urlPath?></loc>
	</url>
<?php
}

echo '</urlset>' . PHP_EOL;
