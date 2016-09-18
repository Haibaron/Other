<?php
function caiji_data(){
	include 'phpQuery.php'; 
	date_default_timezone_set("Asia/Shanghai");
	include 'conn.php'; 
	$doc = phpQuery::newDocumentFile('http://blog.sina.com.cn/s/articlelist_1233227211_0_1.html'); 
	phpQuery::selectDocument($doc);
	$artlist = pq(".articleCell .atc_title"); 
	foreach($artlist as $li){ 
		$sublink = pq($li)->find('a')->attr('href'); 
		$subdoc = phpQuery::newDocumentFile($sublink); 
		phpQuery::selectDocument($subdoc);
		$a['catalog_id'] = rand(1,5);
		$a['title'] = '"'.pq(".titName")->text().'"';
		$content = pq("#sina_keyword_ad_area2 p:eq(3)");
		$a['desc'] = '"'.$content->text().'"';
		$a['content'] = '"'.addslashes(pq("#sina_keyword_ad_area2")->html()).'"';
		$a['create_time'] = '"'.strtotime(substr(pq('.time')->text(),1,-1)).'"';
		$s = implode(',', $a);
		$sql = "insert into article values(null,$s,null,null)";
		mysqli_query($conn,$sql);
	} 
}
function caiji_img(){
	for ($i=1; $i < 3; $i++) { 
		$img = file_get_contents('https://unsplash.it/400/220/?'.rand(1,200));
		file_put_contents("img/$i.jpg", $img);
	}
}
caiji_img();