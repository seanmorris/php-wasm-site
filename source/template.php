<!DOCTYPE HTML>

<head>
	<title>${title}</title>
	<script src = "/main.js"></script>
	<style>@import url('/heading.css'); </style>
	<style>@import url('/style.css'); </style>
	<style>@import url('/article.css'); </style>
	<style>@import url('/pandoc.css'); </style>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
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
	<title>$if(title-prefix)$$title-prefix$ – $endif$$pagetitle$</title>
	<style>
		$styles.html()$
	</style>
$for(css)$
	<link rel="stylesheet" href="$css$" />
$endfor$
$for(header-includes)$
	$header-includes$
$endfor$
$if(math)$
	$math$
$endif$
</head>

<body>
	<section class = "heading">
		<div class = "page-rule">
			<nav>
				<div class = "logo">
					<a href = "/index.html"><img src = "/logo-80.png"></a>
				</div>
				<ul class = "links">
					<li><a href = "/index.html">Home</a></li>
					<li><a href = "/getting-started/README.html">Docs</a></li>
					<li><a href = "/contact.html">Contact</a></li>
					<li>
						<a href = "https://github.com/seanmorris/php-wasm">Github</a>
						<a href = "https://github.com/seanmorris/php-wasm"><img src = "/github-icon.png"></a>
					</li>
					<li><a href = "https://github.com/sponsors/seanmorris" class = "cta button">Donate</a></li>
				</ul>
			</nav>
			<?=$heroHtml??'';?>
		</div>
	</section>

	<section class = "below-fold">
		<div class = "page-rule">
			<?php if($leftBar ?? true): ?>
			<nav class = "main">
				<?php include 'source/navbar.php'; ?>
			</nav>
			<?php endif; ?>
			<article>$body$</article>
			$if(toc)$
			<nav class = "table-of-contents">
				<span>on this page:</span>
				${toc}
				<span><a href = "#">top</a></span>
			</nav>
			$endif$
		</div>
	</section>

	<footer class="footer">
		<h3>PHP WASM</h3>

		<h4>Resources</h4>
		<ul>
			<li><a href="https://github.com/seanmorris/php-wasm/issues">Issue Tracker</a></li>
			<li><a href="https://github.com/seanmorris/php-wasm/discussions">GitHub Discussions</a></li>
		</ul>

		<h4>Contact</h4>
		<ul>
			<li><a href = "https://github.com/sponsors/seanmorris">Sponsor</a></li>
			<li><a href="https://github.com/seanmorris/php-wasm">Github</a></li>
			<li><a href="https://discord.com/invite/j8VZzju7gJ">Discord</a></li>
		</ul>

		<h4>About</h4>
		<p><a href="http://localhost:8081/LICENSE.html">License</a></p>
		<p>&copy; 2024 Sean Morris</p>
		<p>This site is rendered with PHP + Pandoc.</p>

	</footer>
</body>
