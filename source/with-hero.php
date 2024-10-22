<?php
$frontmatter = yaml_parse(`yq --front-matter=extract $argv[1] 2>/dev/null || echo ""`) ?? [];
ob_start(); include $frontmatter['hero'];
$heroHtml = ob_get_contents();
ob_end_clean();
include 'template.php';
