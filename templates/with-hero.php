<?php
$frontmatter = yaml_parse(`yq --front-matter=extract $argv[1] 2>/dev/null || echo ""`) ?? [];
$heroTemplate = $frontmatter['hero'] ?? '';
if($heroTemplate && !str_contains($heroTemplate, '/'))
{
	$heroTemplate = __DIR__ . '/' . $heroTemplate;
}
ob_start(); include $heroTemplate;
$heroHtml = ob_get_contents();
ob_end_clean();
include __DIR__ . '/page.php';
