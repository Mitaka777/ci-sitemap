<?php header("Content-type: application/xml; charset=utf-8"); ?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<urlset 
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<?php foreach($records as $record): ?>
    <url>
        <loc><?php echo $record['loc'] ?></loc>
        <priority><?php echo $record['priority'] ?></priority>
        <lastmod><?php echo $record['lastmod'] ?></lastmod>
        <changefreq><?php echo $record['freq'] ?></changefreq>
    </url>
<?php endforeach; ?>
</urlset>