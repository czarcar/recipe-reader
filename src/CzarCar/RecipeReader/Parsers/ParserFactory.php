<?php
/**
 * Created by PhpStorm.
 * User: brent
 * Date: 12/1/18
 * Time: 11:07 AM
 */

namespace CzarCar\RecipeReader\Parsers;

use CzarCar\RecipeReader\Interfaces\ParserFactoryInterface;
use CzarCar\RecipeReader\Parsers as P;


class ParserFactory implements ParserFactoryInterface
{
    //protected $domDocument;

    static public $siteSpecificParsers = [
        'www.cookingchanneltv.com' => P\CookingChannelTv::class,
        'www.allrecipes.com' => P\AllRecipes::class,
        'www.myrecipes.com' => P\MyRecipes::class,
        'www.foodnetwork.com' => P\FoodNetwork::class,
        'www.delish.com' => P\Delish::class,
        //'www.forgottenwayfarms.com' => P\ForgottenWayFarms::class,
        //'www.halfbakedharvest.com' => P\HalfBakedHarvest::class,
    ];

    static public $generalParsers = [
        'wprm-recipe-ingredients' => P\WordPressRecipeMakerParser::class,
//        'wpurp-recipe-ingredient-container' => P\WordPressUltimateRecipe::class /* www.wpultimaterecipe.com */
    ];

    public function __construct()
    {
        //$this->domDocument = $domDocument;
    }

    public function create($hostname, $body)
    {
        $parser = false;
        if (empty($parser)) {
            $parser = $this->checkSiteSpecific($hostname);
        }
        if (empty($parser)) {
            $parser = $this->guessAbstract($body);
        }
        if (empty($parser)) {
            throw new \Exception("No Parser available for {$hostname}");
        }

        return $this->createClass($parser);
    }

    protected function guessAbstract($text)
    {
        foreach(self::$generalParsers as $identifier => $parser) {

            if(stripos($text, $identifier)) {
                return $parser;
            }
        }

        return false;
        //throw new \Exception("No general parser used");
    }

    protected function checkSiteSpecific($hostname)
    {
        if(isset(self::$siteSpecificParsers[$hostname])) {
            return self::$siteSpecificParsers[$hostname];
        }

        return false;
        //throw new \Exception("No site specific parser available for {$hostname}");
    }

    protected function createClass($className)
    {
        return new $className();
    }

}