User-agent: *
Disallow:
<?php
$domain = $_SERVER['HTTP_HOST'];
$sitemapindex="sitemap: http://$domain/sitemap.xml";
	 echo $sitemapindex;

?>
