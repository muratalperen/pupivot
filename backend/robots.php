<?php header('Content-Type: text/plain'); ?>
<?php if ($settings->enableCrawl): ?>
  User-agent: *
  Allow: /
  Disallow: /admin/
  Sitemap: <?php echo URL; ?>sitemap.xml
<?php else: ?>
  User-agent: *
  Disallow: /
<?php endif; ?>
