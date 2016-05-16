<?php
error_reporting(0);
if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])){
		header('HTTP/1.1 304 Not Modified');
        die();
}
 header('Cache-control: max-age='.(60*60*24*15));
 header('Expires: '.gmdate(DATE_RFC1123,time()+60*60*24*15));
 header('Last-Modified: '.gmdate(DATE_RFC1123,time()));

$all_file= glob("split/*.txt");


if(!isset($_GET['page']) || empty($_GET['page'])){
$pagi= 1;
$page_title= '';
}else{
$pagi= $_GET['page'];
$page_title= ' Page '.$_GET['page'];
}

$nomor_file= $pagi-1;

$total_row= count($all_file)+1;

$max_page= $total_row;

if($pagi > $max_page){
header('location: /');
exit();
}

$posisi_file= $all_file[$nomor_file];

$array= array_filter(explode("\n", file_get_contents($posisi_file)));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $_SERVER['SERVER_NAME'].$page_title;?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<meta name="description" content="Download free manual of all ebook - <?php echo $_SERVER['SERVER_NAME'].$page_title;?> get your ebook without pay"/>

<?php
$nextpage= $pagi+1;
$prevpage= $pagi-1;
if($pagi > 2){
echo '
<link rel="prev" href="http://'.$_SERVER['SERVER_NAME'].'/this/page/'.$prevpage.'">
';
}

if($pagi < $max_page){
echo '
<link rel="next" href="http://'.$_SERVER['SERVER_NAME'].'/this/page/'.$nextpage.'">
';
}
?>
</head>
<body>


<div class="container">
  <h2><a href="/" title="<?php echo $_SERVER['SERVER_NAME'].$page_title;?>"><?php echo $_SERVER['SERVER_NAME'].$page_title;?></a></h2>
  <p>preview <?php echo $_SERVER['SERVER_NAME'].$page_title;?></p>            
  <table class="table">
    <thead>
      <tr>
        <th>No</th>
        <th>File Url</th>
      </tr>
    </thead>
    <tbody>
<?php
$nunu= 0;
foreach($array as $item){
$title= trim($item);
$title= preg_replace('![^a-z0-9]+!i', ' ', $title);
$title= trim($title);
$pdf_url= '/'.strtolower(trim(str_replace(' ', '-', $title),'-')).'.pdf';

echo  '<tr>
        <td>'.$nunu.'</td>
        <td><a href="'.$pdf_url.'" title="'.$title.'">'.$title.'</a></td>
		</tr>';
		

++$nunu;
}
?>
 </tbody>
  </table>

<?php
$nextpage= $pagi+1;
$prevpage= $pagi-1;

echo '<ul class="pagination">';
if($pagi > 2){
echo '<li><a href="/this/page/'.$prevpage.'" rel="prev">PREV</a></li> ';
}

if($pagi < 2){
echo '<li class="disabled"><a href="#">Home</a></li>'; 
}else{
echo '<li class="disabled"><a href="#">Page '.$pagi.'</a></li>'; 
}

if($pagi < $max_page){
echo ' <li><a href="/this/page/'.$nextpage.'" rel="next">NEXT</a></li>';
}
echo '</ul>';

?>
</div>



</body>
</html>