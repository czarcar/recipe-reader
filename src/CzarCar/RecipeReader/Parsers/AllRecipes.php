<?php
/**
 * Created by PhpStorm.
 * User: brent
 * Date: 12/1/18
 * Time: 12:04 PM
 */

namespace CzarCar\RecipeReader\Parsers;



class AllRecipes extends AbstractParser
{
    /**
     * class:  o-Ingredients__a-ListItemText
     */
    public function getIngredients()
    {
        $classname="recipe-ingred_txt";
        $nodes = iterator_to_array($this->finder->query("//*[contains(@class, '$classname')]"));
        $nodes = array_map(function($node) { return $this->clean($node); }, $nodes );
        $nodes = array_filter($nodes);
        $lastElement = array_pop($nodes);
        if ($lastElement != 'Add all ingredients to list') { array_push($nodes,$lastElement); }
        return $nodes;
    }

    /**
     * class: o-Method__m-Body > p
     */
    public function getDirections()
    {
        $classname="recipe-directions__list--item";
        $nodes = iterator_to_array($this->finder->query("//*[contains(@class, '$classname')]"));
        $nodes = array_map(function($node) { return $this->clean($node)."\n"; }, $nodes );
        $directions = implode("", $nodes);
        return $directions;
    }
}