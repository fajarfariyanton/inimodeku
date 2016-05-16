<?php
date_default_timezone_set('Africa/Lagos');

	//CACHE
	if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])){
		header('HTTP/1.1 304 Not Modified');
        die();
}
 header('Cache-control: max-age='.(60*60*24*30));
 header('Expires: '.gmdate(DATE_RFC1123,time()+60*60*24*30));
 header('Last-Modified: '.gmdate(DATE_RFC1123,time()));
 header('X-Robots-Tag: noindex,follow,noarchive,notranslate,noodp', true);
	//END CACHE

header('Content-Type: text/xml');
if (isset($_SERVER['HTTPS']) &&
    ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
  $protokol = 'https://';
}else{
  $protokol = 'http://';
}

$file = 'split/'.$_GET['file'];

if(!file_exists($file)){
echo 'file sitemap not found';
exit();
}

$array = array_filter(explode("\n", file_get_contents($file)));


echo '<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/xsl" href="/css-sitemap-single.xsl"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';


foreach($array as $item){
$title= trim($item);
$slug= trim(preg_replace('![^a-z0-9]+!i', '-', $title), '-').'.pdf';

		echo '<url>
			<loc>
			'.$protokol.$_SERVER["SERVER_NAME"].'/'.$slug.'
			</loc>
			<lastmod>'.date('c').'</lastmod>
			<changefreq>Daily</changefreq>
			<priority>1</priority>
			</url>
			';
		}

echo '</urlset>';

?>