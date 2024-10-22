<?php ob_start(); ?>

			<div class = "hero">
				<h1>Deploy in One Click.</h1>
				<p>Deploy PHP 8 apps client-side in one click, run PHP in cloudflare with full access to D1 SQL, or write PHP desktop apps with GTK.</p>
				<a href = "/getting-started/home.html" class = "cta button">Learn More</a>
			</div>

			<div class = "sub-hero">
				<strong>Php-Wasm runs anywhere Javascript+WASM is supported.</strong>

				<ul>
					<li>Supports NodeJS & Browsers.</li>
					<li>Full access to Javascript APIs from PHP</li>
					<li>Works with with Node GTK.</li>
					<li>Supports SQLite & PostgreSQL.</li>
					<li>Powerful enough to run Drupal, Laravel & WordPress.</li>
					<li>Runs in CloudFlare with D1 SQL via PDO.</li>
				</ul>

				<p>Php-Wasm is currently powering cutting-edge client side php apps like wordpress-playground, drupal-playground & playwithlaravel.</p>
			</div>

<?php

$heroHtml = ob_get_contents();
ob_end_clean();
$leftBar = false;

include 'template.php';
