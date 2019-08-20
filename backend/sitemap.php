<?php
if ( ! $settings->enableCrawl)
{
	header('Location: ' . URL . $settings->language . '/sitemap.xml');
	exit();
}
?>
<?php header('Content-Type: text/xml; charset=UTF-8'); ?>
<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/xsl" href="<?php echo URL; ?>assets/sitemap.xsl"?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

<?php
$langs = array();
$i = 0;
if ($dizin = opendir(DIR . 'theme/backend/data/'))
{
	while (false !== ($dosya = readdir($dizin)))
	{
		if ($dosya[0] !== '.')
		{
			$langs[$i] = $dosya;
			$i++;
		}
	}
}

// Creating pages in array
$objects = new RecursiveIteratorIterator(
 new RecursiveDirectoryIterator(DIR . 'theme/pages/'), RecursiveIteratorIterator::SELF_FIRST
);

$i = 0;
$STRLENOFDIR = strlen(DIR) + 12;
const DOTHTMLSTRLEN = 5;
const INDEXSTRLEN = 5;

foreach($objects as $name => $obj)
{
	if ( ! is_dir($name))
	{
		foreach ($langs as $lang) {
			// Delete DIR from start and .html from end. Also if page name index, delete index
			// NOTE: It works don't touch it
			$sayfalar[$i] = URL . $lang . '/' . substr($name, $STRLENOFDIR, -DOTHTMLSTRLEN - ((substr($name, -(INDEXSTRLEN + DOTHTMLSTRLEN)) === 'index.html') ? INDEXSTRLEN : 0 ));
			$i++;
		}
	}
}

$lastmod = date('Y-m-d\TH:i:00+00:00', filemtime(DIR . 'theme/backend/data'));
?>

<?php foreach ($sayfalar as $sayfa): ?>
	<url>
  	<loc><?php echo $sayfa; ?></loc>
  	<lastmod><?php echo $lastmod ?></lastmod>
	</url>
<?php endforeach; ?>


</urlset>
