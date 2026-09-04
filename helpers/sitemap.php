<?php

$domain = rtrim((string) (getenv('SITEMAP_BASE_URL') ?: ($argv[1] ?? '')), '/');
$rootPath = $argv[2] ?? '';

if($domain === '')
{
	throw new RuntimeException('SITEMAP_BASE_URL is required to generate absolute sitemap URLs.');
}

$domainParts = parse_url($domain);

if(
	!is_array($domainParts)
	|| !in_array($domainParts['scheme'] ?? '', ['http', 'https'], TRUE)
	|| empty($domainParts['host'])
)
{
	throw new RuntimeException('SITEMAP_BASE_URL must be an absolute HTTP(S) URL.');
}

if(!is_dir($rootPath))
{
	throw new RuntimeException('Sitemap output directory does not exist: ' . $rootPath);
}

$pages = [];
$directory = new RecursiveIteratorIterator(
	new RecursiveDirectoryIterator($rootPath, FilesystemIterator::SKIP_DOTS)
);

foreach($directory as $entry)
{
	if(!$entry->isFile())
	{
		continue;
	}

	$pathname = $entry->getPathname();
	$filename = $entry->getFilename();

	if(substr($pathname, -5) !== '.html' || substr($pathname, -8) === '404.html')
	{
		continue;
	}

	if(preg_match('/^google[0-9a-f]+\.html$/', $filename))
	{
		continue;
	}

	$urlPath = ltrim(substr($pathname, strlen(rtrim($rootPath, DIRECTORY_SEPARATOR))), DIRECTORY_SEPARATOR);
	if($urlPath === '' || $urlPath[0] === '.')
	{
		continue;
	}

	$pages[$urlPath] = $entry->getMTime();
}

ksort($pages, SORT_STRING);

echo '<?xml version="1.0" encoding="UTF-8"?>', PHP_EOL;
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', PHP_EOL;

foreach($pages as $urlPath => $modifiedTime)
{
	$url = $domain . '/' . str_replace(DIRECTORY_SEPARATOR, '/', $urlPath);
?>
	<url>
		<loc><?=htmlspecialchars($url, ENT_XML1 | ENT_QUOTES, 'UTF-8');?></loc>
		<lastmod><?=gmdate('Y-m-d', $modifiedTime);?></lastmod>
		<changefreq>daily</changefreq>
		<priority>0.8</priority>
	</url>
<?php
}

echo '</urlset>', PHP_EOL;
