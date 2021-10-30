<?php
require_once __DIR__.'/include/classes/Page.php';
require_once __DIR__.'/include/xmlsAndJsonsFunctions.php';

$url = 'https://www.sainsburys.co.uk/webapp/wcs/stores/servlet/CategoryDisplay?listView=true&orderBy=FAVOURITES_FIRST&parent_category_rn=12518&top_category=12518&langId=44&beginIndex=0&pageSize=20&catalogId=10137&searchTerm=&categoryId=185749&listId=&storeId=10151&promotionId=#langId=44&storeId=10151&catalogId=10137&categoryId=185749&parent_category_rn=12518&top_category=12518&pageSize=20&orderBy=FAVOURITES_FIRST&searchTerm=&beginIndex=0&hideFilters=true';

$data = getXml($url);
$json = htmlToJson($data);

var_dump($json);
exit($json);

?>