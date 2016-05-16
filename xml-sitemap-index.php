<?php
date_default_timezone_set('Africa/Lagos');
header('X-Robots-Tag: noindex,follow,noarchive,notranslate,noodp', true);

	//CACHE
	if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])){
		header('HTTP/1.1 304 Not Modified');
        die();
}
 header('Cache-control: max-age='.(60*60*24*15));
 header('Expires: '.gmdate(DATE_RFC1123,time()+60*60*24*15));
 header('Last-Modified: '.gmdate(DATE_RFC1123,time()));
	//END CACHE
	
header('Content-Type: text/xml');
if (isset($_SERVER['HTTPS']) &&
    ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
  $protokol = 'https://';
}
else {
  $protokol = 'http://';
}

echo '<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/xsl" href="/css-sitemap-index.xsl"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

foreach(glob('split/*.txt') as $file) {
$file = str_replace(array('split/','.txt'), '', $file);

$as = $protokol.$_SERVER["HTTP_HOST"].'/file-sitemap/'.$file.'.xml';
echo '
<sitemap>
<loc>
'.$as.'
</loc>
<lastmod>'.date('c').'</lastmod>
</sitemap>
';

}

echo '</sitemapindex>';
?>