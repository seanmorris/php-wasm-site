<?php

function renderNavBar($path = NULL, $rootPath = NULL)
{
	$path = $path ?? getConf('PAGES_DIR') ?? (__DIR__ . '/../pages');
	$rootPath = $rootPath ?? $path;
	$directories = [];
	$files = [];

	?><ul><?php

	$dir = new \DirectoryIterator($path);

	foreach($dir as $entry)
	{
		$filename = $entry->getFilename();
		$pathname = $entry->getPathname();

		if($filename[0] === '.')
		{
			continue;
		}

		if(is_dir($pathname))
		{
			$frontmatter = [];

			if(file_exists($pathname . '/.fm.yaml'))
			{
				$fmPath = escapeshellarg($pathname . '/.fm.yaml');
				$frontmatter = yaml_parse(`yq --front-matter=extract $fmPath 2>/dev/null|| echo ""`) ?? [];
			}

			if(!($frontmatter['leftBarLink'] ?? true))
			{
				continue;
			}

			$directories[] = (object)[ 'filename' => $filename, 'pathname' => $pathname, 'frontmatter' => $frontmatter ];
			continue;
		}

		$fmPath = escapeshellarg($pathname);
		$frontmatter = yaml_parse(`yq --front-matter=extract $fmPath 2>/dev/null || echo ""`) ?? [];

		if(!($frontmatter['leftBarLink'] ?? true))
		{
			continue;
		}

		$files[] = (object)[ 'filename' => $filename, 'pathname' => $pathname, 'frontmatter' => $frontmatter];
	}

	usort($directories, function($a, $b){
		$wa = (float) ($a->frontmatter['weight'] ?? 0);
		$wb = (float) ($b->frontmatter['weight'] ?? 0);

		if($wa === $wb)
		{
			return strcmp($a->filename, $b->filename);
		}

		return $wa - $wb;
	});

	usort($files, function($a, $b){
		$wa = (float) ($a->frontmatter['weight'] ?? 0);
		$wb = (float) ($b->frontmatter['weight'] ?? 0);

		if($wa === $wb)
		{
			return strcmp($a->filename, $b->filename);
		}

		return $wa - $wb;
		return strcmp($a->filename, $b->filename);
	});

	foreach($directories as $entry)
	{
		$filename = $entry->filename;
		$pathname = $entry->pathname;
		$frontmatter = $entry->frontmatter;

		$title = $frontmatter['title'] ?? ucwords(trim(str_replace('-', ' ', basename($filename))));

		?><details open>
			<summary><?=$title;?></summary>
			<?=renderNavBar($pathname, $rootPath);?>
		</details><?php
	}

	foreach($files as $entry)
	{
		$filename = $entry->filename;
		$pathname = $entry->pathname;
		$frontmatter = $entry->frontmatter;

		$title = $frontmatter['title'] ?? ucwords(preg_replace(['/\.md$/', '/-/'], ['',  ' '], $filename));
		$linkPath = preg_replace('/\.\w+$/', '.html', substr($pathname, strlen($rootPath)));

		?><li>
			<a href = "<?=$linkPath;?>" <?= getenv('CURRENT_PAGE') === $linkPath ? 'class="active-link"' : ''; ?>>
				<?=$title?>
			</a>
		</li><?php
	}

	?></ul><?php
}
