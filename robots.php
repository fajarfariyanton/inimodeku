<?php
header("Content-type: text/plain");

echo "User-Agent: *\n";
echo "Allow: /\n";
echo "Sitemap: http://".$_SERVER['SERVER_NAME']."/sitemap-index.xml";
?>