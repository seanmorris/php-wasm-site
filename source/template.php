<!DOCTYPE HTML>

<head>
	<title>${title}</title>
	<script src = "/main.js"></script>
	<style>@import url('/heading.css'); </style>
	<style>@import url('/style.css'); </style>
	<style>@import url('/article.css'); </style>
	<style>@import url('/pandoc.css'); </style>
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
		</div>
	</section>

	<section class = "below-fold">
		<div class = "page-rule">
			<nav class = "main">
				<?php include 'source/navbar.php'; ?>
			</nav>
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

	<footer>
		<div>
			<a href = "#">link</a><br />
			<a href = "#">link</a><br />
			<a href = "#">link</a><br />
			<a href = "#">link</a><br />
		</div>
		<div>
			<a href = "#">link</a><br />
			<a href = "#">link</a><br />
			<a href = "#">link</a><br />
			<a href = "#">link</a><br />
		</div>
		<div>
			<a href = "#">link</a><br />
			<a href = "#">link</a><br />
			<img src = "/sean-icon.png"><br />
			Design &copy; 2024 Sean Morris<br />
		</div>
	</footer>
</body>
