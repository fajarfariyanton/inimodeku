<?php
//scan dir

$all= glob("font/*.php");

foreach($all as $item){
$a= '- url: /'.$item.'<br>';
$b= 'hapus script: '.$item.'<br><br>';
	
echo $a.$b;	
}