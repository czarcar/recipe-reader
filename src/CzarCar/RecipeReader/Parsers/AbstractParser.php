<?php
/**
 * User: brent
 * Date: 12/1/18
 * Time: 12:15 PM
 */
namespace CzarCar\RecipeReader\Parsers;

use CzarCar\RecipeReader\Interfaces\ParserInterface;
use IvoPetkov\HTML5DOMDocument;

abstract class AbstractParser implements ParserInterface
{
    /**
     * @var string
     */
    protected $html;

    /**
     * @var HTML5DOMDocument
     */
    protected $dom;

    /**
     * @var \Dom
     */
    protected $finder;

    public function getHtml()
    {
        return $this->html;
    }

    public function setHtml($html)
    {
        $this->html = $html;
        $this->parse();
        return $this;
    }

    protected function parse()
    {
        if(!empty($this->html)) {
            $this->dom = new HTML5DOMDocument($html = '');
            $this->dom->loadHTML($this->html);
            $this->finder = new \DomXPath($this->dom);
        }
        return $this;
    }

    protected function clean($dirtyText)
    {
        return trim(preg_replace('~\s\s+~', ' ', strip_tags($dirtyText)));
    }
}