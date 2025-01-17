<?php

$mysqli = new mysqli('localhost', 'root', 'nanoninaze', 'NewsTwit');
$mysqli->set_charset("utf8");

$sitemap = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">';

$i = 0;
$ii = 1;
$result = $mysqli->query("SELECT distinct site_domain_name FROM news");
while ($row = $result->fetch_assoc()) {
	  $i++;
		if ($i > 49900) {
        $sitemap .= '
</urlset>';
        file_put_contents('/var/www/html/sitemap_media' . $ii . '.xml', $sitemap);
        $ii++;
        $i = 0;
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">';
		}
    $sitemap .= '
<url>
  <loc>https://newstwit.jp/media/site/' . $row["site_domain_name"] . '</loc>
	<lastmod>' . date('Y-m-d\TH:i:s+00:00') . '</lastmod>
</url>';
}
$sitemap .= '
</urlset>';
file_put_contents('/var/www/html/sitemap_media' . $ii . '.xml', $sitemap);
?>
