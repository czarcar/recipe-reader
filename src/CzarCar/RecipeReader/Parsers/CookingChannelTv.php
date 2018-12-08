<?php
/**
 * Created by PhpStorm.
 * User: brent
 * Date: 12/1/18
 * Time: 12:04 PM
 */

namespace CzarCar\RecipeReader\Parsers;



class CookingChannelTv extends AbstractParser
{
    /**
     * class:  o-Ingredients__a-ListItemText
     */
    public function getIngredients()
    {
        $classname="o-Ingredients__a-ListItemText";
        $nodes = iterator_to_array($this->finder->query("//*[contains(@class, '$classname')]"));
        $nodes = array_map(function($node) { return $this->clean($node)."\n"; }, $nodes );
        return $nodes;
    }

    /**
     * class: o-Method__m-Body > p
     */
    public function getDirections()
    {
        $classname="o-Method__m-Body";
        $nodes = iterator_to_array($this->finder->query("//*[contains(@class, '$classname')]/p"));
        $nodes = array_map(function($node) { return $this->clean($node)."\n"; }, $nodes );
        $directions = implode("", $nodes);
        return $directions;
    }
}