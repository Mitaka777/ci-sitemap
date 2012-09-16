<?php header("Content-type: text/xml; charset=utf-8"); ?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<?php foreach($items as $item): ?>
    <url>
        <loc><?php echo $item['loc'] ?></loc>
        <priority><?php echo $item['priority'] ?></priority>
        <lastmod><?php echo date('Y-m-d\TH:i:sP', strtotime($item['lastmod'])) ?></lastmod>
        <changefreq><?php echo $item['freq'] ?></changefreq>
    </url>
<?php endforeach; ?>
</urlset>