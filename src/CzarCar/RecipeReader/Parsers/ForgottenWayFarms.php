<?php
/**
 * Created by PhpStorm.
 * User: brent
 * Date: 12/1/18
 * Time: 12:04 PM
 */

namespace CzarCar\RecipeReader\Parsers;



class ForgottenWayFarms extends AbstractParser
{
    public function getTitle()
    {
        $classname = "wprm-recipe-name";
        return $this->finder->query("//*[contains(@class, '$classname')]")->value;
    }

    /**
     * class:  o-Ingredients__a-ListItemText
     */
    public function getIngredients()
    {
        $classname="wprm-recipe-ingredients";
        $nodes = iterator_to_array($this->finder->query("//*[contains(@class, '$classname')]/li"));
        $nodes = array_map(function($node) { return $this->clean($node)."\n"; }, $nodes );
        return $nodes;
    }

    /**
     * class: o-Method__m-Body > p
     */
    public function getDirections()
    {
        $classname="wprm-recipe-instructions";
        $nodes = iterator_to_array($this->finder->query("//*[contains(@class, '$classname')]/li/div"));
        $nodes = array_map(function($node) { return $this->clean($node)."\n"; }, $nodes );
//        $directions = implode("", $nodes);
        return $nodes;
    }
}