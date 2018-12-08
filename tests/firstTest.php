<?php
/**
 * Created by PhpStorm.
 * User: brent
 * Date: 12/1/18
 * Time: 3:35 PM
 */
require_once __DIR__.'/../vendor/autoload.php';

use CzarCar\RecipeReader\Parsers;
use IvoPetkov\HTML5DOMDocument;

//$w = stream_get_wrappers();
//echo 'openssl: ',  extension_loaded  ('openssl') ? 'yes':'no', "\n";
//echo 'http wrapper: ', in_array('http', $w) ? 'yes':'no', "\n";
//echo 'https wrapper: ', in_array('https', $w) ? 'yes':'no', "\n";
//echo 'wrappers: ', var_export($w);
//die();
//$arrContextOptions=array(
//    "ssl"=>array(
//        "verify_peer"=>false,
//        "verify_peer_name"=>false,
//    ),
//);
//file_get_contents($url, false, stream_context_create($arrContextOptions));

//$html = file_get_contents('https://www.allrecipes.com/recipe/230479/deep-south-eggnog-cake/?internalSource=streams&referringId=276&referringContentType=Recipe%20Hub&clickId=st_trending_b');

//var_dump($html); die();

$parserFactory = new Parsers\ParserFactory(new HTML5DOMDocument());
$rr = new \CzarCar\RecipeReader\RecipeReader(new GuzzleHttp\Client(), $parserFactory);
$parser = $rr->fromUrl('https://www.allrecipes.com/recipe/230479/deep-south-eggnog-cake/?internalSource=streams&referringId=276&referringContentType=Recipe%20Hub&clickId=st_trending_b');


foreach ($parser->getIngredients() as $ingredient) {
    echo $ingredient."\n";
}
echo $parser->getDirections();
