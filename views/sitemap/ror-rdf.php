<?php header("Content-type: text/rdf+xml; charset=utf-8"); ?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<rdf:RDF xmlns="http://rorweb.com/0.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
<Resource rdf:about="sitemap">
    <title><?php echo $channel['title']; ?></title>
    <url><?php echo $channel['link']; ?></url>
    <type>sitemap</type>
</Resource>
<?php foreach($items as $item): ?>
<Resource>
    <url><?php echo $item['loc'] ?></url>
    <title><?php echo $item['title'] ?></title>
    <updated><?php echo date('Y-m-d\TH:i:sP', strtotime($item['lastmod'])) ?></updated>
    <updatePeriod><?php echo $item['freq'] ?></updatePeriod>
    <sortOrder><?php echo $item['priority'] ?></sortOrder>
    <resourceOf rdf:resource="sitemap"/>
</Resource>
<?php endforeach; ?>
</rdf:RDF>