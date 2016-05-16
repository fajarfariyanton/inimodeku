<?php
header("Content-type: text/plain");

if (isset($_SERVER['HTTPS']) &&
    ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
  $protokol = 'https://';
}
else {
  $protokol = 'http://';
}

echo "User-Agent: *\n";
echo "Allow: /\n";
echo "Sitemap: ".$protokol.$_SERVER['SERVER_NAME']."/sitemap-index.xml";
?>
