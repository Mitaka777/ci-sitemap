<?php header("Content-type: text/plain; charset=utf-8");

foreach($items as $item)
{
    echo $item['loc'] . "\n";
}