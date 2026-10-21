<?php

$frontmatter = $frontmatter ?? yaml_parse(`yq --front-matter=extract $argv[1] 2>/dev/null || echo ""`) ?? [];
$leftBarShow = $frontmatter['leftBarShow'] ?? TRUE;
$itemtype = $frontmatter['itemtype'] ?? NULL;
$microdata = $frontmatter['microdata'] ?? [];
$microdata = is_array($microdata) ? $microdata : [];
$microdataHtml = '';

if($itemtype && !preg_match('/^[a-z][a-z0-9+.-]*:\/\//i', $itemtype))
{
	$itemtype = 'https://' . ltrim($itemtype, '/');
}

ksort($microdata, SORT_STRING);

foreach($microdata as $property => $values)
{
	$propertyHtml = htmlspecialchars((string) $property, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

	foreach(is_array($values) ? $values : [$values] as $value)
	{
		$value = is_bool($value) ? ($value ? 'true' : 'false') : (string) $value;
		$value = htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
		$microdataHtml .= "\t\t\t\t\t\t\t\t<meta itemprop = \"{$propertyHtml}\" content = \"{$value}\" />\n";
	}
}
?><!DOCTYPE HTML>
<html lang = "en">
<head>
	$if(noprefix)$
	<title>$if(pagetitle)$${pagetitle}$else$${title}$endif$</title>
	$else$
	$if(title-prefix)$
	<title>$if(title-prefix)$${title-prefix} | $endif$$if(pagetitle)$${pagetitle}$else$${title}$endif$</title>
	$else$
	<title>$if(pagetitle)$${pagetitle}$else$${title}$endif$</title>
	$endif$
	$endif$
	<meta charset="utf-8" />
	<meta name="viewport" content="width=800, user-scalable=yes" />
$for(author-meta)$
	<meta name="author" content="$author-meta$" />
$endfor$
$if(date-meta)$
	<meta name="dcterms.date" content="$date-meta$" />
$endif$
$if(keywords)$
	<meta name="keywords" content="$for(keywords)$$keywords$$sep$, $endfor$" />
$endif$
$if(description-meta)$
	<meta name="description" content="$description-meta$" />
$endif$
$if(canonical)$
	<link rel="canonical" href="$canonical$" />
$endif$
	<meta name="title" content="$if(pagetitle)$${pagetitle}$else$${title}$endif$">
	<link rel="sitemap" href="/sitemap.xml" />
	<link rel="preload" href="/logo-80.webp" as="image" type="image/webp">
	<link rel="preload" href="/splash-wide.webp" as="image" type="image/webp">
	<link rel="preconnect" href="https://www.googletagmanager.com" />
	<link rel="preconnect" href="https://www.google-analytics.com" />
	<link rel="dns-prefetch" href="https://www.npmjs.com/" />
	<link rel="dns-prefetch" href="https://playwithlaravel.com/" />
	<link rel="dns-prefetch" href="https://discord.gg/" />
	<link rel="dns-prefetch" href="https://discord.com/" />
	<link rel="dns-prefetch" href="https://playground.wordpress.net/" />
	<link rel="dns-prefetch" href="https://drupal-cms-project-9c0022e0ec6f0d7d0acfffa4583f8606955183fe7716.pages.drupalcode.org/" />
	<link rel="dns-prefetch" href="https://github.com/" />
	<link rel="dns-prefetch" href="https://seanmorris.github.io/" />
	<style>
		$styles.html()$
	</style>
$for(css)$
	<link rel="stylesheet" href="${css}" />
$endfor$
	<style>
$for(header-includes)$
	$header-includes$
$endfor$
	</style>
$if(math)$
	$math$
$endif$
	<?php if(getConf('SCRIPTS')) foreach(getConf('SCRIPTS') as $javascript):?>
	<script src = "<?=$javascript;?>"></script>
	<?php endforeach; ?>
	<?php if(getConf('INLINE_SCRIPTS')) foreach(getConf('INLINE_SCRIPTS') as $javascriptFile):?>
	<script><?=file_get_contents($javascriptFile);?></script>
	<?php endforeach; ?>
</head>
<body>
	<section class = "heading">
		<div class = "page-rule">
			<nav>
				<div class = "logo">
					<a href = "/"><img src = "/logo-80.webp" width = "304" height = "82" alt = "php/wasm logo" /></a>
				</div>
				<div class = "spacer"></div>
				<?php renderMenuRegion('header-links'); ?>
				<?php renderMenuRegion('header-actions'); ?>
				<div class = "hamburger-button" id = "burgerButton" data-open = "false">
					<div class = "burger-bar"></div>
					<div class = "burger-bar"></div>
					<div class = "burger-bar"></div>
				</div>
			</nav>
			<?=$heroHtml??'';?>
		</div>
	</section>

	<section class = "below-fold">
		<div class = "page-rule">
			<?php if($leftBarShow ?? true): ?>
				<nav class = "main"><?php renderNavBar(); ?></nav>
			<?php endif; ?>
			<div class = "page-content">
				<article<?php if($itemtype): ?> itemscope itemtype = "<?=htmlspecialchars($itemtype, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');?>"<?php endif; ?>>
<?=$microdataHtml;?>								$body$
				</article>
				$if(toc)$
				<nav class = "table-of-contents">
					<span class = "wide-only">on this page:</span>
					${toc}
					<span class = "wide-only"><a href = "#">top</a></span>
				</nav>
				$endif$
			</div>
		</div>
	</section>

	<footer class="footer">
		<p class ="strong larger">PHP WASM</p>

		<nav class="footer-menus"><?php renderMenuRegion('footer'); ?></nav>

		<p class ="strong">About</p>
		<p>&copy; 2024 - <?=date('Y');?> Sean Morris | <a href="/LICENSE.html">License</a></p>
		<p>This site is rendered with PHP + Pandoc.</p>
		<a href = "/sitemap.xml" target = "_blank"><img src = "/sitemap-badge.png" width = "80" height = "15" alt = "xml sitemap badge"></a>
	</footer>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', 'G-ZX6DJE9JCG');
	const gascript = document.createElement('script');
	gascript.setAttribute('src','https://www.googletagmanager.com/gtag/js?id=G-ZX6DJE9JCG');
	setTimeout(() => document.head.appendChild(gascript), 0);
</script>
<?php if(getConf('BODY_SCRIPTS')) foreach(getConf('BODY_SCRIPTS') as $javascript):?>
<script src = "<?=$javascript;?>"></script>
<?php endforeach; ?>
<?php if(getConf('INLINE_BODY_SCRIPTS')) foreach(getConf('INLINE_BODY_SCRIPTS') as $javascriptFile):?>
<script><?=file_get_contents($javascriptFile);?></script>
<?php endforeach; ?>
</body>
</html>
