<?php

function loop($name)
{
	$displayName = ucwords(trim(str_replace('-', ' ', basename($name))));

	?><details open><summary><?=$displayName;?></summary><ul><?php

	$dir = new \DirectoryIterator($name);

	foreach($dir as $entry)
	{
		$filename = $entry->getFilename();
		$pathname = $entry->getPathname();

		if($filename === '.' || $filename === '..')
		{
			continue;
		}

		if(is_dir($pathname))
		{
			loop($pathname);
		}
	}

	foreach($dir as $entry)
	{
		$filename = $entry->getFilename();
		$pathname = $entry->getPathname();

		if(is_dir($pathname))
		{
			continue;
		}

		$frontmatter = yaml_parse(`yq --front-matter=extract $pathname`) ?? [];
		$title = $frontmatter['title'] ?? ucwords(preg_replace(['/\.md$/', '/-/'], ['',  ' '], $filename));
		$leftbar = $frontmatter['leftbar'] ?? true;

		if(!$leftbar)
		{
			continue;
		}

		?><li><a href = "<?=preg_replace(['/^.\/pages/', '/\.\w+$/'], ['', '.html'], $pathname);?>"><?=$title?></a></li>
<?php

	} ?></ul></details><?php
}

?><ul><?php

foreach(new \DirectoryIterator('./pages') as $entry)
{
	$filename = $entry->getFilename();
	$pathname = $entry->getPathname();

	if($filename === '.' || $filename === '..')
	{
		continue;
	}

	if(is_dir($pathname))
	{
		loop($entry->getPathName());
	}
}

foreach(new \DirectoryIterator('./pages') as $entry)
{
	$filename = $entry->getFilename();
	$pathname = $entry->getPathname();

	if($filename === '.' || $filename === '..')
	{
		continue;
	}

	if(is_dir($pathname))
	{
		continue;
	}

	$frontmatter = yaml_parse(`yq --front-matter=extract $pathname`) ?? [];
	$title = $frontmatter['title'] ?? ucwords(preg_replace(['/\.md$/', '/-/'], ['',  ' '], $filename));
	$leftbar = $frontmatter['leftbar'] ?? true;

	if(!$leftbar)
	{
		continue;
	}

	?><li><a href = "<?=preg_replace(['/^.\/pages/', '/\.\w+$/'], ['', '.html'], $pathname);?>"><?=$title?></a></li>
<?php
}
?></ul>
