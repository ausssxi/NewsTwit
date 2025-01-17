<?php

$mysqli = new mysqli('localhost', 'root', 'password', 'NewsTwit');
$mysqli->set_charset("utf8mb4");

$sitemap = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
<url>
  <loc>https://newstwit.jp/</loc>
	<lastmod>' . date('Y-m-d\TH:i:s+00:00') . '</lastmod>
</url>
<url>
  <loc>https://newstwit.jp/entame</loc>
  <lastmod>' . date('Y-m-d\TH:i:s+00:00') . '</lastmod>
</url>
<url>
  <loc>https://newstwit.jp/anime</loc>
  <lastmod>' . date('Y-m-d\TH:i:s+00:00') . '</lastmod>
</url>
<url>
  <loc>https://newstwit.jp/it</loc>
  <lastmod>' . date('Y-m-d\TH:i:s+00:00') . '</lastmod>
</url>
<url>
  <loc>https://newstwit.jp/learn</loc>
  <lastmod>' . date('Y-m-d\TH:i:s+00:00') . '</lastmod>
</url>
<url>
  <loc>https://newstwit.jp/life</loc>
  <lastmod>' . date('Y-m-d\TH:i:s+00:00') . '</lastmod>
</url>
<url>
  <loc>https://newstwit.jp/politics</loc>
  <lastmod>' . date('Y-m-d\TH:i:s+00:00') . '</lastmod>
</url>
<url>
  <loc>https://newstwit.jp/society</loc>
  <lastmod>' . date('Y-m-d\TH:i:s+00:00') . '</lastmod>
</url>
<url>
  <loc>https://newstwit.jp/about</loc>
  <lastmod>' . date('Y-m-d\TH:i:s+00:00') . '</lastmod>
</url>';
for ($i = 1; $i < 9; $i++) {
  $sitemap .= '
<url>
  <loc>https://newstwit.jp/ranking/today/' . $i . '/' . date("Ymd") . '</loc>
  <lastmod>' . date('Y-m-d\TH:i:s+00:00') . '</lastmod>
</url>
<url>
  <loc>https://newstwit.jp/ranking/month/' . $i . '/'  . date("Ym") . '</loc>
  <lastmod>' . date('Y-m-d\TH:i:s+00:00') . '</lastmod>
</url>';
}
$result = $mysqli->query("SELECT distinct site_domain_name FROM news");
while ($row = $result->fetch_assoc()) {
    $encode = urlencode($row["site_domain_name"]);
    $sitemap .= '
<url>
  <loc>https://newstwit.jp/media/site/' . $encode . '</loc>
  <lastmod>' . date('Y-m-d\TH:i:s+00:00') . '</lastmod>
</url>';
}
$sitemap .= '
</urlset>';
file_put_contents('/var/www/html/sitemap.xml', $sitemap);
?>
