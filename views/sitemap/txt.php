<?php
header("Content-type: text/plain");
foreach($items as $item) echo $item['loc']."\n";