<?php

function htmlToJson($xml) {
    $json = '';
    $xmlDoc = new DOMDocument();
    $xmlString = $xml;

    $xmlString = substr($xmlString, strpos($xmlString,'<ul class="productLister listView">')); //Eleje levágása
    $xmlString = trim(substr($xmlString, 0, strrpos($xmlString,'<h2 class="access">Product pagination</h2>'))); //Vége levágása

    $htmlBegin = '<html><head></head><body>';
    $htmlEnd   = '</body></html>';

    $xmlString = $htmlBegin.$xmlString.$htmlEnd;
    $xmlDoc->loadHTML($xmlString); 
           
    $DOMNodeBody = $xmlDoc->getElementsByTagName('div');

    $ProductList = new Page();

    foreach ($DOMNodeBody as $DOMNodeProduct) { //itt egy li-be lépünk bele
        
        if ("productInner" == $DOMNodeProduct->getAttribute("class") && $DOMNodeProduct->hasChildNodes()){ 

            ////Adatok lekérdezése, és a hozzátartozó link lekérdezése
            $productDatas = $DOMNodeProduct->getElementsByTagName('div');
            $title = '';
            $href  = '';
            foreach ($productDatas as $productData){
                if ($productData->hasAttributes() && $productData->getAttribute('class') == 'productInfo' && $productData->hasChildNodes()){ 
                    $title = $productData->getElementsByTagName('h3')->item(0)->nodeValue;
                    $title = trim($title);
                    $href = $productData->getElementsByTagName('a')->item(0);
                    if ($href->hasAttributes()){
                        $href = $href->getAttribute('href'); //URL lekérdezése

                    } else {
                        $href = '';
                    }
                    $productJson = loadFile($href);
                    $data = $productJson;
                    $data = json_decode($data);
                    
                    if ($data && is_array($data->products) && count($data->products)>0){

                        $data        = $data->products[0];
                        $title       = $data->name;
                        $unit_price  = $data->unit_price->price;
                        $description = trim(implode(', ', $data->description), ', ');

                        $product = new Product($title, 0, $unit_price, $description);
                        
                        $ProductList->addProduct($product);
                    }
                                   
                    break;
                }
          }
           
        }


    }

    $json = $ProductList->getAllProductsToJson();
    return $json;
}
function getXml($url_get){
    
    $url=$url_get;

    $url.='/mp/get?mpsrc=http://mybucket.s3.amazonaws.com/11111.mpg&mpaction=convert format=flv';
    $ua = 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0';
    
    $curlSession = curl_init($url);
    curl_setopt($curlSession, CURLOPT_TIMEOUT, 60);
    
    curl_setopt($curlSession,CURLOPT_URL, $url);

    curl_setopt($curlSession, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curlSession, CURLOPT_USERAGENT, $ua);
    curl_setopt($curlSession, CURLOPT_COOKIESESSION, true);
    curl_setopt($curlSession, CURLOPT_COOKIE, 'emese');
    curl_setopt($curlSession, CURLOPT_COOKIEFILE, 'lala.txt');
    curl_setopt($curlSession, CURLOPT_COOKIELIST, true);
    curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlSession, CURLOPT_COOKIEJAR, 'cookie.txt');

    curl_setopt($curlSession, CURLOPT_AUTOREFERER, true);
    curl_setopt($curlSession, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curlSession, CURLOPT_MAXREDIRS, 500);
    

    curl_setopt($curlSession, CURLOPT_POST, false);
    

    $data = curl_exec($curlSession);

    curl_close($curlSession);
    return $data;
}

function loadFile($url){
     

    $findToTrim = 'https://www.sainsburys.co.uk/shop/gb/groceries/product/details/';
    $get   =  urlencode(substr($url, strlen($findToTrim)));
    $json  =  getXml("https://www.sainsburys.co.uk/groceries-api/gol-services/product/v1/product?filter[product_seo_url]=gb%2Fgroceries%2F".$get."&include[ASSOCIATIONS]=true");

    return $json;
}
?>