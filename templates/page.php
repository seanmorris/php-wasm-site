<?php

$frontmatter = $frontmatter ?? yaml_parse(`yq --front-matter=extract $argv[1] 2>/dev/null || echo ""`) ?? [];
$leftBarLink = $frontmatter['leftBarLink'] ?? TRUE;
$leftBarShow = $frontmatter['leftBarShow'] ?? TRUE;
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
	<div class = "nag-bar" id = "nag-bar">
		<div class = "page-rule">
			<div class = "row">
				<div class = "prose">
					<p><strong>I am giving up my bed for one night.</strong></p>

					<p>My Sleep Out helps youth facing homelessness find safe shelter and loving care at Covenant House. That care includes essential services like education, job training, medical care, mental health and substance use counseling, and legal aid — everything they need to build independent, sustainable futures.</p>

					<p>By supporting my Sleep Out, you are supporting the dreams of young people overcoming homelessness.</p>

					<p>Together, we are working towards a future where every young person has a safe place to sleep.</p>

					<p>Thank you.</p>
				</div>
				<div class = "col center">
					<a href = "https://www.sleepout.org/participants/62915">
						<span class = "button">DONATE NOW</span>
					</a>
					<a href = "https://www.sleepout.org/participants/62915">
						<img src = "https://img.shields.io/badge/dynamic/json?url=https%3A%2F%2Fwww.sleepout.org%2Fapi%2F1.3%2Fparticipants%2F62915%3F_%3D1760039017428&query=%24.sumDonations&prefix=%24&suffix=%20Raised&style=for-the-badge&label=Sleep%20Out%3A%20NYC&link=https%3A%2F%2Fwww.sleepout.org%2Fparticipants%2F62915&color=0677ff">
					</a>
				</div>
			</div>
			<div class = "close-button" id = "close-nag"></div>
			<div class = "open-button" id = "open-nag"></div>
		</div>
	</div>
	<section class = "heading">
		<div class = "page-rule">
			<nav>
				<div class = "logo">
					<a href = "/"><img src = "/logo-80.webp" width = "304" height = "82" alt = "php/wasm logo" /></a>
				</div>
				<div class = "spacer"></div>
				<ul class = "links">
					<li><a href = "/">Home</a></li>
					<li><a href = "/demos.html">Demo</a></li>
					<li><a href = "/getting-started/home.html">Docs</a></li>
					<li><a href = "/contact.html">Contact</a></li>
					<li>
						<a href = "https://github.com/seanmorris/php-wasm">Github</a>
						<a href = "https://github.com/seanmorris/php-wasm"><img src = "/github-icon.png" alt = "Github icon" width = "37" height = "37" ></a>
					</li>
				</ul>
				<a href = "https://github.com/sponsors/seanmorris" class = "cta button">Sponsor</a>
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
				<article $if(itemtype)$ itemscope itemtype = "https://${itemtype}" $endif$>
				$for(microdata/pairs)$
				<meta itemprop = "${microdata.key}" content = "${microdata.value}" />
				$endfor$
				$body$
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

		<p class ="strong">Resources</p>
		<ul>
			<li><a href="https://github.com/seanmorris/php-wasm/issues">Issue Tracker</a></li>
			<li><a href="https://github.com/seanmorris/php-wasm/discussions">GitHub Discussions</a></li>
		</ul>

		<p class ="strong">Contact</p>
		<ul>
			<li><a href = "https://github.com/sponsors/seanmorris">Sponsor</a></li>
			<li><a href="https://github.com/seanmorris/php-wasm">Github</a></li>
			<li><a href="https://discord.com/invite/j8VZzju7gJ">Discord</a></li>
			<li><a href="https://www.npmjs.com/package/php-wasm">npmjs</a></li>
		</ul>

		<p class ="strong">About</p>
		<p>&copy; 2024 - <?=date('Y');?> Sean Morris | <a href="/LICENSE.html">License</a></p>
		<p>This site is rendered with PHP + Pandoc.</p>
		<a href = "/sitemap.xml" target = "_blank"><img src = "/sitemap-badge.png" alt = "sitemap" width = "80" height = "15" alt = "xml sitemap badge"></a>
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
