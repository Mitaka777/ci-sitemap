<?php header("Content-type: text/rss+xml; charset=utf-8"); ?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<rss version="2.0" xmlns:ror="http://rorweb.com/0.1/" >
<channel>
    <title><?php echo $channel['title']; ?></title>
    <link><?php echo $channel['link']; ?></link>
<?php foreach($items as $item): ?>
    <item>
        <link><?php echo $item['loc'] ?></link>
        <title><?php echo $item['title'] ?></title>
        <ror:updated><?php echo date('Y-m-d\TH:i:sP', strtotime($item['lastmod'])) ?></ror:updated>
        <ror:updatePeriod><?php echo $item['freq'] ?></ror:updatePeriod>
        <ror:sortOrder><?php echo $item['priority'] ?></ror:sortOrder>
        <ror:resourceOf>sitemap</ror:resourceOf>
    </item>
    <?php endforeach; ?>
</channel>
</rss>