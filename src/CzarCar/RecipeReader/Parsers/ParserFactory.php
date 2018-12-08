<?php
/**
 * Created by PhpStorm.
 * User: brent
 * Date: 12/1/18
 * Time: 11:07 AM
 */

namespace CzarCar\RecipeReader\Parsers;

use CzarCar\RecipeReader\Interfaces\ParserFactoryInterface;



class ParserFactory implements ParserFactoryInterface
{
    protected $domDocument;

    static public $availableParsers = [
        'www.cookingchanneltv.com' => 'CzarCar\RecipeReader\Parsers\CookingChannelTv',
        'www.allrecipes.com' => 'CzarCar\RecipeReader\Parsers\AllRecipes',
        'www.myrecipes.com' => 'CzarCar\RecipeReader\Parsers\MyRecipes',
        'www.foodnetwork.com' => 'CzarCar\RecipeReader\Parsers\FoodNetwork',
        'www.delish.com' => 'CzarCar\RecipeReader\Parsers\Delish'
    ];

    public function __construct(\DOMDocument $domDocument)
    {
        $this->domDocument = $domDocument;
    }

    public function create($hostname)
    {
        if(!isset(self::$availableParsers[$hostname])) {
            throw new \Exception("No Parser available for {$hostname}");
        }

        return new static::$availableParsers[$hostname]($this->domDocument);
    }


}