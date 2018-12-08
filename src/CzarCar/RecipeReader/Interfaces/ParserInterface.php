<?php
/**
 * Created by PhpStorm.
 * User: brent
 * Date: 12/2/18
 * Time: 5:46 AM
 */

namespace CzarCar\RecipeReader\Interfaces;


interface ParserInterface
{
    public function getIngredients();

    public function getDirections();
}