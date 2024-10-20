<?php

function makeNavBar($name)
{
	$directories = [];
	$files = [];

	?><ul><?php
	$dir = new \DirectoryIterator($name);
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
			$frontmatter = yaml_parse(`yq --front-matter=extract $pathname/.fm.yaml 2>/dev/null|| echo ""`) ?? [];
			$directories[] = (object)[ 'filename' => $filename, 'pathname' => $pathname, 'frontmatter' => $frontmatter ];
			continue;
		}

		$frontmatter = yaml_parse(`yq --front-matter=extract $pathname 2>/dev/null|| echo ""`) ?? [];

		if(!($frontmatter['leftbar'] ?? true))
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

		$displayName = ucwords(trim(str_replace('-', ' ', basename($filename))));

		?><details open>
			<summary><?=$displayName;?></summary>
			<?=makeNavBar($pathname);?>
		</details><?php
	}

	foreach($files as $entry)
	{
		$filename = $entry->filename;
		$pathname = $entry->pathname;
		$frontmatter = $entry->frontmatter;

		$title = $frontmatter['title'] ?? ucwords(preg_replace(['/\.md$/', '/-/'], ['',  ' '], $filename));
		$leftbar = $frontmatter['leftbar'] ?? true;

		?><li>
			<a href = "<?=preg_replace(['/^.\/pages/', '/\.\w+$/'], ['', '.html'], $pathname);?>">
				<?=$title?>
			</a>
		</li><?php
	}

	?></ul><?php
}

makeNavBar('./pages');
