<?php
/**
 * Created by PhpStorm.
 * User: brent
 * Date: 12/16/18
 * Time: 12:39 PM
 */

namespace CzarCar\RecipeReader\Parsers;


class WordPressRecipeMakerParser extends AbstractParser
{
    public function getTitle()
    {
        $classname = "wprm-recipe-name";
        return $this->finder->query("//*[contains(@class, '$classname')]")->value;
    }

    /**
     * class:  wprm-recipe-ingredients
     */
    public function getIngredients()
    {
        $classname="wprm-recipe-ingredients";
        $nodes = iterator_to_array($this->finder->query("//*[contains(@class, '$classname')]/li"));
        $nodes = array_map(function($node) { return $this->clean($node)."\n"; }, $nodes );
        return $nodes;
    }

    /**www.halfbakedharvest.com
     * class: wprm-recipe-instructions > li > div
     */
    public function getDirections()
    {
        $classname="wprm-recipe-instructions";
        $nodes = iterator_to_array($this->finder->query("//*[contains(@class, '$classname')]/li/div"));
        $nodes = array_map(function($node) { return $this->clean($node)."\n"; }, $nodes );
        $directions = implode("", $nodes);
        return $nodes;
    }
}